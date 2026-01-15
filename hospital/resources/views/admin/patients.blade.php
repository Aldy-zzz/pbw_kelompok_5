@extends('layouts.app')

@section('title', 'Kelola Pasien - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Kelola Pasien</h1>
                    <p class="text-gray-600 mt-2">Manajemen data pasien rumah sakit</p>
                </div>
                
                <!-- Search and Actions -->
                <div class="flex space-x-4">
                    <div class="relative">
                        <input type="text" id="searchPatient" placeholder="Cari pasien..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 w-64">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                    </div>
                    
                    @if($patients->count() > 0)
                    <button onclick="confirmDeleteAllPatients()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                        </svg>
                        Hapus Semua Data
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Pasien</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $patients->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Pasien Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $activePatients }}</p>
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
                        <p class="text-sm text-gray-600">Baru Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $newThisMonth }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Appointment</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalAppointments }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patients Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Daftar Pasien</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full" id="patientsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info Medis</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($patients as $patient)
                        <tr class="hover:bg-gray-50 patient-row">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        {{ strtoupper(substr($patient->user->name, 0, 2)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 patient-name">{{ $patient->user->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $patient->patient_id }}</div>
                                        @if($patient->birth_date)
                                        <div class="text-xs text-gray-400">
                                            @php
                                                $age = $patient->birth_date ? $patient->birth_date->age : null;
                                            @endphp
                                            {{ $age ? $age . ' tahun' : 'Umur tidak diketahui' }}
                                            @if($patient->gender)
                                                • {{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $patient->user->phone }}</div>
                                <div class="text-sm text-gray-500">{{ $patient->user->email }}</div>
                                @if($patient->address)
                                <div class="text-xs text-gray-400 mt-1">{{ Str::limit($patient->address, 30) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($patient->blood_type)
                                <div class="text-sm font-medium text-red-600">{{ $patient->blood_type }}</div>
                                @endif
                                @if($patient->emergency_contact)
                                <div class="text-xs text-gray-500">Kontak Darurat:</div>
                                <div class="text-xs text-gray-600">{{ $patient->emergency_contact }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $patient->appointments_count }} kali</div>
                                @if($patient->appointments->count() > 0)
                                    @php $lastAppointment = $patient->appointments->first(); @endphp
                                    <div class="text-xs text-gray-500">Terakhir: {{ $lastAppointment->appointment_date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $lastAppointment->doctor->name }}</div>
                                @else
                                    <div class="text-xs text-gray-400">Belum ada appointment</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $patient->user->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $patient->user->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <button onclick="showPatientDetail({{ $patient->id }})" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                        </svg>
                                    </button>
                                    
                                    <button onclick="showPatientHistory({{ $patient->id }})" class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50" title="Riwayat Appointment">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                        </svg>
                                    </button>
                                    
                                    <a href="{{ route('admin.appointments', ['patient_id' => $patient->id]) }}" class="text-purple-600 hover:text-purple-900 p-1 rounded hover:bg-purple-50" title="Lihat Appointments">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Delete Button - Only show if patient has completed/cancelled all appointments or no appointments -->
                                    @php
                                        $canDelete = $patient->appointments->count() === 0 || 
                                                    $patient->appointments->every(function($appointment) {
                                                        return in_array($appointment->status, ['completed', 'cancelled']);
                                                    });
                                    @endphp
                                    
                                    @if($canDelete)
                                    <button onclick="confirmDeletePatient({{ $patient->id }}, '{{ $patient->user->name }}')" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" title="Hapus Pasien">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                    </button>
                                    @else
                                    <span class="text-gray-300 p-1 rounded cursor-not-allowed" title="Tidak dapat dihapus - masih ada appointment yang belum selesai">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                <p class="text-lg font-medium">Belum ada pasien</p>
                                <p class="text-sm">Pasien akan muncul setelah melakukan pendaftaran</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Patient Detail Modal -->
<div id="patientDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Detail Pasien</h3>
            </div>
            
            <div id="patientDetailContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
            
            <div class="p-6 border-t border-gray-200 flex justify-end">
                <button onclick="hidePatientDetailModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Patient History Modal -->
<div id="patientHistoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-5xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Riwayat Appointment</h3>
            </div>
            
            <div id="patientHistoryContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
            
            <div class="p-6 border-t border-gray-200 flex justify-end">
                <button onclick="hidePatientHistoryModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Patient Modal -->
<div id="deletePatientModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-red-600">Konfirmasi Hapus Pasien</h3>
            </div>
            
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-800 font-medium">Apakah Anda yakin ingin menghapus pasien ini?</p>
                        <p id="deletePatientName" class="text-sm text-gray-600 mt-1"></p>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        <div class="text-sm text-yellow-800">
                            <p class="font-medium">Peringatan:</p>
                            <p>Tindakan ini akan menghapus:</p>
                            <ul class="list-disc list-inside mt-1">
                                <li>Data pasien</li>
                                <li>Akun user terkait</li>
                                <li>Semua data terkait</li>
                            </ul>
                            <p class="mt-2 font-medium">Tindakan ini tidak dapat dibatalkan!</p>
                        </div>
                    </div>
                </div>
                
                <form id="deletePatientForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="hideDeletePatientModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                            Ya, Hapus Pasien
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete All Patients Modal -->
<div id="deleteAllPatientsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-red-600">⚠️ Konfirmasi Hapus Semua Data Pasien</h3>
            </div>
            
            <div class="p-6">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-800 font-bold text-lg mb-2">Apakah Anda YAKIN ingin menghapus SEMUA data pasien?</p>
                        <p class="text-sm text-gray-600">Tindakan ini sangat berbahaya dan tidak dapat dibatalkan!</p>
                    </div>
                </div>
                
                <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4 mb-6">
                    <div class="text-sm text-red-800">
                        <p class="font-bold mb-2">🔥 PERINGATAN KERAS:</p>
                        <p class="mb-2">Tindakan ini akan menghapus:</p>
                        <ul class="list-disc list-inside space-y-1 mb-3">
                            <li><strong>SEMUA data pasien</strong> ({{ $patients->count() }} pasien)</li>
                            <li><strong>SEMUA appointment</strong></li>
                            <li><strong>SEMUA pembayaran</strong></li>
                            <li><strong>SEMUA user pasien</strong></li>
                            <li><strong>SEMUA gambar bukti pembayaran</strong></li>
                        </ul>
                        <p class="font-bold text-red-900">⚠️ TINDAKAN INI TIDAK DAPAT DIBATALKAN!</p>
                        <p class="mt-2 text-xs">ID akan direset dan dimulai dari RSH001</p>
                    </div>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">ℹ️ Yang TIDAK akan terhapus:</p>
                            <ul class="list-disc list-inside">
                                <li>Data admin</li>
                                <li>Data dokter</li>
                                <li>Konfigurasi sistem</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <form id="deleteAllPatientsForm" onsubmit="event.preventDefault(); deleteAllPatients();">
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="hideDeleteAllPatientsModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                            Ya, Hapus Semua Data!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchPatient').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.patient-row');
    
    rows.forEach(row => {
        const patientName = row.querySelector('.patient-name').textContent.toLowerCase();
        const patientId = row.querySelector('td:first-child .text-gray-500').textContent.toLowerCase();
        const phone = row.querySelector('td:nth-child(2) .text-gray-900').textContent.toLowerCase();
        const email = row.querySelector('td:nth-child(2) .text-gray-500').textContent.toLowerCase();
        
        if (patientName.includes(searchTerm) || 
            patientId.includes(searchTerm) || 
            phone.includes(searchTerm) || 
            email.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function showPatientDetail(patientId) {
    fetch(`/admin/patients/${patientId}/detail`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const birthDate = data.birth_date ? new Date(data.birth_date).toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long', 
                day: 'numeric'
            }) : 'Tidak diisi';
            
            const age = data.birth_date ? new Date().getFullYear() - new Date(data.birth_date).getFullYear() : 'Tidak diketahui';
            
            document.getElementById('patientDetailContent').innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Informasi Pribadi</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama Lengkap:</span>
                                <span class="font-medium">${data.user.name}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Pasien:</span>
                                <span class="font-medium">${data.patient_id}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Telepon:</span>
                                <span class="font-medium">${data.user.phone}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">${data.user.email}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Lahir:</span>
                                <span class="font-medium">${birthDate}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Umur:</span>
                                <span class="font-medium">${age} tahun</span>
                            </div>
                            ${data.gender ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis Kelamin:</span>
                                <span class="font-medium">${data.gender === 'male' ? 'Laki-laki' : 'Perempuan'}</span>
                            </div>
                            ` : ''}
                            ${data.address ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Alamat:</span>
                                <span class="font-medium">${data.address}</span>
                            </div>
                            ` : ''}
                        </div>
                        
                        <h4 class="text-lg font-bold text-gray-800 mb-4 mt-6">Informasi Medis</h4>
                        <div class="space-y-3 text-sm">
                            ${data.blood_type ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Golongan Darah:</span>
                                <span class="font-medium text-red-600">${data.blood_type}</span>
                            </div>
                            ` : '<div class="text-gray-500 text-sm">Golongan darah belum diisi</div>'}
                            ${data.emergency_contact ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kontak Darurat:</span>
                                <span class="font-medium">${data.emergency_contact}</span>
                            </div>
                            ` : '<div class="text-gray-500 text-sm">Kontak darurat belum diisi</div>'}
                            <div class="flex justify-between">
                                <span class="text-gray-600">Terdaftar:</span>
                                <span class="font-medium">${new Date(data.user.created_at).toLocaleDateString('id-ID')}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Statistik Appointment</h4>
                        <div class="space-y-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">${data.appointments_count || 0}</div>
                                <div class="text-sm text-blue-700">Total Appointment</div>
                            </div>
                            
                            ${data.appointments && data.appointments.length > 0 ? `
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="text-sm font-medium text-green-800">Appointment Terakhir</div>
                                <div class="text-sm text-green-700">${new Date(data.appointments[0].appointment_date).toLocaleDateString('id-ID')}</div>
                                <div class="text-xs text-green-600">Dr. ${data.appointments[0].doctor.name}</div>
                            </div>
                            ` : `
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-600">Belum ada appointment</div>
                            </div>
                            `}
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('patientDetailModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail pasien');
        });
}

function hidePatientDetailModal() {
    document.getElementById('patientDetailModal').classList.add('hidden');
}

function showPatientHistory(patientId) {
    fetch(`/admin/patients/${patientId}/history`)
        .then(response => response.json())
        .then(data => {
            let historyHtml = `
                <div class="mb-4">
                    <h4 class="text-lg font-bold text-gray-800">Riwayat Appointment - ${data.patient.user.name}</h4>
                    <p class="text-sm text-gray-600">ID Pasien: ${data.patient.patient_id}</p>
                </div>
            `;
            
            if (data.appointments.length > 0) {
                historyHtml += `
                    <div class="space-y-4">
                        ${data.appointments.map(appointment => `
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="font-medium text-gray-900">${appointment.appointment_id}</div>
                                        <div class="text-sm text-gray-600">Dr. ${appointment.doctor.name}</div>
                                        <div class="text-sm text-gray-500">${new Date(appointment.appointment_date).toLocaleDateString('id-ID')} • ${appointment.appointment_time}</div>
                                        ${appointment.complaints ? `<div class="text-xs text-gray-400 mt-1">${appointment.complaints}</div>` : ''}
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${getStatusClass(appointment.status)}">${getStatusText(appointment.status)}</span>
                                        <div class="text-sm font-medium text-green-600 mt-1">Rp ${new Intl.NumberFormat('id-ID').format(appointment.consultation_fee)}</div>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            } else {
                historyHtml += `
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                        <p class="text-lg font-medium">Belum ada riwayat appointment</p>
                        <p class="text-sm">Pasien belum pernah melakukan appointment</p>
                    </div>
                `;
            }
            
            document.getElementById('patientHistoryContent').innerHTML = historyHtml;
            document.getElementById('patientHistoryModal').classList.remove('hidden');
        });
}

function hidePatientHistoryModal() {
    document.getElementById('patientHistoryModal').classList.add('hidden');
}

function confirmDeletePatient(patientId, patientName) {
    document.getElementById('deletePatientName').textContent = `Pasien: ${patientName}`;
    document.getElementById('deletePatientForm').action = `/admin/patients/${patientId}`;
    document.getElementById('deletePatientModal').classList.remove('hidden');
}

function hideDeletePatientModal() {
    document.getElementById('deletePatientModal').classList.add('hidden');
}

function getStatusClass(status) {
    switch(status) {
        case 'pending': return 'bg-yellow-100 text-yellow-800';
        case 'confirmed': return 'bg-blue-100 text-blue-800';
        case 'pending_payment_verification': return 'bg-purple-100 text-purple-800';
        case 'paid': return 'bg-green-100 text-green-800';
        case 'cancelled': return 'bg-red-100 text-red-800';
        case 'completed': return 'bg-gray-100 text-gray-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

function getStatusText(status) {
    switch(status) {
        case 'pending': return 'Pending';
        case 'confirmed': return 'Dikonfirmasi';
        case 'pending_payment_verification': return 'Verifikasi Bayar';
        case 'paid': return 'Lunas';
        case 'cancelled': return 'Dibatalkan';
        case 'completed': return 'Selesai';
        default: return status;
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.id === 'patientDetailModal') {
        hidePatientDetailModal();
    }
    if (e.target.id === 'patientHistoryModal') {
        hidePatientHistoryModal();
    }
    if (e.target.id === 'deletePatientModal') {
        hideDeletePatientModal();
    }
    if (e.target.id === 'deleteAllPatientsModal') {
        hideDeleteAllPatientsModal();
    }
});

// Delete all patients functions
function confirmDeleteAllPatients() {
    document.getElementById('deleteAllPatientsModal').classList.remove('hidden');
}

function hideDeleteAllPatientsModal() {
    document.getElementById('deleteAllPatientsModal').classList.add('hidden');
}

function deleteAllPatients() {
    const form = document.getElementById('deleteAllPatientsForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menghapus...';
    
    fetch('{{ route("admin.patients.delete-all") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            hideDeleteAllPatientsModal();
            
            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    <span>${data.message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Reload page after 2 seconds
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            alert(data.message || 'Terjadi kesalahan saat menghapus data');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus data');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}
</script>
@endsection