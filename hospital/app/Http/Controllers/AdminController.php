<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
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

        return view('admin.payments', compact('payments'));
    }
}