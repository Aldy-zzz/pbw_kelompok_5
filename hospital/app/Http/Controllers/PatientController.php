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
            // Store the image
            $file = $request->file('payment_proof');
            $filename = 'payment_' . $appointment->appointment_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/payments', $filename);

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

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload! Admin akan memverifikasi dalam 1x24 jam.',
                'image_url' => Storage::url('payments/' . $filename)
            ]);

        } catch (\Exception $e) {
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
}