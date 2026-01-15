<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\AppointmentConfirmed;
use App\Mail\PaymentVerified;

class AdminController extends Controller
{
    // JANGAN gunakan __construct() dengan middleware di Laravel 11+

    public function dashboard()
    {
        // Check authorization
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
        
        $stats = [
            'total_registrations' => Appointment::count(),
            'pending_confirmations' => Appointment::where('status', 'pending')->count(),
            'paid_appointments' => Appointment::where('status', 'paid')->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
        ];

        $recentAppointments = Appointment::with(['patient.user', 'doctor', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments'));
    }

    public function appointments(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $query = Appointment::with(['patient.user', 'doctor', 'payment']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })->orWhere('appointment_id', 'like', "%{$search}%");
        }

        $appointments = $query->latest()->paginate(20);

        return view('admin.appointments', compact('appointments'));
    }

    public function confirmAppointment($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Appointment sudah dikonfirmasi atau dibatalkan.');
        }

        $appointment->update(['status' => 'confirmed']);

        // Send email notification
        try {
            Mail::to($appointment->patient->user->email)
                ->send(new AppointmentConfirmed($appointment));
        } catch (\Exception $e) {
            \Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }

        return back()->with('success', "Appointment {$appointment->appointment_id} berhasil dikonfirmasi!");
    }

    public function cancelAppointment(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $appointment = Appointment::findOrFail($id);
        
        $appointment->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->reason ?? 'Dibatalkan oleh admin',
        ]);

        return back()->with('success', "Appointment {$appointment->appointment_id} berhasil dibatalkan.");
    }

    public function verifyPayment($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $payment = Payment::with('appointment.patient.user')->findOrFail($id);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran sudah diverifikasi atau ditolak.');
        }

        $payment->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        $payment->appointment->update(['status' => 'paid']);

        // Send email notification
        try {
            Mail::to($payment->appointment->patient->user->email)
                ->send(new PaymentVerified($payment->appointment));
        } catch (\Exception $e) {
            \Log::error('Failed to send payment verification email: ' . $e->getMessage());
        }

        return back()->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    public function rejectPayment(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'notes' => $request->notes,
        ]);

        $payment->appointment->update(['status' => 'confirmed']); // Back to confirmed status

        return back()->with('success', 'Pembayaran ditolak. Pasien akan diminta upload ulang.');
    }

    public function checkInPatient($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status !== 'paid') {
            return back()->with('error', 'Hanya appointment yang sudah dibayar yang bisa check-in.');
        }

        $appointment->update(['check_in_time' => now()]);

        return back()->with('success', "Pasien {$appointment->patient->user->name} berhasil check-in!");
    }

    public function checkOutPatient($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $appointment = Appointment::findOrFail($id);

        if (!$appointment->check_in_time) {
            return back()->with('error', 'Pasien belum check-in.');
        }

        $appointment->update([
            'check_out_time' => now(),
            'status' => 'completed'
        ]);

        return back()->with('success', "Pasien {$appointment->patient->user->name} berhasil check-out!");
    }

    public function showAppointmentDetail($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $appointment = Appointment::with(['patient.user', 'doctor', 'payment'])
            ->findOrFail($id);

        return view('admin.appointment-detail', compact('appointment'));
    }

    public function payments(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $query = Payment::with(['appointment.patient.user', 'appointment.doctor', 'verifier']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(20);
        
        // Get counts for stats
        $pendingCount = Payment::where('status', 'pending')->count();
        $verifiedCount = Payment::where('status', 'verified')->count();
        $rejectedCount = Payment::where('status', 'rejected')->count();

        return view('admin.payments', compact('payments', 'pendingCount', 'verifiedCount', 'rejectedCount'));
    }

    public function paymentDetail($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $payment = Payment::with(['appointment.patient.user', 'appointment.doctor', 'verifier'])
            ->findOrFail($id);

        return response()->json($payment);
    }

    public function patients(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $patients = Patient::with(['user', 'appointments.doctor'])
            ->withCount('appointments')
            ->latest()
            ->get();
        
        // Get stats
        $activePatients = Patient::whereHas('appointments', function($query) {
            $query->where('appointment_date', '>=', now()->subMonths(6));
        })->count();
        
        $newThisMonth = Patient::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $totalAppointments = Appointment::count();

        return view('admin.patients', compact('patients', 'activePatients', 'newThisMonth', 'totalAppointments'));
    }

    public function patientDetail($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $patient = Patient::with(['user', 'appointments.doctor'])
            ->withCount('appointments')
            ->findOrFail($id);

        return response()->json($patient);
    }

    public function patientHistory($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $patient = Patient::with(['user'])->findOrFail($id);
        $appointments = Appointment::with(['doctor', 'payment'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->get();

        return response()->json([
            'patient' => $patient,
            'appointments' => $appointments
        ]);
    }

    public function deletePatient($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $patient = Patient::with(['user', 'appointments'])->findOrFail($id);
        
        // Check if patient has appointments and if all are completed
        if ($patient->appointments()->count() > 0) {
            $incompleteAppointments = $patient->appointments()
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->get();
                
            if ($incompleteAppointments->count() > 0) {
                $statusList = $incompleteAppointments->pluck('status')->unique()->implode(', ');
                return back()->with('error', "Tidak dapat menghapus pasien {$patient->user->name} karena masih memiliki appointment yang belum selesai (status: {$statusList}). Pasien hanya bisa dihapus ketika semua appointment sudah selesai atau dibatalkan.");
            }
        }

        DB::beginTransaction();
        
        try {
            $patientName = $patient->user->name;
            $user = $patient->user;
            
            // Delete patient record first
            $patient->delete();
            
            // Delete user account
            $user->delete();
            
            DB::commit();
            
            return back()->with('success', "Pasien {$patientName} berhasil dihapus beserta akun user-nya.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "Gagal menghapus pasien: " . $e->getMessage());
        }
    }

    public function deleteAllPatients()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Hanya admin yang dapat menghapus data.'
            ], 401);
        }

        DB::beginTransaction();

        try {
            // Count data before deletion
            $patientsCount = Patient::count();
            $appointmentsCount = Appointment::count();
            $paymentsCount = Payment::count();
            $patientUsersCount = User::where('role', 'patient')->count();

            if ($patientsCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data pasien yang dapat dihapus.'
                ]);
            }

            // Delete payment proof images
            $payments = Payment::whereNotNull('proof_image')->get();
            foreach ($payments as $payment) {
                if ($payment->proof_image && \Storage::exists('public/' . $payment->proof_image)) {
                    \Storage::delete('public/' . $payment->proof_image);
                }
            }

            // Delete payments
            Payment::truncate();

            // Delete appointments
            Appointment::truncate();

            // Delete patients
            Patient::truncate();

            // Delete patient users (preserve admin and other roles)
            User::where('role', 'patient')->delete();

            // Reset auto increment to start from 1 (which will generate RSH001)
            DB::statement('ALTER TABLE patients AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE appointments AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE payments AUTO_INCREMENT = 1');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "✅ Berhasil menghapus semua data! ({$patientsCount} pasien, {$appointmentsCount} appointment, {$paymentsCount} pembayaran, {$patientUsersCount} user). ID berikutnya akan dimulai dari RSH001."
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting all patients: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createDummyImage(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $imagePath = $request->image_path;
        $fullPath = storage_path('app/public/' . $imagePath);
        
        try {
            // Create directory if it doesn't exist
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Create a simple dummy image content
            $dummyContent = "DUMMY IMAGE CONTENT FOR TESTING - " . date('Y-m-d H:i:s');
            file_put_contents($fullPath, $dummyContent);
            
            return response()->json([
                'success' => true,
                'message' => 'File dummy berhasil dibuat'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat file dummy: ' . $e->getMessage()
            ]);
        }
    }
}