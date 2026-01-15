@extends('layouts.app')

@section('title', 'Kelola Pembayaran - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Kelola Pembayaran</h1>
                    <p class="text-gray-600 mt-2">Verifikasi dan kelola pembayaran pasien</p>
                </div>
                
                <!-- Filter Status -->
                <div class="flex space-x-4">
                    <select onchange="filterByStatus(this.value)" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Pembayaran</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $payments->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Menunggu Verifikasi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Terverifikasi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $verifiedCount }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Ditolak</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $rejectedCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Daftar Pembayaran</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pembayaran</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Upload</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $payment->id }}</div>
                                <div class="text-sm text-gray-500">{{ $payment->appointment->appointment_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($payment->appointment->patient->user->name, 0, 2)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $payment->appointment->patient->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->appointment->patient->patient_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $payment->appointment->doctor->name }}</div>
                                <div class="text-sm text-gray-500">{{ $payment->appointment->doctor->specialty }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                                <div class="text-sm text-gray-500">{{ ucfirst($payment->payment_method) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $payment->created_at->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $payment->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->status === 'pending')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($payment->status === 'verified')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Terverifikasi
                                    </span>
                                @elseif($payment->status === 'rejected')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button onclick="showPaymentDetail({{ $payment->id }})" class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                    </svg>
                                </button>
                                
                                @if($payment->status === 'pending')
                                <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" title="Verifikasi">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                    </button>
                                </form>
                                
                                <button onclick="showRejectModal({{ $payment->id }})" class="text-red-600 hover:text-red-900" title="Tolak">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                    </svg>
                                </button>
                                @endif
                                
                                <a href="{{ route('admin.appointments.show', $payment->appointment->id) }}" class="text-purple-600 hover:text-purple-900" title="Lihat Appointment">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h8c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                </svg>
                                <p class="text-lg font-medium">Belum ada pembayaran</p>
                                <p class="text-sm">Pembayaran akan muncul setelah pasien mengupload bukti</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Payment Detail Modal -->
<div id="paymentDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Detail Pembayaran</h3>
            </div>
            
            <div id="paymentDetailContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
            
            <div class="p-6 border-t border-gray-200 flex justify-end">
                <button onclick="hidePaymentDetailModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
<div id="rejectPaymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Tolak Pembayaran</h3>
            </div>
            
            <form id="rejectPaymentForm" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="notes" required rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Jelaskan alasan penolakan pembayaran..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="hideRejectModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Tolak Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function filterByStatus(status) {
    const url = new URL(window.location);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location = url;
}

function showPaymentDetail(paymentId) {
    fetch(`/admin/payments/${paymentId}/detail`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('paymentDetailContent').innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Informasi Pembayaran</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Pembayaran:</span>
                                <span class="font-medium">#${data.id}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Appointment:</span>
                                <span class="font-medium">${data.appointment.appointment_id}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah:</span>
                                <span class="font-bold text-green-600">Rp ${new Intl.NumberFormat('id-ID').format(data.amount)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode:</span>
                                <span class="font-medium">${data.payment_method}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full ${getStatusClass(data.status)}">${getStatusText(data.status)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Upload:</span>
                                <span class="font-medium">${new Date(data.created_at).toLocaleString('id-ID')}</span>
                            </div>
                            ${data.verified_at ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Verifikasi:</span>
                                <span class="font-medium">${new Date(data.verified_at).toLocaleString('id-ID')}</span>
                            </div>
                            ` : ''}
                        </div>
                        
                        <h4 class="text-lg font-bold text-gray-800 mb-4 mt-6">Informasi Pasien</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-medium">${data.appointment.patient.user.name}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Pasien:</span>
                                <span class="font-medium">${data.appointment.patient.patient_id}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dokter:</span>
                                <span class="font-medium">${data.appointment.doctor.name}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Bukti Pembayaran</h4>
                        ${data.proof_image ? `
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="relative group">
                                <img src="/storage/${data.proof_image}" 
                                     alt="Bukti Pembayaran" 
                                     class="w-full h-64 object-contain rounded-lg cursor-pointer hover:opacity-80 transition-opacity" 
                                     onclick="openImageModal('/storage/${data.proof_image}')" 
                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all pointer-events-none">
                                    <div class="bg-white bg-opacity-90 rounded-full p-3">
                                        <svg class="w-8 h-8 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                            <path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div style="display:none;" class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                    </svg>
                                    <p class="text-sm">Gambar tidak dapat dimuat</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-center space-x-2">
                                <button onclick="openImageModal('/storage/${data.proof_image}')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                        <path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"/>
                                    </svg>
                                    Zoom Gambar
                                </button>
                                <a href="/storage/${data.proof_image}" download class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                        ` : '<p class="text-gray-500">Tidak ada bukti pembayaran</p>'}
                        
                        ${data.notes ? `
                        <div class="mt-6">
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Catatan</h4>
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-yellow-800">${data.notes}</p>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
            document.getElementById('paymentDetailModal').classList.remove('hidden');
        });
}

function hidePaymentDetailModal() {
    document.getElementById('paymentDetailModal').classList.add('hidden');
}

function showRejectModal(paymentId) {
    document.getElementById('rejectPaymentForm').action = `/admin/payments/${paymentId}/reject`;
    document.getElementById('rejectPaymentModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectPaymentModal').classList.add('hidden');
}

function getStatusClass(status) {
    switch(status) {
        case 'pending': return 'bg-yellow-100 text-yellow-800';
        case 'verified': return 'bg-green-100 text-green-800';
        case 'rejected': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

function getStatusText(status) {
    switch(status) {
        case 'pending': return 'Menunggu Verifikasi';
        case 'verified': return 'Terverifikasi';
        case 'rejected': return 'Ditolak';
        default: return status;
    }
}

let currentImageSrc = '';
let currentZoom = 1;
let isDragging = false;
let startX, startY, scrollLeft, scrollTop;
let listenersSetup = false;

function openImageModal(imageSrc) {
    console.log('openImageModal called with:', imageSrc);
    
    const modal = document.getElementById('imageZoomModal');
    if (!modal) {
        console.log('Modal not found, creating...');
        createImageZoomModal();
    }
    
    const img = document.getElementById('zoomModalImage');
    const modalElement = document.getElementById('imageZoomModal');
    
    if (!img || !modalElement) {
        console.error('Modal elements not found!');
        return;
    }
    
    img.src = imageSrc;
    modalElement.classList.remove('hidden');
    currentImageSrc = imageSrc;
    currentZoom = 1;
    resetImageZoom();
    updateImageZoomLevel();
    
    console.log('Modal opened successfully');
}

function createImageZoomModal() {
    // Check if modal already exists
    if (document.getElementById('imageZoomModal')) {
        return;
    }
    
    const modal = document.createElement('div');
    modal.id = 'imageZoomModal';
    modal.className = 'hidden fixed inset-0 z-[60] bg-black bg-opacity-90 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="w-full max-w-6xl">
            <!-- Image Container -->
            <div id="zoomImageContainer" class="relative bg-black rounded-lg overflow-auto max-h-[70vh] mb-4" style="cursor: default;">
                <img id="zoomModalImage" src="" alt="Bukti Pembayaran" class="w-full h-auto transition-transform duration-200" style="cursor: zoom-in;">
            </div>
            
            <!-- Controls -->
            <div class="bg-black bg-opacity-50 rounded-lg p-4 backdrop-blur-sm">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Caption & Zoom Level -->
                    <div class="flex-1 text-center sm:text-left">
                        <p class="text-white text-lg font-semibold">Bukti Pembayaran</p>
                        <p id="imageZoomLevel" class="text-white text-sm opacity-75 mt-1">Zoom: 100%</p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap justify-center gap-2">
                        <!-- Zoom In -->
                        <button onclick="zoomImageModal(1.25)" class="bg-white bg-opacity-20 text-white p-3 rounded-lg hover:bg-opacity-30 transition-all flex items-center space-x-2" title="Zoom In (+ atau scroll up)">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                <path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"/>
                            </svg>
                            <span class="text-sm font-semibold hidden sm:inline">Perbesar</span>
                        </button>
                        
                        <!-- Zoom Out -->
                        <button onclick="zoomImageModal(0.8)" class="bg-white bg-opacity-20 text-white p-3 rounded-lg hover:bg-opacity-30 transition-all flex items-center space-x-2" title="Zoom Out (- atau scroll down)">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                <path d="M7 9h5v1H7z"/>
                            </svg>
                            <span class="text-sm font-semibold hidden sm:inline">Perkecil</span>
                        </button>
                        
                        <!-- Reset Zoom -->
                        <button onclick="resetImageZoom()" class="bg-white bg-opacity-20 text-white p-3 rounded-lg hover:bg-opacity-30 transition-all flex items-center space-x-2" title="Reset Zoom (tekan 0)">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                            <span class="text-sm font-semibold hidden sm:inline">Reset</span>
                        </button>
                        
                        <!-- Download -->
                        <button onclick="downloadZoomModalImage()" class="bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 font-semibold inline-flex items-center transition-all">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                            </svg>
                            <span class="hidden sm:inline">Download</span>
                        </button>
                        
                        <!-- Close -->
                        <button onclick="closeImageZoomModal()" class="bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 font-semibold inline-flex items-center transition-all">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                            <span class="hidden sm:inline">Tutup</span>
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
    `;
    document.body.appendChild(modal);
    
    // Setup event listeners for this modal
    attachContainerListeners();
    
    // Setup global keyboard listener (only once)
    setupImageZoomListeners();
}

function closeImageZoomModal() {
    const modal = document.getElementById('imageZoomModal');
    if (modal) {
        modal.classList.add('hidden');
        resetImageZoom();
    }
}

function zoomImageModal(factor) {
    const img = document.getElementById('zoomModalImage');
    const container = document.getElementById('zoomImageContainer');
    
    if (!img || !container) return;
    
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
    
    updateImageZoomLevel();
}

function resetImageZoom() {
    const img = document.getElementById('zoomModalImage');
    const container = document.getElementById('zoomImageContainer');
    
    if (!img || !container) return;
    
    currentZoom = 1;
    img.style.transform = 'scale(1)';
    img.style.transformOrigin = 'center center';
    container.style.cursor = 'default';
    img.style.cursor = 'zoom-in';
    updateImageZoomLevel();
}

function updateImageZoomLevel() {
    const percentage = Math.round(currentZoom * 100);
    const zoomLevelEl = document.getElementById('imageZoomLevel');
    if (zoomLevelEl) {
        zoomLevelEl.textContent = `Zoom: ${percentage}%`;
    }
}

function downloadZoomModalImage() {
    const link = document.createElement('a');
    link.href = currentImageSrc;
    link.download = 'bukti_pembayaran_' + new Date().getTime() + '.jpg';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

let listenersSetup = false;

function setupImageZoomListeners() {
    if (listenersSetup) return; // Prevent duplicate listeners
    listenersSetup = true;
    
    // Keyboard shortcuts - global listener
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('imageZoomModal');
        if (modal && !modal.classList.contains('hidden')) {
            if (e.key === 'Escape') {
                e.preventDefault();
                closeImageZoomModal();
            }
            if (e.key === '+' || e.key === '=') {
                e.preventDefault();
                zoomImageModal(1.25);
            }
            if (e.key === '-' || e.key === '_') {
                e.preventDefault();
                zoomImageModal(0.8);
            }
            if (e.key === '0') {
                e.preventDefault();
                resetImageZoom();
            }
            if (e.key === 'f' || e.key === 'F') {
                e.preventDefault();
                resetImageZoom();
            }
        }
    });
}

function attachContainerListeners() {
    // Drag to pan functionality
    const container = document.getElementById('zoomImageContainer');
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
    
    // Mouse wheel zoom
    const img = document.getElementById('zoomModalImage');
    if (img) {
        img.addEventListener('wheel', function(e) {
            const modal = document.getElementById('imageZoomModal');
            if (modal && !modal.classList.contains('hidden')) {
                e.preventDefault();
                if (e.deltaY < 0) {
                    zoomImageModal(1.1);
                } else {
                    zoomImageModal(0.9);
                }
            }
        }, { passive: false });
    }
    
    // Close on background click
    const modal = document.getElementById('imageZoomModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeImageZoomModal();
            }
        });
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.id === 'paymentDetailModal') {
        hidePaymentDetailModal();
    }
    if (e.target.id === 'rejectPaymentModal') {
        hideRejectModal();
    }
});

// Initialize zoom modal on page load
document.addEventListener('DOMContentLoaded', function() {
    createImageZoomModal();
});
</script>
@endsection