@extends('layouts.app')

@section('title', 'Detail Janji Temu - RS Sehat Sejahtera')

@section('content')
<!-- Patient Header -->
<div class="bg-gradient-to-r from-green-600 to-blue-600 text-white p-6">
    <div class="container mx-auto">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('patient.dashboard') }}" class="mr-4 hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition-all">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-bold">Detail Janji Temu</h2>
                    <p class="opacity-90">ID: {{ $appointment->appointment_id }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-sm opacity-75">{{ auth()->user()->patient->patient_id }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-8">
    
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-red-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <p class="text-red-700 font-semibold">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Status Timeline -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Status Janji Temu</h3>
        
        <!-- Timeline -->
        <div class="relative max-w-4xl mx-auto">
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gray-200"></div>
            
            <div class="space-y-8">
                <!-- Step 1: Pending -->
                <div class="relative flex items-center {{ $appointment->status === 'pending' ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Menunggu Konfirmasi</h4>
                        <p class="text-sm text-gray-600">Admin akan mengkonfirmasi dalam 1x24 jam</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $appointment->status === 'pending' ? 'bg-yellow-500 ring-4 ring-yellow-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($appointment->status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 p-3 rounded-lg">
                            <p class="text-sm text-yellow-800 font-semibold">⏳ Sedang Diproses</p>
                            <p class="text-xs text-yellow-700 mt-1">Kami akan segera menghubungi Anda</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Step 2: Confirmed -->
                <div class="relative flex items-center {{ in_array($appointment->status, ['confirmed', 'pending_payment_verification', 'paid', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Dikonfirmasi</h4>
                        <p class="text-sm text-gray-600">Jadwal telah dikonfirmasi, lakukan pembayaran</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ in_array($appointment->status, ['confirmed', 'pending_payment_verification', 'paid', 'completed']) ? 'bg-blue-500 ring-4 ring-blue-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($appointment->status === 'confirmed')
                        <div class="bg-blue-50 border border-blue-200 p-3 rounded-lg">
                            <p class="text-sm text-blue-800 font-semibold">💳 Silakan Bayar</p>
                            <p class="text-xs text-blue-700 mt-1">Upload bukti pembayaran di bawah</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Step 3: Payment Verification -->
                <div class="relative flex items-center {{ in_array($appointment->status, ['pending_payment_verification', 'paid', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Verifikasi Pembayaran</h4>
                        <p class="text-sm text-gray-600">Admin memverifikasi bukti pembayaran</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ in_array($appointment->status, ['pending_payment_verification', 'paid', 'completed']) ? 'bg-purple-500 ring-4 ring-purple-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($appointment->status === 'pending_payment_verification')
                        <div class="bg-purple-50 border border-purple-200 p-3 rounded-lg">
                            <p class="text-sm text-purple-800 font-semibold">🔍 Sedang Diverifikasi</p>
                            <p class="text-xs text-purple-700 mt-1">Proses 1-2 jam kerja</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Step 4: Paid -->
                <div class="relative flex items-center {{ in_array($appointment->status, ['paid', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Lunas</h4>
                        <p class="text-sm text-gray-600">Pembayaran terverifikasi, siap konsultasi</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ in_array($appointment->status, ['paid', 'completed']) ? 'bg-green-500 ring-4 ring-green-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($appointment->status === 'paid')
                        <div class="bg-green-50 border border-green-200 p-3 rounded-lg">
                            <p class="text-sm text-green-800 font-semibold">✅ Siap Konsultasi</p>
                            <p class="text-xs text-green-700 mt-1">Datang sesuai jadwal</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Step 5: Completed -->
                <div class="relative flex items-center {{ $appointment->status === 'completed' ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Selesai</h4>
                        <p class="text-sm text-gray-600">Konsultasi telah selesai</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $appointment->status === 'completed' ? 'bg-gray-700 ring-4 ring-gray-300' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($appointment->status === 'completed')
                        <div class="bg-gray-50 border border-gray-200 p-3 rounded-lg">
                            <p class="text-sm text-gray-800 font-semibold">🎉 Selesai</p>
                            <p class="text-xs text-gray-700 mt-1">Terima kasih atas kunjungan Anda</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Details -->
    <div class="grid md:grid-cols-2 gap-8 mb-8">
        <!-- Left Column -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h8c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-5 2h2v3l1-1 1 1V4h2v5l-2-2-2 2V4z"/>
                </svg>
                Informasi Janji Temu
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">ID Appointment:</span>
                    <span class="font-mono font-bold text-blue-600">{{ $appointment->appointment_id }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Dokter:</span>
                    <span class="font-semibold">{{ $appointment->doctor->name }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Spesialis:</span>
                    <span>{{ $appointment->doctor->specialty }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Tanggal:</span>
                    <span class="font-semibold">{{ $appointment->formatted_date }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Waktu:</span>
                    <span class="font-semibold">{{ $appointment->formatted_time }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b">
                    <span class="text-gray-600">Biaya Konsultasi:</span>
                    <span class="font-bold text-green-600">{{ $appointment->formatted_fee }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                        @elseif($appointment->status === 'pending_payment_verification') bg-purple-100 text-purple-800
                        @elseif($appointment->status === 'paid') bg-green-100 text-green-800
                        @elseif($appointment->status === 'completed') bg-gray-100 text-gray-800
                        @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                        @endif">
                        @if($appointment->status === 'pending') Menunggu Konfirmasi
                        @elseif($appointment->status === 'confirmed') Dikonfirmasi
                        @elseif($appointment->status === 'pending_payment_verification') Verifikasi Pembayaran
                        @elseif($appointment->status === 'paid') Lunas
                        @elseif($appointment->status === 'completed') Selesai
                        @elseif($appointment->status === 'cancelled') Dibatalkan
                        @else {{ $appointment->status }}
                        @endif
                    </span>
                </div>
            </div>
            
            @if($appointment->complaints)
            <div class="mt-6 pt-6 border-t">
                <h4 class="font-semibold text-gray-800 mb-2">Keluhan:</h4>
                <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $appointment->complaints }}</p>
            </div>
            @endif
        </div>

        <!-- Right Column - Payment Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                </svg>
                Pembayaran
            </h3>
            
            @if($appointment->status === 'confirmed')
                <!-- Upload Payment Form -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <h4 class="font-semibold text-blue-800 mb-2">💳 Silakan Lakukan Pembayaran</h4>
                    <p class="text-sm text-blue-700 mb-4">Transfer ke rekening berikut:</p>
                    <div class="bg-white p-4 rounded-lg mb-4">
                        <p class="text-sm text-gray-600">Bank BCA</p>
                        <p class="text-lg font-mono font-bold">1234567890</p>
                        <p class="text-sm text-gray-600">a.n. RS Sehat Sejahtera</p>
                    </div>
                    <p class="text-sm text-blue-700 mb-4">Jumlah: <strong>{{ $appointment->formatted_fee }}</strong></p>
                </div>
                
                <form id="payment-form" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->appointment_id }}">
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Upload Bukti Pembayaran</label>
                        <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max 5MB)</p>
                    </div>
                    
                    <button type="submit" id="submit-btn"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all">
                        Upload Bukti Pembayaran
                    </button>
                </form>
                
            @elseif($appointment->payment)
                <!-- Payment Status -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b">
                        <span class="text-gray-600">Status Pembayaran:</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($appointment->payment->status === 'verified') bg-green-100 text-green-800
                            @elseif($appointment->payment->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($appointment->payment->status === 'rejected') bg-red-100 text-red-800
                            @endif">
                            @if($appointment->payment->status === 'verified') ✅ Terverifikasi
                            @elseif($appointment->payment->status === 'pending') ⏳ Menunggu Verifikasi
                            @elseif($appointment->payment->status === 'rejected') ❌ Ditolak
                            @else {{ $appointment->payment->status }}
                            @endif
                        </span>
                    </div>
                    
                    @if($appointment->payment->proof_image)
                    <div>
                        <p class="text-gray-600 mb-2">Bukti Pembayaran:</p>
                        <img src="{{ asset('storage/' . $appointment->payment->proof_image) }}" 
                             alt="Bukti Pembayaran" 
                             class="w-full rounded-lg border border-gray-200">
                    </div>
                    @endif
                    
                    @if($appointment->payment->status === 'rejected' && $appointment->payment->notes)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-sm text-red-800 font-semibold mb-1">Alasan Penolakan:</p>
                        <p class="text-sm text-red-700">{{ $appointment->payment->notes }}</p>
                        <p class="text-xs text-red-600 mt-2">Silakan upload ulang bukti pembayaran yang benar</p>
                    </div>
                    @endif
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                    </svg>
                    <p class="text-lg font-medium">Belum Ada Pembayaran</p>
                    <p class="text-sm">Tunggu konfirmasi admin terlebih dahulu</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('patient.dashboard') }}" 
           class="inline-flex items-center px-8 py-4 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-all">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('payment-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submit-btn');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Mengupload...';
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("patient.upload.payment") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('✅ ' + data.message);
            window.location.reload();
        } else {
            alert('❌ ' + data.message);
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    } catch (error) {
        alert('❌ Terjadi kesalahan saat mengupload');
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});
</script>
@endpush
@endsection
