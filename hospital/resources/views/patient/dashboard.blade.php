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
    
    <!-- Warning Message for Active Appointment -->
    @if(session('warning'))
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex items-start">
            <svg class="w-8 h-8 text-yellow-500 mr-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-yellow-800 mb-2">⚠️ Perhatian!</h3>
                <p class="text-yellow-700 mb-4">{{ session('warning') }}</p>
                @if(session('active_appointment_id'))
                <a href="#appointment-{{ session('active_appointment_id') }}" class="inline-block bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-600 transition-all shadow-lg">
                    📋 Lihat Janji Temu Aktif
                </a>
                @endif
            </div>
        </div>
    </div>
    @endif
    
    <!-- Success Message -->
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
    
    <!-- Error Message -->
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
    
    @if($activeAppointment)
    <!-- Status Timeline -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Status Janji Temu Anda</h3>
        
        <!-- Timeline -->
        <div class="relative">
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gray-200"></div>
            
            <div class="space-y-8">
                <!-- Step 1: Pending -->
                <div class="relative flex items-center {{ $activeAppointment->status === 'pending' ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Menunggu Konfirmasi</h4>
                        <p class="text-sm text-gray-600">Admin akan mengkonfirmasi dalam 1x24 jam</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $activeAppointment->status === 'pending' ? 'bg-yellow-500 ring-4 ring-yellow-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($activeAppointment->status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 p-3 rounded-lg">
                            <p class="text-sm text-yellow-800 font-semibold">⏳ Sedang Diproses</p>
                            <p class="text-xs text-yellow-700 mt-1">Kami akan segera menghubungi Anda</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Step 2: Confirmed -->
                <div class="relative flex items-center {{ in_array($activeAppointment->status, ['confirmed', 'pending_payment_verification', 'paid', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Dikonfirmasi</h4>
                        <p class="text-sm text-gray-600">Jadwal telah dikonfirmasi, lakukan pembayaran</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ in_array($activeAppointment->status, ['confirmed', 'pending_payment_verification', 'paid', 'completed']) ? 'bg-blue-500 ring-4 ring-blue-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($activeAppointment->status === 'confirmed')
                        <div class="bg-blue-50 border border-blue-200 p-3 rounded-lg">
                            <p class="text-sm text-blue-800 font-semibold">💳 Silakan Bayar</p>
                            <p class="text-xs text-blue-700 mt-1">Upload bukti pembayaran di bawah</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Step 3: Payment Verification -->
                <div class="relative flex items-center {{ in_array($activeAppointment->status, ['pending_payment_verification', 'paid', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Verifikasi Pembayaran</h4>
                        <p class="text-sm text-gray-600">Admin memverifikasi bukti pembayaran</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ in_array($activeAppointment->status, ['pending_payment_verification', 'paid', 'completed']) ? 'bg-purple-500 ring-4 ring-purple-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($activeAppointment->status === 'pending_payment_verification')
                        <div class="bg-purple-50 border border-purple-200 p-3 rounded-lg">
                            <p class="text-sm text-purple-800 font-semibold">🔍 Sedang Diverifikasi</p>
                            <p class="text-xs text-purple-700 mt-1">Proses 1-2 jam kerja</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Step 4: Paid -->
                <div class="relative flex items-center {{ in_array($activeAppointment->status, ['paid', 'completed']) ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Pembayaran Lunas</h4>
                        <p class="text-sm text-gray-600">Siap untuk konsultasi</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ in_array($activeAppointment->status, ['paid', 'completed']) ? 'bg-green-500 ring-4 ring-green-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($activeAppointment->status === 'paid')
                        <div class="bg-green-50 border border-green-200 p-3 rounded-lg">
                            <p class="text-sm text-green-800 font-semibold">✅ Lunas!</p>
                            <p class="text-xs text-green-700 mt-1">Datang sesuai jadwal</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Step 5: Completed -->
                <div class="relative flex items-center {{ $activeAppointment->status === 'completed' ? 'opacity-100' : 'opacity-50' }}">
                    <div class="flex-1 text-right pr-8">
                        <h4 class="font-bold text-gray-800">Selesai</h4>
                        <p class="text-sm text-gray-600">Konsultasi telah dilaksanakan</p>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $activeAppointment->status === 'completed' ? 'bg-gray-500 ring-4 ring-gray-200' : 'bg-gray-300' }}">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pl-8">
                        @if($activeAppointment->status === 'completed')
                        <div class="bg-gray-50 border border-gray-200 p-3 rounded-lg">
                            <p class="text-sm text-gray-800 font-semibold">🎉 Terima Kasih</p>
                            <p class="text-xs text-gray-700 mt-1">Semoga lekas sembuh!</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Active Appointment Card -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Detail Janji Temu Aktif</h3>
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
                        'confirmed' => 'Dikonfirmasi - Silakan Bayar',
                        'pending_payment_verification' => 'Menunggu Verifikasi Pembayaran',
                        'paid' => 'Lunas - Siap Konsultasi',
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
    <div id="payment-section" class="bg-white rounded-2xl shadow-lg p-8 mb-8 scroll-mt-8">
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

    <!-- Create New Appointment Button -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 text-center">
        <div class="max-w-2xl mx-auto">
            <svg class="w-16 h-16 mx-auto mb-4 {{ $activeAppointment ? 'text-gray-400' : 'text-blue-600' }}" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Buat Janji Temu Baru</h3>
            
            @if($activeAppointment)
                <p class="text-red-600 mb-4 font-semibold">⚠️ Anda masih memiliki janji temu yang belum selesai</p>
                <p class="text-gray-600 mb-6">Silakan selesaikan janji temu aktif Anda terlebih dahulu sebelum membuat janji temu baru</p>
                <a href="#appointment-{{ $activeAppointment->appointment_id }}" 
                   class="inline-flex items-center px-8 py-4 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    Lihat Janji Temu Aktif
                </a>
            @else
                <p class="text-gray-600 mb-6">Butuh konsultasi lagi? Buat janji temu baru dengan mudah tanpa perlu daftar ulang</p>
                <a href="{{ route('patient.appointments.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Buat Janji Temu Baru
                </a>
            @endif
        </div>
    </div>

    <!-- Appointment History -->
    @if($appointments->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
            </svg>
            Riwayat Janji Temu
        </h3>
        
        <div class="space-y-4">
            @foreach($appointments as $appointment)
                <!-- Add ID anchor for scrolling -->
                <a href="{{ route('patient.status', $appointment->appointment_id) }}" 
                   id="appointment-{{ $appointment->appointment_id }}" 
                   class="block border-2 {{ $appointment->id === $activeAppointment?->id ? 'border-blue-500 bg-blue-50 ring-4 ring-blue-200' : 'border-gray-200 bg-white' }} rounded-xl p-6 hover:shadow-xl hover:border-blue-400 transition-all scroll-mt-24 cursor-pointer">
                    @if($appointment->id === $activeAppointment?->id)
                    <div class="mb-3">
                        <span class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full animate-pulse">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            ⚡ JANJI TEMU AKTIF - KLIK UNTUK SELESAIKAN
                        </span>
                    </div>
                    @endif
                    
                    <div class="grid md:grid-cols-3 gap-6">
                        <!-- Appointment Info -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h8c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-5 2h2v3l1-1 1 1V4h2v5l-2-2-2 2V4z"/>
                                </svg>
                                Informasi Janji
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-600">ID:</span>
                                    <span class="font-mono font-bold text-blue-600 ml-2">{{ $appointment->appointment_id }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Dokter:</span>
                                    <span class="font-semibold ml-2">{{ $appointment->doctor->name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Spesialis:</span>
                                    <span class="ml-2">{{ $appointment->doctor->specialty }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Schedule Info -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                </svg>
                                Jadwal
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                    </svg>
                                    <span class="font-semibold">{{ $appointment->formatted_date }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                    </svg>
                                    <span class="font-semibold">{{ $appointment->formatted_time }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                    </svg>
                                    <span class="font-bold text-green-600">{{ $appointment->formatted_fee }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Info -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                Status
                            </h4>
                            <div class="space-y-2">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full border {{ $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                                </span>
                                
                                @if($appointment->complaints)
                                <div class="mt-3">
                                    <p class="text-xs text-gray-600 mb-1">Keluhan:</p>
                                    <p class="text-sm text-gray-800 bg-gray-50 p-2 rounded">{{ Str::limit($appointment->complaints, 100) }}</p>
                                </div>
                                @endif
                                
                                @if($appointment->payment)
                                <div class="mt-2 text-xs">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                        </svg>
                                        Pembayaran: 
                                        <span class="ml-1 font-semibold">
                                            @if($appointment->payment->status === 'verified')
                                                ✅ Terverifikasi
                                            @elseif($appointment->payment->status === 'pending')
                                                ⏳ Menunggu
                                            @else
                                                {{ $appointment->payment->status }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Appointment Actions -->
                    @if($appointment->id === $activeAppointment?->id && in_array($appointment->status, ['pending', 'confirmed', 'pending_payment_verification', 'paid']))
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-lg font-semibold">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                                </svg>
                                Klik untuk Selesaikan
                            </span>
                        </div>
                    </div>
                    @endif
                </a>
            @endforeach
        </div>
        
        @if($appointments->count() === 0)
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <p class="text-gray-500 text-lg font-medium">Belum ada riwayat janji temu</p>
            <p class="text-gray-400 text-sm mt-2">Buat janji temu pertama Anda sekarang</p>
        </div>
        @endif
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