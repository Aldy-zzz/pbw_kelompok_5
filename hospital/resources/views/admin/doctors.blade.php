@extends('layouts.app')

@section('title', 'Kelola Dokter - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Kelola Dokter</h1>
                    <p class="text-gray-600 mt-2">Manajemen data dokter rumah sakit</p>
                </div>
                <button onclick="showAddDoctorModal()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Dokter
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.11 3.89 23 5 23H19C20.11 23 21 22.11 21 21V9M12 7C14.21 7 16 8.79 16 11C16 13.21 14.21 15 12 15C9.79 15 8 13.21 8 11C8 8.79 9.79 7 12 7Z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Dokter</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $doctors->count() }}</p>
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
                        <p class="text-sm text-gray-600">Dokter Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $doctors->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Dokter Non-Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $doctors->where('is_active', false)->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Spesialisasi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $doctors->pluck('specialty')->unique()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctors Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Daftar Dokter</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesialisasi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya Konsultasi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengalaman</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($doctors as $doctor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background-color: {{ $doctor->color ?? '#3B82F6' }}">
                                        {{ strtoupper(substr($doctor->name, 0, 2)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $doctor->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $doctor->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $doctor->specialty }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-green-600">Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $doctor->experience_years }} tahun</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($doctor->is_active)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button onclick="showEditDoctorModal({{ $doctor->id }})" class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                    </svg>
                                </button>
                                
                                <form action="{{ route('admin.doctors.toggle', $doctor->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="{{ $doctor->is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}">
                                        @if($doctor->is_active)
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                                
                                <button onclick="confirmDelete({{ $doctor->id }})" class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.11 3.89 23 5 23H19C20.11 23 21 22.11 21 21V9M12 7C14.21 7 16 8.79 16 11C16 13.21 14.21 15 12 15C9.79 15 8 13.21 8 11C8 8.79 9.79 7 12 7Z"/>
                                </svg>
                                <p class="text-lg font-medium">Belum ada dokter</p>
                                <p class="text-sm">Tambahkan dokter pertama untuk memulai</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Doctor Modal -->
<div id="addDoctorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Tambah Dokter Baru</h3>
            </div>
            
            <form action="{{ route('admin.doctors.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Dokter</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Spesialisasi</label>
                        <input type="text" name="specialty" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Konsultasi</label>
                        <input type="number" name="consultation_fee" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pengalaman (tahun)</label>
                        <input type="number" name="experience_years" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna Avatar</label>
                        <input type="color" name="color" value="#3B82F6" class="w-full h-12 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="is_active" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keahlian (pisahkan dengan koma)</label>
                    <input type="text" name="skills" placeholder="Contoh: Bedah Jantung, Konsultasi Umum, Emergency" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div class="flex justify-end space-x-4 mt-8">
                    <button type="button" onclick="hideAddDoctorModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan Dokter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Doctor Modal -->
<div id="editDoctorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Edit Dokter</h3>
            </div>
            
            <form id="editDoctorForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Dokter</label>
                        <input type="text" name="name" id="edit_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Spesialisasi</label>
                        <input type="text" name="specialty" id="edit_specialty" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Konsultasi</label>
                        <input type="number" name="consultation_fee" id="edit_consultation_fee" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pengalaman (tahun)</label>
                        <input type="number" name="experience_years" id="edit_experience_years" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna Avatar</label>
                        <input type="color" name="color" id="edit_color" class="w-full h-12 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="is_active" id="edit_is_active" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" id="edit_description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keahlian (pisahkan dengan koma)</label>
                    <input type="text" name="skills" id="edit_skills" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div class="flex justify-end space-x-4 mt-8">
                    <button type="button" onclick="hideEditDoctorModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Dokter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal functions
function showAddDoctorModal() {
    document.getElementById('addDoctorModal').classList.remove('hidden');
}

function hideAddDoctorModal() {
    document.getElementById('addDoctorModal').classList.add('hidden');
}

function showEditDoctorModal(doctorId) {
    // Fetch doctor data and populate form
    fetch(`/admin/doctors/${doctorId}/edit`)
        .then(response => response.json())
        .then(doctor => {
            document.getElementById('edit_name').value = doctor.name;
            document.getElementById('edit_specialty').value = doctor.specialty;
            document.getElementById('edit_consultation_fee').value = doctor.consultation_fee;
            document.getElementById('edit_experience_years').value = doctor.experience_years;
            document.getElementById('edit_color').value = doctor.color || '#3B82F6';
            document.getElementById('edit_is_active').value = doctor.is_active ? '1' : '0';
            document.getElementById('edit_description').value = doctor.description || '';
            document.getElementById('edit_skills').value = doctor.skills || '';
            
            document.getElementById('editDoctorForm').action = `/admin/doctors/${doctorId}`;
            document.getElementById('editDoctorModal').classList.remove('hidden');
        });
}

function hideEditDoctorModal() {
    document.getElementById('editDoctorModal').classList.add('hidden');
}

function confirmDelete(doctorId) {
    if (confirm('Apakah Anda yakin ingin menghapus dokter ini? Aksi ini tidak dapat dibatalkan.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/doctors/${doctorId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.id === 'addDoctorModal') {
        hideAddDoctorModal();
    }
    if (e.target.id === 'editDoctorModal') {
        hideEditDoctorModal();
    }
});
</script>
@endsection