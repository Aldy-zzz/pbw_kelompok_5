@extends('layouts.app')

@section('title', 'Dashboard Pasien - RS Sehat Sejahtera')

@section('content')
<!-- Patient Header -->
<div class="bg-gradient-to-r from-green-600 to-blue-600 text-white p-6">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">Dashboard Pasien</h2>
            <p class="opacity-90">Informasi lengkap tentang pendaftaran Anda</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-sm opacity-75">{{ $patient->patient_id }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-white bg-opacity-20 px-4 py-2 rounded-lg hover:bg-opacity-30">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Patient Dashboard Content -->
<div class="container mx-auto px-4 py-8">
    
    @if($activeAppointment)
    <!-- Active Appointment Card -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Status Pendaftaran</h3>
            <div class="inline-block">
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'pending_payment_verification' => 'bg-purple-100 text-purple-800 border-purple-200',
                        'paid' => 'bg-green-100 text-green-800 border-green-200',
                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                        'completed' => 'bg-gray-100 text-gray-800 border-gray-200',
                    ];
                    
                    $statusLabels = [
                        'pending' => 'Menunggu Konfirmasi',
                        'confirmed' => 'Dikonfirmasi',
                        'pending_payment_verification' => 'Menunggu Verifikasi Pembayaran',
                        'paid' => 'Lunas',
                        'cancelled' => 'Dibatalkan',
                        'completed' => 'Selesai',
                    ];
                @endphp
                <span class="px-4 py-2 text-sm font-semibold rounded-full border {{ $statusClasses[$activeAppointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusLabels[$activeAppointment->status] ?? $activeAppointment->status }}
                </span>
            </div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-3">Informasi Pasien</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama:</span>
                        <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Pendaftaran:</span>
                        <span class="font-mono font-bold text-blue-600">{{ $activeAppointment->appointment_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Telepon:</span>
                        <span>{{ auth()->user()->phone }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-3">Detail Janji Temu</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dokter:</span>
                        <span class="font-semibold">{{ $activeAppointment->doctor->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal:</span>
                        <span>{{ $activeAppointment->formatted_date }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Waktu:</span>
                        <span>{{ $activeAppointment->formatted_time }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya:</span>
                        <span class="font-bold text-green-600">{{ $activeAppointment->formatted_fee }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Information (if confirmed) -->
    @if($activeAppointment->status === 'confirmed')
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
            </svg>
            Informasi Pembayaran
        </h3>
        
        <div class="bg-gradient-to-r from-blue-50 to-green-50 p-6 rounded-xl mb-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4">Transfer ke Rekening:</h4>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 p-3 bg-white rounded-lg">
                            <div class="w-10 h-10 bg-blue-600 rounded flex items-center justify-center">
                                <span class="text-white font-bold text-sm">BCA</span>
                            </div>
                            <div>
                                <p class="font-semibold">Bank BCA</p>
                                <p class="text-sm text-gray-600">1234567890</p>
                                <p class="text-sm text-gray-600">a.n. RS Sehat Sejahtera</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-white rounded-lg">
                            <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center">
                                <span class="text-white font-bold text-sm">BNI</span>
                            </div>
                            <div>
                                <p class="font-semibold">Bank BNI</p>
                                <p class="text-sm text-gray-600">0987654321</p>
                                <p class="text-sm text-gray-600">a.n. RS Sehat Sejahtera</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4">Detail Pembayaran:</h4>
                    <div class="bg-white p-4 rounded-lg">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Biaya Konsultasi:</span>
                                <span>{{ $activeAppointment->formatted_fee }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Admin:</span>
                                <span>Rp 5.000</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total:</span>
                                <span class="text-green-600">Rp {{ number_format($activeAppointment->consultation_fee + 5000, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upload Payment Proof -->
        <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-xl">
            <h4 class="font-semibold text-yellow-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h8c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-5 2h2v3l1-1 1 1V4h2v5l-2-2-2 2V4z"/>
                </svg>
                Upload Bukti Pembayaran
            </h4>
            <p class="text-yellow-700 text-sm mb-4">Setelah melakukan transfer, upload bukti pembayaran untuk konfirmasi.</p>
            
            <form id="upload-payment-form" class="flex flex-col sm:flex-row gap-4">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $activeAppointment->appointment_id }}">
                <input type="file" id="payment-proof" name="payment_proof" accept="image/*" required class="flex-1 px-4 py-3 border border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                <button type="submit" class="bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 font-semibold">
                    Upload Bukti
                </button>
            </form>
            
            <div class="mt-3 text-xs text-yellow-600">
                <p>• Format yang didukung: JPG, PNG, GIF</p>
                <p>• Ukuran maksimal: 5MB</p>
                <p>• Pastikan gambar jelas dan mudah dibaca</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Instructions based on status -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Petunjuk Selanjutnya</h3>
        
        @if($activeAppointment->status === 'pending')
            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                <h4 class="font-semibold text-yellow-800 mb-2">⏳ Menunggu Konfirmasi</h4>
                <p class="text-yellow-700 text-sm">Pendaftaran Anda sedang diproses oleh admin rumah sakit. Kami akan menghubungi Anda dalam 1x24 jam untuk konfirmasi jadwal.</p>
            </div>
        @elseif($activeAppointment->status === 'confirmed')
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                <h4 class="font-semibold text-blue-800 mb-2">✅ Janji Temu Dikonfirmasi</h4>
                <p class="text-blue-700 text-sm mb-3">Janji temu Anda telah dikonfirmasi. Silakan lakukan pembayaran untuk mengamankan slot konsultasi.</p>
                <div class="bg-blue-100 p-3 rounded">
                    <p class="text-blue-800 text-sm font-semibold">Langkah selanjutnya:</p>
                    <ol class="text-blue-700 text-sm mt-2 space-y-1">
                        <li>1. Transfer sesuai nominal yang tertera</li>
                        <li>2. Upload bukti pembayaran</li>
                        <li>3. Tunggu konfirmasi dari admin</li>
                    </ol>
                </div>
            </div>
        @elseif($activeAppointment->status === 'pending_payment_verification')
            <div class="bg-purple-50 border border-purple-200 p-4 rounded-lg">
                <h4 class="font-semibold text-purple-800 mb-2">🔍 Sedang Diverifikasi</h4>
                <p class="text-purple-700 text-sm">Bukti pembayaran Anda sedang diverifikasi oleh admin. Proses ini biasanya memakan waktu 1-2 jam kerja.</p>
            </div>
        @elseif($activeAppointment->status === 'paid')
            <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
                <h4 class="font-semibold text-green-800 mb-2">💰 Pembayaran Lunas</h4>
                <p class="text-green-700 text-sm mb-3">Pembayaran Anda telah dikonfirmasi. Janji temu siap dilaksanakan sesuai jadwal.</p>
                <div class="bg-green-100 p-3 rounded">
                    <p class="text-green-800 text-sm font-semibold">Persiapan konsultasi:</p>
                    <ul class="text-green-700 text-sm mt-2 space-y-1">
                        <li>• Datang 15 menit sebelum jadwal</li>
                        <li>• Bawa dokumen identitas</li>
                        <li>• Siapkan daftar keluhan</li>
                    </ul>
                </div>
            </div>
        @elseif($activeAppointment->status === 'cancelled')
            <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                <h4 class="font-semibold text-red-800 mb-2">❌ Janji Temu Dibatalkan</h4>
                <p class="text-red-700 text-sm">Janji temu Anda telah dibatalkan. Silakan hubungi customer service untuk informasi lebih lanjut.</p>
            </div>
        @elseif($activeAppointment->status === 'completed')
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-2">✅ Konsultasi Selesai</h4>
                <p class="text-gray-700 text-sm">Terima kasih telah menggunakan layanan kami. Semoga Anda lekas sembuh!</p>
            </div>
        @endif
        
        <div class="mt-8 p-6 bg-blue-50 rounded-xl">
            <h4 class="font-semibold text-blue-800 mb-3">Informasi Penting:</h4>
            <ul class="text-blue-700 text-sm space-y-2">
                <li>• Datang 15 menit sebelum jadwal konsultasi</li>
                <li>• Bawa KTP dan kartu BPJS (jika ada)</li>
                <li>• Siapkan daftar keluhan dan obat yang sedang dikonsumsi</li>
                <li>• Hubungi (021) 123-4567 jika ada perubahan jadwal</li>
            </ul>
        </div>
    </div>
    @endif

    <!-- Appointment History -->
    @if($appointments->count() > 1)
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Janji Temu</h3>
        
        <div class="space-y-4">
            @foreach($appointments as $appointment)
                @if($appointment->id !== $activeAppointment?->id)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-mono font-bold text-blue-600">{{ $appointment->appointment_id }}</p>
                            <p class="font-semibold text-gray-800">{{ $appointment->doctor->name }}</p>
                            <p class="text-sm text-gray-600">{{ $appointment->formatted_date }} • {{ $appointment->formatted_time }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                        </span>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.getElementById('upload-payment-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Mengupload...';
    
    try {
        const response = await fetch('{{ route("patient.upload.payment") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showNotification(data.message, 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    } catch (error) {
        showNotification('Terjadi kesalahan saat mengupload bukti pembayaran.', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});
</script>
@endpush
@endsection