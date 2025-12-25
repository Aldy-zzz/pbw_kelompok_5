<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Admin login
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Login berhasil! Selamat datang di dashboard admin.');
        }

        return back()->withErrors([
            'email' => 'Username atau password salah!',
        ])->onlyInput('email');
    }

    // Patient login with appointment ID
    public function patientLoginWithId(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|string',
            'phone' => 'required|string',
        ]);

        // Find appointment by ID
        $appointment = Appointment::where('appointment_id', strtoupper($request->patient_id))
            ->with('patient.user')
            ->first();

        if (!$appointment) {
            return back()->withErrors([
                'patient_id' => 'ID Pendaftaran tidak ditemukan!',
            ]);
        }

        // Verify phone number
        if ($appointment->patient->user->phone !== $request->phone) {
            return back()->withErrors([
                'phone' => 'Nomor telepon tidak sesuai!',
            ]);
        }

        // Login the user
        Auth::login($appointment->patient->user, true);
        $request->session()->regenerate();

        return redirect()->route('patient.dashboard')
            ->with('success', "Selamat datang, {$appointment->patient->user->name}!");
    }

    // Patient login with email
    public function patientLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'patient';

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('patient.dashboard'))
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        $isAdmin = Auth::user()->isAdmin();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isAdmin) {
            return redirect()->route('home')->with('success', 'Logout berhasil!');
        }

        return redirect()->route('home')->with('success', 'Logout berhasil!');
    }
}