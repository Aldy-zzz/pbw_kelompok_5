<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClearAllPatients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patients:clear {--force : Force deletion without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all patient data (users, patients, appointments, payments)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('⚠️  PERINGATAN: Ini akan menghapus SEMUA data pasien, appointment, dan pembayaran. Lanjutkan?')) {
                $this->info('Operasi dibatalkan.');
                return 0;
            }
        }

        $this->info('🗑️  Memulai penghapusan data...');

        DB::beginTransaction();

        try {
            // Count data before deletion
            $patientsCount = Patient::count();
            $appointmentsCount = Appointment::count();
            $paymentsCount = Payment::count();
            $patientUsersCount = User::where('role', 'patient')->count();

            $this->info("📊 Data yang akan dihapus:");
            $this->line("   - Pasien: {$patientsCount}");
            $this->line("   - Appointment: {$appointmentsCount}");
            $this->line("   - Pembayaran: {$paymentsCount}");
            $this->line("   - User Pasien: {$patientUsersCount}");
            $this->newLine();

            // Delete payment proof images
            $this->info('🖼️  Menghapus gambar bukti pembayaran...');
            $payments = Payment::whereNotNull('proof_image')->get();
            foreach ($payments as $payment) {
                if ($payment->proof_image && Storage::exists('public/' . $payment->proof_image)) {
                    Storage::delete('public/' . $payment->proof_image);
                }
            }
            $this->info("   ✅ {$payments->count()} gambar dihapus");

            // Delete payments
            $this->info('💳 Menghapus data pembayaran...');
            Payment::truncate();
            $this->info("   ✅ {$paymentsCount} pembayaran dihapus");

            // Delete appointments
            $this->info('📅 Menghapus data appointment...');
            Appointment::truncate();
            $this->info("   ✅ {$appointmentsCount} appointment dihapus");

            // Delete patients
            $this->info('👤 Menghapus data pasien...');
            Patient::truncate();
            $this->info("   ✅ {$patientsCount} pasien dihapus");

            // Delete patient users
            $this->info('🔐 Menghapus user pasien...');
            User::where('role', 'patient')->delete();
            $this->info("   ✅ {$patientUsersCount} user dihapus");

            // Reset auto increment
            $this->info('🔄 Reset auto increment...');
            DB::statement('ALTER TABLE patients AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE appointments AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE payments AUTO_INCREMENT = 1');
            $this->info("   ✅ Auto increment direset");

            DB::commit();

            $this->newLine();
            $this->info('✅ Semua data pasien berhasil dihapus!');
            $this->info('📝 ID berikutnya akan dimulai dari RSH001');
            $this->newLine();

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Terjadi kesalahan: ' . $e->getMessage());
            return 1;
        }
    }
}
