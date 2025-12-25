<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [HomeController::class, 'services'])->name('services');
Route::get('/dokter', [DoctorController::class, 'index'])->name('doctors');
Route::get('/dokter/{id}', [DoctorController::class, 'show'])->name('doctors.show');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Appointment Routes (Public)
Route::get('/daftar', [AppointmentController::class, 'create'])->name('appointment.create');
Route::post('/daftar', [AppointmentController::class, 'store'])->name('appointment.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login pages
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    
    // Admin login
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');
    
    // Patient login (with appointment ID or email)
    Route::post('/patient/login', [AuthController::class, 'patientLogin'])->name('patient.login');
    Route::post('/patient/login-id', [AuthController::class, 'patientLoginWithId'])->name('patient.login.id');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Patient Routes - TANPA middleware() di controller
|--------------------------------------------------------------------------
*/

Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/status/{appointmentId}', [PatientController::class, 'status'])->name('status');
    Route::get('/history', [PatientController::class, 'history'])->name('history');
    Route::post('/upload-payment', [PatientController::class, 'uploadPaymentProof'])->name('upload.payment');
});

/*
|--------------------------------------------------------------------------
| Admin Routes - TANPA middleware() di controller  
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Appointments Management
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{id}', [AdminController::class, 'showAppointmentDetail'])->name('appointments.show');
    Route::post('/appointments/{id}/confirm', [AdminController::class, 'confirmAppointment'])->name('appointments.confirm');
    Route::post('/appointments/{id}/cancel', [AdminController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::post('/appointments/{id}/check-in', [AdminController::class, 'checkInPatient'])->name('appointments.checkin');
    Route::post('/appointments/{id}/check-out', [AdminController::class, 'checkOutPatient'])->name('appointments.checkout');
    
    // Payments Management
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::post('/payments/{id}/verify', [AdminController::class, 'verifyPayment'])->name('payments.verify');
    Route::post('/payments/{id}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');
    
    // Doctors Management
    Route::get('/doctors', [DoctorController::class, 'adminIndex'])->name('doctors');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::post('/doctors/{id}/toggle', [DoctorController::class, 'toggleStatus'])->name('doctors.toggle');
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
});