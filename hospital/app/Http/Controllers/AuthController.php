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

    // Unified login - handles both admin and patient
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Try to authenticate without role restriction
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Log for debugging
            \Log::info('User logged in', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ]);
            
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Login berhasil! Selamat datang di dashboard admin.');
            } elseif ($user->role === 'patient') {
                return redirect()->intended(route('patient.dashboard'))
                    ->with('success', "Selamat datang, {$user->name}!");
            }
            
            // If role is not recognized, logout and show error
            \Log::warning('Invalid user role', [
                'user_id' => $user->id,
                'role' => $user->role,
            ]);
            
            Auth::logout();
            $request->session()->invalidate();
            
            return back()->withErrors([
                'email' => 'Role pengguna tidak valid. Silakan hubungi administrator.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ])->onlyInput('email');
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

    // Patient login with Email and Phone (no password needed)
    public function patientLoginWithId(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'phone.required' => 'Nomor HP harus diisi',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)
            ->where('role', 'patient')
            ->first();

        // If user not found
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar! Silakan daftar terlebih dahulu.',
            ])->onlyInput('email');
        }

        // Verify phone number
        if ($user->phone !== $request->phone) {
            return back()->withErrors([
                'phone' => 'Nomor HP tidak sesuai dengan email yang terdaftar!',
            ])->withInput('email');
        }

        // Login the user
        Auth::login($user, true);
        $request->session()->regenerate();

        \Log::info('Patient logged in with email+phone', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        return redirect()->route('patient.dashboard')
            ->with('success', "Selamat datang, {$user->name}!");
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