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
                            <img 
                                src="{{ Storage::url($appointment->payment->proof_image) }}" 
                                alt="Bukti Pembayaran {{ $appointment->appointment_id }}"
                                class="w-full h-auto rounded-lg border-2 border-gray-300 shadow-md cursor-pointer hover:border-blue-500 transition-all"
                                onclick="openImageModal('{{ Storage::url($appointment->payment->proof_image) }}', '{{ $appointment->appointment_id }}')"
                            >
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all cursor-pointer">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 3l2.3 2.3-2.89 2.87 1.42 1.42L18.7 6.7 21 9V3h-6zM3 9l2.3-2.3 2.87 2.89 1.42-1.42L6.7 5.3 9 3H3v6zm6 12l-2.3-2.3 2.89-2.87-1.42-1.42L5.3 17.3 3 15v6h6zm12-6l-2.3 2.3-2.87-2.89-1.42 1.42 2.89 2.87L15 21h6v-6z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 text-center">Klik untuk memperbesar</p>
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
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4">
    <div class="relative max-w-5xl w-full">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition-all z-10">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="w-full h-auto max-h-[90vh] object-contain rounded-lg">
        <div class="mt-4 text-center">
            <p id="modalCaption" class="text-white text-lg font-semibold"></p>
            <button onclick="downloadModalImage()" class="mt-3 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                </svg>
                Download Bukti Bayar
            </button>
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

function openImageModal(imageSrc, appointmentId) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalCaption').textContent = 'Bukti Pembayaran - ' + appointmentId;
    document.getElementById('imageModal').classList.remove('hidden');
    currentImageSrc = imageSrc;
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

function downloadModalImage() {
    const link = document.createElement('a');
    link.href = currentImageSrc;
    link.download = 'bukti_pembayaran_' + new Date().getTime() + '.jpg';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
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

// Close modals when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});

document.getElementById('cancelModal').addEventListener('click', function(e) {
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
});
</script>
@endpush
@endsection