<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@rssehat.co.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '02112345678',
            'is_active' => true,
        ]);

        // Create Sample Doctors
        $doctors = [
            [
                'doctor_id' => 'DOC001',
                'name' => 'Dr. Ahmad Santoso, Sp.PD',
                'specialty' => 'Spesialis Penyakit Dalam',
                'consultation_fee' => 250000,
                'experience_years' => 15,
                'description' => 'Pengalaman 15 tahun menangani penyakit dalam, diabetes, hipertensi, dan gangguan metabolik.',
                'skills' => ['Diabetes', 'Hipertensi', 'Gangguan Metabolik'],
                'color' => 'blue',
                'is_active' => true,
            ],
            [
                'doctor_id' => 'DOC002',
                'name' => 'Dr. Sari Indrawati, Sp.OG',
                'specialty' => 'Spesialis Kandungan',
                'consultation_fee' => 300000,
                'experience_years' => 12,
                'description' => 'Ahli dalam kesehatan reproduksi wanita, kehamilan, persalinan, dan program bayi tabung.',
                'skills' => ['Kehamilan', 'Persalinan', 'Program Bayi Tabung'],
                'color' => 'pink',
                'is_active' => true,
            ],
            [
                'doctor_id' => 'DOC003',
                'name' => 'Dr. Budi Hartono, Sp.A',
                'specialty' => 'Spesialis Anak',
                'consultation_fee' => 150000,
                'experience_years' => 12,
                'description' => 'Berpengalaman 12 tahun dalam perawatan kesehatan anak, imunisasi, dan tumbuh kembang.',
                'skills' => ['Imunisasi', 'Tumbuh Kembang', 'Kesehatan Anak'],
                'color' => 'green',
                'is_active' => true,
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }

        $this->command->info('✅ Admin dan Dokter berhasil dibuat!');
        $this->command->info('Admin Login:');
        $this->command->info('Email: admin@rssehat.co.id');
        $this->command->info('Password: admin123');
    }
}