<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCreated;

class AppointmentController extends Controller
{
    // Public registration - with strict validation
    public function create()
    {
        $doctors = Doctor::active()->get();
        return view('appointment.create', compact('doctors'));
    }

    // Store appointment - only for NEW patients (first time registration)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'doctor_id' => 'required|exists:doctors,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
            'keluhan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // STRICT VALIDATION: Check if email OR phone already exists
            $existingUserByEmail = User::where('email', $request->email)->first();
            $existingUserByPhone = User::where('phone', $request->telepon)->first();
            
            if ($existingUserByEmail || $existingUserByPhone) {
                DB::rollBack();
                
                $message = 'Email atau nomor HP sudah terdaftar! ';
                if ($existingUserByEmail && $existingUserByPhone) {
                    $message .= 'Email dan nomor HP Anda sudah terdaftar di sistem. ';
                } elseif ($existingUserByEmail) {
                    $message .= 'Email Anda sudah terdaftar di sistem. ';
                } else {
                    $message .= 'Nomor HP Anda sudah terdaftar di sistem. ';
                }
                $message .= 'Silakan login untuk membuat janji temu baru.';
                
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'already_registered' => true,
                    'redirect_to_login' => true
                ], 400);
            }

            // Get doctor
            $doctor = Doctor::findOrFail($request->doctor_id);

            // Create NEW user and patient (first time registration)
            $password = Str::random(8);
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => 'patient',
                'phone' => $request->telepon,
                'is_active' => true,
            ]);

            // Create patient record
            $patient = Patient::create([
                'user_id' => $user->id,
                'patient_id' => Patient::generatePatientId(),
                'birth_date' => $request->tanggal_lahir,
                'gender' => $request->jenis_kelamin,
                'address' => $request->alamat,
            ]);

            // Create appointment
            $appointment = Appointment::create([
                'appointment_id' => Appointment::generateAppointmentId(),
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => $request->tanggal,
                'appointment_time' => $request->waktu . ':00',
                'complaints' => $request->keluhan ?? 'Konsultasi umum',
                'status' => 'pending',
                'consultation_fee' => $doctor->consultation_fee,
            ]);

            DB::commit();

            // Send email notification
            try {
                Mail::to($user->email)->send(new AppointmentCreated($appointment, $password));
            } catch (\Exception $e) {
                \Log::error('Failed to send appointment email: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil! Silakan cek email Anda untuk informasi login.',
                'is_new_user' => true,
                'appointment_id' => $appointment->appointment_id,
                'patient_id' => $patient->patient_id,
                'password' => $password,
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'patient_id' => $patient->patient_id,
                    'appointment_id' => $appointment->appointment_id,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $appointment = Appointment::with(['patient.user', 'doctor', 'payment'])
            ->where('appointment_id', $id)
            ->firstOrFail();

        return view('appointment.show', compact('appointment'));
    }
}