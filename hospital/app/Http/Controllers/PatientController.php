<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    // JANGAN gunakan __construct() dengan middleware di Laravel 11+
    
    public function dashboard()
    {
        // Check if user is authenticated and is a patient
        if (!auth()->check() || auth()->user()->role !== 'patient') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai pasien terlebih dahulu.');
        }
        
        $patient = auth()->user()->patient;
        
        if (!$patient) {
            return redirect()->route('login')->with('error', 'Data pasien tidak ditemukan.');
        }
        
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'payment'])
            ->latest()
            ->get();

        $activeAppointment = $appointments->whereIn('status', ['pending', 'confirmed', 'paid'])->first();

        return view('patient.dashboard', compact('patient', 'appointments', 'activeAppointment'));
    }

    public function status($appointmentId)
    {
        if (!auth()->check() || auth()->user()->role !== 'patient') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai pasien terlebih dahulu.');
        }
        
        $patient = auth()->user()->patient;
        $appointment = Appointment::where('patient_id', $patient->id)
            ->where('appointment_id', $appointmentId)
            ->with(['doctor', 'payment'])
            ->firstOrFail();

        return view('patient.status', compact('appointment'));
    }

    public function uploadPaymentProof(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'patient') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        
        $request->validate([
            'appointment_id' => 'required|exists:appointments,appointment_id',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        $patient = auth()->user()->patient;
        $appointment = Appointment::where('patient_id', $patient->id)
            ->where('appointment_id', $request->appointment_id)
            ->firstOrFail();

        if ($appointment->status !== 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'Upload bukti pembayaran hanya untuk appointment yang sudah dikonfirmasi.'
            ], 400);
        }

        try {
            // Ensure directory exists with proper permissions
            $directory = storage_path('app/public/payments');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Get the uploaded file
            $file = $request->file('payment_proof');
            
            if (!$file || !$file->isValid()) {
                throw new \Exception('File upload tidak valid atau rusak');
            }
            
            $filename = 'payment_' . $appointment->appointment_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $fullPath = $directory . DIRECTORY_SEPARATOR . $filename;
            
            // Method 1: Try using Laravel's move method
            try {
                $file->move($directory, $filename);
            } catch (\Exception $e) {
                // Method 2: Fallback to copy if move fails
                \Log::warning('Move failed, trying copy method: ' . $e->getMessage());
                
                $tempPath = $file->getRealPath();
                if (!copy($tempPath, $fullPath)) {
                    throw new \Exception('Gagal menyalin file ke storage');
                }
            }
            
            // Verify file was actually saved
            if (!file_exists($fullPath)) {
                throw new \Exception('File tidak ditemukan setelah upload');
            }
            
            // Verify file size
            $fileSize = filesize($fullPath);
            if ($fileSize === 0 || $fileSize === false) {
                @unlink($fullPath);
                throw new \Exception('File yang diupload kosong atau tidak valid');
            }

            // Create or update payment record
            $payment = Payment::updateOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'amount' => $appointment->consultation_fee + 5000, // Adding admin fee
                    'payment_method' => 'transfer',
                    'proof_image' => 'payments/' . $filename,
                    'status' => 'pending',
                ]
            );

            // Update appointment status
            $appointment->update(['status' => 'pending_payment_verification']);

            \Log::info('Payment proof uploaded successfully', [
                'appointment_id' => $appointment->appointment_id,
                'filename' => $filename,
                'size' => $fileSize
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload! Admin akan memverifikasi dalam 1x24 jam.',
                'image_url' => Storage::url('payments/' . $filename)
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Payment upload failed', [
                'appointment_id' => $request->appointment_id ?? 'unknown',
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'file_info' => $request->hasFile('payment_proof') ? [
                    'original_name' => $request->file('payment_proof')->getClientOriginalName(),
                    'size' => $request->file('payment_proof')->getSize(),
                    'mime' => $request->file('payment_proof')->getMimeType(),
                ] : 'no file'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload bukti pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function history()
    {
        if (!auth()->check() || auth()->user()->role !== 'patient') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai pasien terlebih dahulu.');
        }
        
        $patient = auth()->user()->patient;
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'payment'])
            ->latest()
            ->paginate(10);

        return view('patient.history', compact('appointments'));
    }

    public function createAppointment()
    {
        if (!auth()->check() || auth()->user()->role !== 'patient') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai pasien terlebih dahulu.');
        }
        
        $patient = auth()->user()->patient;
        
        if (!$patient) {
            return redirect()->route('login')->with('error', 'Data pasien tidak ditemukan.');
        }
        
        // Check if patient has active appointment (not completed or cancelled)
        $activeAppointment = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'confirmed', 'pending_payment_verification', 'paid'])
            ->with(['doctor', 'payment'])
            ->first();
        
        if ($activeAppointment) {
            // Redirect back to dashboard with message about active appointment
            return redirect()->route('patient.dashboard')
                ->with('warning', 'Anda masih memiliki janji temu yang belum selesai. Silakan selesaikan janji temu tersebut terlebih dahulu.')
                ->with('active_appointment_id', $activeAppointment->appointment_id);
        }
        
        // Get active doctors
        $doctors = \App\Models\Doctor::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('patient.create-appointment', compact('patient', 'doctors'));
    }

    public function storeAppointment(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'patient') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai pasien terlebih dahulu.');
        }
        
        $patient = auth()->user()->patient;
        
        // Check if patient has active appointment (not completed or cancelled)
        $activeAppointment = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'confirmed', 'pending_payment_verification', 'paid'])
            ->first();
        
        if ($activeAppointment) {
            return back()->withInput()
                ->with('error', "Anda masih memiliki janji temu aktif (ID: {$activeAppointment->appointment_id}). Silakan selesaikan janji temu tersebut terlebih dahulu.");
        }
        
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'complaints' => 'required|string|max:1000',
        ], [
            'doctor_id.required' => 'Pilih dokter terlebih dahulu',
            'appointment_date.required' => 'Tanggal appointment harus diisi',
            'appointment_date.after' => 'Tanggal appointment minimal besok',
            'appointment_time.required' => 'Waktu appointment harus diisi',
            'complaints.required' => 'Keluhan harus diisi',
        ]);

        try {
            $doctor = \App\Models\Doctor::findOrFail($request->doctor_id);
            
            // Generate appointment ID
            $lastAppointment = Appointment::latest('id')->first();
            $nextNumber = $lastAppointment ? intval(substr($lastAppointment->appointment_id, 3)) + 1 : 1;
            $appointmentId = 'RSH' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Create appointment
            $appointment = Appointment::create([
                'appointment_id' => $appointmentId,
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'complaints' => $request->complaints,
                'consultation_fee' => $doctor->consultation_fee,
                'status' => 'pending',
            ]);

            return redirect()->route('patient.dashboard')
                ->with('success', "Janji temu berhasil dibuat! ID Appointment: {$appointmentId}. Silakan tunggu konfirmasi dari admin.");

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal membuat janji temu: ' . $e->getMessage());
        }
    }
}