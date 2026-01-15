@extends('layouts.app')

@section('title', 'Detail Appointment - Admin')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-green-600 text-white p-6">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold">Detail Appointment</h2>
        <p class="opacity-90">{{ $appointment->appointment_id }}</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Status Appointment</h3>
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
                    <span class="px-4 py-2 text-sm font-semibold rounded-full border {{ $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$appointment->status] ?? ucfirst($appointment->status) }}
                    </span>
                </div>
                
                <div class="text-right">
                    <p class="text-sm text-gray-600">Biaya Konsultasi</p>
                    <p class="text-2xl font-bold text-green-600">{{ $appointment->formatted_fee }}</p>
                </div>
            </div>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Patient & Appointment Info -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Data Pasien -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        Data Pasien
                    </h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-600">ID Pendaftaran</p>
                                <p class="font-mono font-bold text-blue-600">{{ $appointment->appointment_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Nama Lengkap</p>
                                <p class="font-semibold text-gray-800">{{ $appointment->patient->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Telepon</p>
                                <p class="text-gray-800">{{ $appointment->patient->user->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="text-gray-800">{{ $appointment->patient->user->email }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            @if($appointment->patient->birth_date)
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Lahir</p>
                                <p class="text-gray-800">{{ $appointment->patient->birth_date->format('d F Y') }}</p>
                            </div>
                            @endif
                            @if($appointment->patient->gender)
                            <div>
                                <p class="text-sm text-gray-600">Jenis Kelamin</p>
                                <p class="text-gray-800">{{ $appointment->patient->gender }}</p>
                            </div>
                            @endif
                            @if($appointment->patient->address)
                            <div>
                                <p class="text-sm text-gray-600">Alamat</p>
                                <p class="text-gray-800">{{ $appointment->patient->address }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Detail Janji Temu -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                        Detail Janji Temu
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Dokter</p>
                                <p class="font-semibold text-gray-800">{{ $appointment->doctor->name }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->doctor->specialty }}</p>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Tanggal Konsultasi</p>
                                <p class="font-semibold text-gray-800">{{ $appointment->formatted_date }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Waktu</p>
                                <p class="font-semibold text-gray-800">{{ $appointment->formatted_time }}</p>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">Keluhan / Gejala</p>
                            <p class="text-gray-800">{{ $appointment->complaints ?? 'Konsultasi umum' }}</p>
                        </div>
                        
                        @if($appointment->check_in_time)
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                                <p class="text-sm text-green-600">Check In</p>
                                <p class="font-semibold text-gray-800">{{ $appointment->check_in_time->format('d M Y, H:i') }}</p>
                            </div>
                            @if($appointment->check_out_time)
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <p class="text-sm text-blue-600">Check Out</p>
                                <p class="font-semibold text-gray-800">{{ $appointment->check_out_time->format('d M Y, H:i') }}</p>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                
            </div>
            
            <!-- Right Column - Payment & Actions -->
            <div class="space-y-8">
                
                <!-- Bukti Pembayaran -->
                @if($appointment->payment && $appointment->payment->proof_image)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                        </svg>
                        Bukti Pembayaran
                    </h3>
                    
                    @php
                        $paymentStatusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'verified' => 'bg-green-100 text-green-800 border-green-200',
                            'rejected' => 'bg-red-100 text-red-800 border-red-200',
                        ];
                    @endphp
                    
                    <div class="mb-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $paymentStatusClasses[$appointment->payment->status] ?? '' }}">
                            {{ ucfirst($appointment->payment->status) }}
                        </span>
                    </div>
                    
                    <!-- Image Preview -->
                    <div class="mb-4">
                        <div class="relative group">
                            @php
                                $imagePath = $appointment->payment->proof_image;
                                $fullPath = storage_path('app/public/' . $imagePath);
                                $imageExists = file_exists($fullPath);
                                $imageUrl = asset('storage/' . $imagePath);
                            @endphp
                            
                            @if($imageExists)
                            <img 
                                src="{{ $imageUrl }}" 
                                alt="Bukti Pembayaran {{ $appointment->appointment_id }}"
                                class="w-full h-auto max-h-64 object-contain rounded-lg border-2 border-gray-300 shadow-md cursor-pointer hover:border-blue-500 transition-all"
                                onclick="openImageModal('{{ $imageUrl }}', '{{ $appointment->appointment_id }}')"
                                id="paymentProofImage"
                            >
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all cursor-pointer" onclick="openImageModal('{{ $imageUrl }}', '{{ $appointment->appointment_id }}')">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 3l2.3 2.3-2.89 2.87 1.42 1.42L18.7 6.7 21 9V3h-6zM3 9l2.3-2.3 2.87 2.89 1.42-1.42L6.7 5.3 9 3H3v6zm6 12l-2.3-2.3 2.89-2.87-1.42-1.42L5.3 17.3 3 15v6h6zm12-6l-2.3 2.3-2.87-2.89-1.42 1.42 2.89 2.87L15 21h6v-6z"/>
                                </svg>
                            </div>
                            @else
                            <div class="w-full h-64 bg-gray-100 rounded-lg border-2 border-dashed border-red-300 flex items-center justify-center">
                                <div class="text-center text-gray-500 p-4">
                                    <svg class="w-16 h-16 mx-auto mb-2 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                    </svg>
                                    <p class="text-sm font-semibold text-red-600 mb-1">⚠️ File Tidak Ditemukan</p>
                                    <p class="text-xs text-gray-500 mb-2">File gambar tidak ada di server</p>
                                    <p class="text-xs text-gray-400 font-mono bg-gray-200 p-2 rounded">{{ $imagePath }}</p>
                                    <div class="mt-3 text-xs text-left text-gray-600">
                                        <p class="font-semibold mb-1">Kemungkinan penyebab:</p>
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Upload gagal/terputus</li>
                                            <li>File terhapus dari storage</li>
                                            <li>Masalah permission folder</li>
                                        </ul>
                                    </div>
                                    <button onclick="requestReupload('{{ $appointment->appointment_id }}')" class="mt-3 px-4 py-2 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                        Minta Pasien Upload Ulang
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            @if($imageExists)
                                Klik untuk memperbesar • File: {{ basename($imagePath) }}
                            @else
                                <span class="text-red-600">⚠️ File tidak dapat dimuat - Hubungi pasien untuk upload ulang</span>
                            @endif
                        </p>
                        
                        <!-- Download Button -->
                        @if($imageExists)
                        <div class="mt-3 text-center">
                            <a href="{{ $imageUrl }}" download class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                </svg>
                                Download
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Payment Details -->
                    <div class="space-y-2 text-sm bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-bold text-green-600">Rp {{ number_format($appointment->payment->amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode:</span>
                            <span class="font-semibold">{{ ucfirst($appointment->payment->payment_method) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Upload:</span>
                            <span>{{ $appointment->payment->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($appointment->payment->verified_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Verifikasi:</span>
                            <span>{{ $appointment->payment->verified_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Quick Actions for Payment -->
                    @if($appointment->payment->status === 'pending')
                    <div class="mt-4 space-y-2">
                        <form action="{{ route('admin.payments.verify', $appointment->payment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold transition-all flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                Verifikasi Pembayaran
                            </button>
                        </form>
                        
                        <button onclick="showRejectModal({{ $appointment->payment->id }})" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 font-semibold transition-all flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                            Tolak Pembayaran
                        </button>
                    </div>
                    @endif
                    
                    @if($appointment->payment->notes)
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800"><strong>Catatan:</strong></p>
                        <p class="text-sm text-yellow-700">{{ $appointment->payment->notes }}</p>
                    </div>
                    @endif
                </div>
                @elseif($appointment->status === 'confirmed')
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                    <h3 class="font-bold text-yellow-800 mb-2">⏳ Menunggu Pembayaran</h3>
                    <p class="text-sm text-yellow-700">Pasien belum mengupload bukti pembayaran</p>
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Aksi</h3>
                    
                    <div class="space-y-3">
                        @if($appointment->status === 'pending')
                            <form action="{{ route('admin.appointments.confirm', $appointment->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                                    ✅ Konfirmasi Appointment
                                </button>
                            </form>
                            
                            <button onclick="showCancelModal({{ $appointment->id }})" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 font-semibold">
                                ❌ Batalkan Appointment
                            </button>
                        @endif
                        
                        @if($appointment->status === 'paid' && !$appointment->check_in_time)
                            <form action="{{ route('admin.appointments.checkin', $appointment->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 font-semibold">
                                    📝 Check In Pasien
                                </button>
                            </form>
                        @endif
                        
                        @if($appointment->check_in_time && !$appointment->check_out_time)
                            <form action="{{ route('admin.appointments.checkout', $appointment->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-lg hover:bg-orange-700 font-semibold">
                                    ✅ Check Out Pasien
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.appointments') }}" class="block w-full text-center bg-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-400 font-semibold">
                            ← Kembali
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-95 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-7xl w-full" onclick="event.stopPropagation()">
        <!-- Close Button -->
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 transition-all flex items-center space-x-2">
            <span class="text-sm font-semibold">Tutup</span>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
        </button>
        
        <!-- Image Container with Zoom -->
        <div class="bg-white rounded-lg p-2 shadow-2xl">
            <div class="relative overflow-auto max-h-[85vh]" id="imageContainer" style="cursor: grab;">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="w-full h-auto object-contain transition-transform duration-200 select-none" draggable="false">
            </div>
        </div>
        
        <!-- Controls -->
        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0 sm:space-x-3">
            <!-- Caption & Zoom Level -->
            <div class="flex-1 text-center sm:text-left">
                <p id="modalCaption" class="text-white text-lg font-semibold"></p>
                <p id="zoomLevel" class="text-white text-sm opacity-75 mt-1">Zoom: 100%</p>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap justify-center gap-2">
                <!-- Zoom In -->
                <button onclick="zoomImage(1.25)" class="bg-white bg-opacity-20 text-white p-3 rounded-lg hover:bg-opacity-30 transition-all flex items-center space-x-2" title="Zoom In (+ atau scroll up)">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        <path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"/>
                    </svg>
                    <span class="text-sm font-semibold hidden sm:inline">Perbesar</span>
                </button>
                
                <!-- Zoom Out -->
                <button onclick="zoomImage(0.8)" class="bg-white bg-opacity-20 text-white p-3 rounded-lg hover:bg-opacity-30 transition-all flex items-center space-x-2" title="Zoom Out (- atau scroll down)">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        <path d="M7 9h5v1H7z"/>
                    </svg>
                    <span class="text-sm font-semibold hidden sm:inline">Perkecil</span>
                </button>
                
                <!-- Reset Zoom -->
                <button onclick="resetZoom()" class="bg-white bg-opacity-20 text-white p-3 rounded-lg hover:bg-opacity-30 transition-all flex items-center space-x-2" title="Reset Zoom (tekan 0)">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                    </svg>
                    <span class="text-sm font-semibold hidden sm:inline">Reset</span>
                </button>
                
                <!-- Fit to Screen -->
                <button onclick="fitToScreen()" class="bg-white bg-opacity-20 text-white p-3 rounded-lg hover:bg-opacity-30 transition-all flex items-center space-x-2" title="Fit to Screen">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                    </svg>
                    <span class="text-sm font-semibold hidden sm:inline">Fit</span>
                </button>
                
                <!-- Download -->
                <button onclick="downloadModalImage()" class="bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 font-semibold inline-flex items-center transition-all">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                    </svg>
                    <span class="hidden sm:inline">Download</span>
                </button>
            </div>
        </div>
        
        <!-- Instructions -->
        <div class="mt-3 text-center">
            <p class="text-white text-sm opacity-75">
                💡 Scroll mouse untuk zoom • Drag untuk geser gambar • ESC untuk tutup
            </p>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
<div id="rejectModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Tolak Pembayaran</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Alasan Penolakan *</label>
                <textarea name="notes" required rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500" placeholder="Jelaskan alasan penolakan..."></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Cancel Appointment Modal -->
<div id="cancelModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Batalkan Appointment</h3>
        <form id="cancelForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Alasan Pembatalan</label>
                <textarea name="reason" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500" placeholder="Jelaskan alasan pembatalan (opsional)..."></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="closeCancelModal()" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700">
                    Batalkan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let currentImageSrc = '';
let currentZoom = 1;
let isDragging = false;
let startX, startY, scrollLeft, scrollTop;

function openImageModal(imageSrc, appointmentId) {
    console.log('openImageModal called');
    console.log('Image src:', imageSrc);
    console.log('Appointment ID:', appointmentId);
    
    const modalImage = document.getElementById('modalImage');
    const modalCaption = document.getElementById('modalCaption');
    const imageModal = document.getElementById('imageModal');
    
    if (!modalImage || !modalCaption || !imageModal) {
        console.error('Modal elements not found!');
        console.error('modalImage:', modalImage);
        console.error('modalCaption:', modalCaption);
        console.error('imageModal:', imageModal);
        return;
    }
    
    modalImage.src = imageSrc;
    modalCaption.textContent = 'Bukti Pembayaran - ' + appointmentId;
    imageModal.classList.remove('hidden');
    currentImageSrc = imageSrc;
    currentZoom = 1;
    resetZoom();
    updateZoomLevel();
    
    console.log('Modal opened successfully');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    resetZoom();
}

function zoomImage(factor) {
    const img = document.getElementById('modalImage');
    const container = document.getElementById('imageContainer');
    
    currentZoom *= factor;
    
    // Limit zoom between 0.5x and 10x
    if (currentZoom < 0.5) currentZoom = 0.5;
    if (currentZoom > 10) currentZoom = 10;
    
    img.style.transform = `scale(${currentZoom})`;
    img.style.transformOrigin = 'center center';
    
    // Update cursor
    if (currentZoom > 1) {
        container.style.cursor = 'grab';
        img.style.cursor = 'grab';
    } else {
        container.style.cursor = 'default';
        img.style.cursor = 'zoom-in';
    }
    
    updateZoomLevel();
}

function resetZoom() {
    const img = document.getElementById('modalImage');
    const container = document.getElementById('imageContainer');
    currentZoom = 1;
    img.style.transform = 'scale(1)';
    img.style.transformOrigin = 'center center';
    container.style.cursor = 'default';
    img.style.cursor = 'zoom-in';
    updateZoomLevel();
}

function fitToScreen() {
    resetZoom();
}

function updateZoomLevel() {
    const percentage = Math.round(currentZoom * 100);
    const zoomLevelEl = document.getElementById('zoomLevel');
    if (zoomLevelEl) {
        zoomLevelEl.textContent = `Zoom: ${percentage}%`;
    }
}

function downloadModalImage() {
    const link = document.createElement('a');
    link.href = currentImageSrc;
    link.download = 'bukti_pembayaran_' + new Date().getTime() + '.jpg';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function requestReupload(appointmentId) {
    if (confirm('Kirim notifikasi ke pasien untuk upload ulang bukti pembayaran?')) {
        alert('Fitur notifikasi akan segera ditambahkan. Sementara ini, hubungi pasien secara manual untuk upload ulang bukti pembayaran.');
    }
}

function showRejectModal(paymentId) {
    const form = document.getElementById('rejectForm');
    form.action = '/admin/payments/' + paymentId + '/reject';
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

function showCancelModal(appointmentId) {
    const form = document.getElementById('cancelForm');
    form.action = '/admin/appointments/' + appointmentId + '/cancel';
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}

// Drag to pan functionality
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('imageContainer');
    if (container) {
        container.addEventListener('mousedown', (e) => {
            if (currentZoom > 1) {
                isDragging = true;
                container.style.cursor = 'grabbing';
                startX = e.pageX - container.offsetLeft;
                startY = e.pageY - container.offsetTop;
                scrollLeft = container.scrollLeft;
                scrollTop = container.scrollTop;
            }
        });

        container.addEventListener('mouseleave', () => {
            isDragging = false;
            if (currentZoom > 1) {
                container.style.cursor = 'grab';
            }
        });

        container.addEventListener('mouseup', () => {
            isDragging = false;
            if (currentZoom > 1) {
                container.style.cursor = 'grab';
            }
        });

        container.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const y = e.pageY - container.offsetTop;
            const walkX = (x - startX) * 2;
            const walkY = (y - startY) * 2;
            container.scrollLeft = scrollLeft - walkX;
            container.scrollTop = scrollTop - walkY;
        });
    }
});

// Close modals when clicking outside
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});

document.getElementById('cancelModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
        closeRejectModal();
        closeCancelModal();
    }
    
    // Zoom shortcuts when modal is open
    if (!document.getElementById('imageModal').classList.contains('hidden')) {
        if (e.key === '+' || e.key === '=') {
            e.preventDefault();
            zoomImage(1.25);
        }
        if (e.key === '-' || e.key === '_') {
            e.preventDefault();
            zoomImage(0.8);
        }
        if (e.key === '0') {
            e.preventDefault();
            resetZoom();
        }
        if (e.key === 'f' || e.key === 'F') {
            e.preventDefault();
            fitToScreen();
        }
    }
});

// Mouse wheel zoom
document.getElementById('modalImage')?.addEventListener('wheel', function(e) {
    if (!document.getElementById('imageModal').classList.contains('hidden')) {
        e.preventDefault();
        if (e.deltaY < 0) {
            zoomImage(1.1);
        } else {
            zoomImage(0.9);
        }
    }
}, { passive: false });

// Add click event listener to payment proof image as backup
document.addEventListener('DOMContentLoaded', function() {
    const paymentProofImage = document.getElementById('paymentProofImage');
    if (paymentProofImage) {
        console.log('Payment proof image found, adding click listener');
        paymentProofImage.addEventListener('click', function() {
            console.log('Image clicked via event listener');
            const imageSrc = this.src;
            const appointmentId = '{{ $appointment->appointment_id }}';
            openImageModal(imageSrc, appointmentId);
        });
    } else {
        console.log('Payment proof image not found');
    }
});
</script>
@endpush
@endsection