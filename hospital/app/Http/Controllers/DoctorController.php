<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // JANGAN gunakan __construct() dengan middleware() di Laravel 11+
    
    public function index()
    {
        $doctors = Doctor::where('is_active', true)->get();
        return view('doctors.index', compact('doctors'));
    }

    public function adminIndex()
    {
        // Check authorization
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $doctors = Doctor::latest()->get();
        return view('admin.doctors', compact('doctors'));
    }

    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'consultation_fee' => 'required|integer|min:50000|max:2000000',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'description' => 'nullable|string|max:1000',
            'skills' => 'nullable|string',
            'color' => 'nullable|string|max:7', // Allow hex colors
            'is_active' => 'required|boolean',
        ]);

        $skills = $request->skills ? array_map('trim', explode(',', $request->skills)) : [];

        $doctor = Doctor::create([
            'doctor_id' => Doctor::generateDoctorId(),
            'name' => $request->name,
            'specialty' => $request->specialty,
            'consultation_fee' => $request->consultation_fee,
            'experience_years' => $request->experience_years ?? 0,
            'description' => $request->description,
            'skills' => $skills,
            'color' => $request->color ?? '#3B82F6',
            'is_active' => $request->is_active,
        ]);

        return back()->with('success', "Dr. {$doctor->name} berhasil ditambahkan!");
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $doctor = Doctor::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'consultation_fee' => 'required|integer|min:50000|max:2000000',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'description' => 'nullable|string|max:1000',
            'skills' => 'nullable|string',
            'color' => 'nullable|string|max:7', // Allow hex colors
            'is_active' => 'required|boolean',
        ]);

        $skills = $request->skills ? array_map('trim', explode(',', $request->skills)) : [];

        $doctor->update([
            'name' => $request->name,
            'specialty' => $request->specialty,
            'consultation_fee' => $request->consultation_fee,
            'experience_years' => $request->experience_years ?? 0,
            'description' => $request->description,
            'skills' => $skills,
            'color' => $request->color ?? '#3B82F6',
            'is_active' => $request->is_active,
        ]);

        return back()->with('success', "Data Dr. {$doctor->name} berhasil diupdate!");
    }

    public function toggleStatus($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $doctor = Doctor::findOrFail($id);
        $doctor->update(['is_active' => !$doctor->is_active]);

        $status = $doctor->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Dr. {$doctor->name} berhasil {$status}!");
    }

    public function destroy($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        
        $doctor = Doctor::findOrFail($id);
        
        // Check if doctor has appointments
        if ($doctor->appointments()->count() > 0) {
            return back()->with('error', "Tidak dapat menghapus Dr. {$doctor->name} karena memiliki appointment. Nonaktifkan saja.");
        }

        $name = $doctor->name;
        $doctor->delete();

        return back()->with('success', "Dr. {$name} berhasil dihapus!");
    }

    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor);
    }
}