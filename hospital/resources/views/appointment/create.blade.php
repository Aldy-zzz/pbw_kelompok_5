@extends('layouts.app')

@section('title', 'Daftar Janji Temu - RS Sehat Sejahtera')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 py-12 px-4">
    <div class="container mx-auto max-w-4xl">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">📋 Formulir Pendaftaran</h2>
            <p class="text-xl text-gray-600">Isi data Anda untuk membuat janji temu dengan dokter</p>
        </div>
        
        <!-- Multi-step Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div id="step-1-indicator" class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                        <span class="ml-2 text-sm font-semibold text-blue-600">Data Pribadi</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-4">
                        <div id="progress-1-2" class="h-full bg-gray-200 transition-all duration-500"></div>
                    </div>
                    <div class="flex items-center">
                        <div id="step-2-indicator" class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        <span class="ml-2 text-sm text-gray-600">Pilih Dokter</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-4">
                        <div id="progress-2-3" class="h-full bg-gray-200 transition-all duration-500"></div>
                    </div>
                    <div class="flex items-center">
                        <div id="step-3-indicator" class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <span class="ml-2 text-sm text-gray-600">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <form id="appointment-form" class="space-y-6">
                @csrf
                
                <!-- Step 1: Data Pribadi -->
                <div id="step-1" class="step-content">
                    <h4 class="text-2xl font-bold text-gray-800 mb-6">📋 Data Pribadi Pasien</h4>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama" id="nama" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama lengkap sesuai KTP">
                            <p class="text-xs text-gray-500 mt-1">Nama harus sesuai dengan identitas resmi</p>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">No. Telepon *</label>
                                <input type="tel" name="telepon" id="telepon" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="08xxxxxxxxxx">
                                <p class="text-xs text-gray-500 mt-1">Nomor aktif untuk konfirmasi</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Email *</label>
                                <input type="email" name="email" id="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="nama@email.com">
                                <p class="text-xs text-gray-500 mt-1">Untuk notifikasi janji temu</p>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Tanggal Lahir *</label>
                                <input type="date" name="tanggal_lahir" id="tanggal-lahir" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" max="{{ date('Y-m-d') }}">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin *</label>
                                <select name="jenis_kelamin" id="jenis-kelamin" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Alamat Lengkap *</label>
                            <textarea name="alamat" id="alamat" required rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan alamat lengkap dengan RT/RW, Kelurahan, Kecamatan, Kota"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-8">
                        <button type="button" onclick="nextStep(2)" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all">
                            Lanjutkan →
                        </button>
                    </div>
                </div>

                <!-- Step 2: Pilih Dokter & Jadwal -->
                <div id="step-2" class="step-content hidden">
                    <h4 class="text-2xl font-bold text-gray-800 mb-6">👨‍⚕️ Pilih Dokter & Jadwal</h4>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-4">Pilih Dokter Spesialis *</label>
                            <div class="grid gap-4">
                                @foreach($doctors as $doctor)
                                <div class="doctor-option border border-gray-300 rounded-lg p-4 cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all" onclick="selectDoctor({{ $doctor->id }}, '{{ $doctor->name }}', {{ $doctor->consultation_fee }})">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-{{ $doctor->color }}-500 rounded-full flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-gray-800">{{ $doctor->name }}</h5>
                                                <p class="text-sm text-gray-600">{{ $doctor->specialty }}</p>
                                                <p class="text-xs text-gray-500">{{ implode(', ', array_slice($doctor->skills ?? [], 0, 3)) }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-green-600">{{ $doctor->formatted_fee }}</p>
                                            <p class="text-xs text-gray-500">Biaya konsultasi</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="doctor_id" id="doctor-id" required>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Tanggal Konsultasi *</label>
                                <input type="date" name="tanggal" id="tanggal" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="{{ date('Y-m-d') }}">
                                <p class="text-xs text-gray-500 mt-1">Pilih tanggal yang tersedia</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Waktu Konsultasi *</label>
                                <select name="waktu" id="waktu" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Pilih Waktu</option>
                                    <option value="08:00">08:00 - 09:00</option>
                                    <option value="09:00">09:00 - 10:00</option>
                                    <option value="10:00">10:00 - 11:00</option>
                                    <option value="11:00">11:00 - 12:00</option>
                                    <option value="13:00">13:00 - 14:00</option>
                                    <option value="14:00">14:00 - 15:00</option>
                                    <option value="15:00">15:00 - 16:00</option>
                                    <option value="16:00">16:00 - 17:00</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Keluhan / Gejala yang Dialami</label>
                            <textarea name="keluhan" id="keluhan" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Jelaskan keluhan, gejala, atau keperluan konsultasi Anda secara detail..."></textarea>
                            <p class="text-xs text-gray-500 mt-1">Informasi ini membantu dokter mempersiapkan konsultasi yang lebih baik</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(1)" class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-400 transition-all">
                            ← Kembali
                        </button>
                        <button type="button" onclick="nextStep(3)" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all">
                            Lanjutkan →
                        </button>
                    </div>
                </div>

                <!-- Step 3: Konfirmasi -->
                <div id="step-3" class="step-content hidden">
                    <h4 class="text-2xl font-bold text-gray-800 mb-6">✅ Konfirmasi Data</h4>
                    
                    <div class="space-y-6">
                        <!-- Summary Card -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h5 class="font-bold text-gray-800 mb-4">Ringkasan Pendaftaran</h5>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <h6 class="font-semibold text-gray-700 mb-3">Data Pasien</h6>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Nama:</span>
                                            <span id="summary-nama" class="font-semibold"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Telepon:</span>
                                            <span id="summary-telepon"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Email:</span>
                                            <span id="summary-email"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Jenis Kelamin:</span>
                                            <span id="summary-gender"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h6 class="font-semibold text-gray-700 mb-3">Detail Konsultasi</h6>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Dokter:</span>
                                            <span id="summary-dokter" class="font-semibold"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Tanggal:</span>
                                            <span id="summary-tanggal"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Waktu:</span>
                                            <span id="summary-waktu"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Biaya:</span>
                                            <span id="summary-biaya" class="font-bold text-green-600"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <h6 class="font-semibold text-gray-700 mb-2">Keluhan:</h6>
                                <p id="summary-keluhan" class="text-sm text-gray-600 bg-gray-50 p-3 rounded"></p>
                            </div>
                        </div>
                        
                        <!-- Terms & Conditions -->
                        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                            <h6 class="font-semibold text-yellow-800 mb-2">⚠️ Syarat & Ketentuan</h6>
                            <div class="text-sm text-yellow-700 space-y-1">
                                <label class="flex items-start">
                                    <input type="checkbox" id="agree-terms" required class="mt-1 mr-2">
                                    <span>Saya menyetujui syarat dan ketentuan yang berlaku</span>
                                </label>
                                <label class="flex items-start">
                                    <input type="checkbox" id="agree-privacy" required class="mt-1 mr-2">
                                    <span>Saya menyetujui kebijakan privasi rumah sakit</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Important Notes -->
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                            <h6 class="font-semibold text-blue-800 mb-2">📋 Catatan Penting</h6>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Admin akan menghubungi Anda dalam 1x24 jam untuk konfirmasi</li>
                                <li>• Datang 15 menit sebelum jadwal konsultasi</li>
                                <li>• Bawa KTP dan kartu BPJS (jika ada)</li>
                                <li>• Pembayaran dapat dilakukan di tempat atau transfer</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(2)" class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-400 transition-all">
                            ← Kembali
                        </button>
                        <button type="submit" id="submit-btn" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-all shadow-lg">
                            🎉 Daftar Sekarang
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Success Message -->
            <div id="success-message" class="hidden mt-6 p-6 bg-gradient-to-r from-green-100 to-blue-100 border border-green-400 text-green-800 rounded-xl shadow-lg">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    
                    <h4 class="text-2xl font-bold text-green-800 mb-2">🎉 Janji Temu Berhasil Dibuat!</h4>
                    
                    <div class="bg-white p-4 rounded-lg mb-4 border-2 border-green-300">
                        <p class="text-sm text-gray-600 mb-1">ID Appointment:</p>
                        <p class="text-3xl font-mono font-bold text-blue-600" id="registration-id"></p>
                    </div>
                    
                    <!-- Patient ID (always show) -->
                    <div id="patient-id-display" class="hidden bg-white p-4 rounded-lg mb-4 border-2 border-purple-300">
                        <p class="text-sm text-gray-600 mb-1">ID Pasien Anda:</p>
                        <p class="text-2xl font-mono font-bold text-purple-600" id="patient-id-value"></p>
                        <p class="text-xs text-gray-500 mt-1">Gunakan untuk identifikasi di rumah sakit</p>
                    </div>
                    
                    <!-- Password Section (only for new users) -->
                    <div id="password-section" class="hidden bg-white p-4 rounded-lg mb-4 border-2 border-blue-300">
                        <p class="text-sm text-gray-600 mb-1">Password Login Anda:</p>
                        <p class="text-2xl font-mono font-bold text-red-600" id="registration-password"></p>
                        <p class="text-xs text-red-600 mt-2">⚠️ Simpan password ini! Untuk login ke dashboard</p>
                    </div>
                    
                    <!-- Existing User Notice (only for existing users) -->
                    <div id="existing-user-notice" class="hidden bg-blue-50 border border-blue-300 p-4 rounded-lg mb-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                            <div class="text-left">
                                <h5 class="font-bold text-blue-800 mb-2">ℹ️ Akun Sudah Terdaftar</h5>
                                <p class="text-sm text-blue-700 mb-2">Anda sudah memiliki akun di sistem kami. Gunakan password yang sama untuk login.</p>
                                <p class="text-sm text-blue-700">Jika lupa password, silakan hubungi admin atau gunakan fitur reset password.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 border border-yellow-300 p-4 rounded-lg mb-4">
                        <h5 class="font-bold text-yellow-800 mb-2">📝 Langkah Selanjutnya:</h5>
                        <ul class="text-sm text-yellow-700 space-y-1 text-left">
                            <li>• <strong>Login</strong> ke dashboard untuk melihat status janji temu</li>
                            <li>• <strong>Email konfirmasi</strong> telah dikirim (cek inbox/spam)</li>
                            <li>• <strong>Admin akan menghubungi</strong> dalam 1x24 jam untuk konfirmasi</li>
                            <li>• Setelah dikonfirmasi, lakukan <strong>pembayaran</strong> dan upload bukti</li>
                        </ul>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('login') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-all inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            </svg>
                            Login Sekarang
                        </a>
                        <a href="{{ route('home') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-400 transition-all inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentStep = 1;
let selectedDoctorName = '';
let selectedDoctorCost = 0;

function nextStep(step) {
    if (!validateCurrentStep()) {
        return;
    }
    
    document.getElementById(`step-${currentStep}`).classList.add('hidden');
    updateProgressIndicators(step);
    document.getElementById(`step-${step}`).classList.remove('hidden');
    currentStep = step;
    
    if (step === 3) {
        populateSummary();
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevStep(step) {
    document.getElementById(`step-${currentStep}`).classList.add('hidden');
    updateProgressIndicators(step);
    document.getElementById(`step-${step}`).classList.remove('hidden');
    currentStep = step;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateProgressIndicators(targetStep) {
    for (let i = 1; i <= 3; i++) {
        const indicator = document.getElementById(`step-${i}-indicator`);
        const label = indicator.nextElementSibling;
        
        if (i <= targetStep) {
            indicator.className = 'w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold';
            label.className = 'ml-2 text-sm font-semibold text-blue-600';
        } else {
            indicator.className = 'w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold';
            label.className = 'ml-2 text-sm text-gray-600';
        }
    }
    
    const progress12 = document.getElementById('progress-1-2');
    const progress23 = document.getElementById('progress-2-3');
    
    progress12.className = targetStep >= 2 ? 'h-full bg-blue-600 transition-all duration-500' : 'h-full bg-gray-200 transition-all duration-500';
    progress23.className = targetStep >= 3 ? 'h-full bg-blue-600 transition-all duration-500' : 'h-full bg-gray-200 transition-all duration-500';
}

function validateCurrentStep() {
    if (currentStep === 1) {
        const nama = document.getElementById('nama').value.trim();
        const telepon = document.getElementById('telepon').value.trim();
        const email = document.getElementById('email').value.trim();
        const tanggalLahir = document.getElementById('tanggal-lahir').value;
        const jenisKelamin = document.getElementById('jenis-kelamin').value;
        const alamat = document.getElementById('alamat').value.trim();
        
        if (!nama || !telepon || !email || !tanggalLahir || !jenisKelamin || !alamat) {
            showNotification('Semua field harus diisi!', 'error');
            return false;
        }
        
        const phoneRegex = /^[0-9+\-\s()]{10,15}$/;
        if (!phoneRegex.test(telepon)) {
            showNotification('Format nomor telepon tidak valid!', 'error');
            return false;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showNotification('Format email tidak valid!', 'error');
            return false;
        }
        
        return true;
    } else if (currentStep === 2) {
        const dokter = document.getElementById('doctor-id').value;
        const tanggal = document.getElementById('tanggal').value;
        const waktu = document.getElementById('waktu').value;
        
        if (!dokter) {
            showNotification('Pilih dokter terlebih dahulu!', 'error');
            return false;
        }
        
        if (!tanggal || !waktu) {
            showNotification('Tanggal dan waktu konsultasi harus dipilih!', 'error');
            return false;
        }
        
        return true;
    }
    
    return true;
}

function selectDoctor(doctorId, doctorName, cost) {
    document.querySelectorAll('.doctor-option').forEach(option => {
        option.classList.remove('border-blue-500', 'bg-blue-50');
        option.classList.add('border-gray-300');
    });
    
    event.currentTarget.classList.remove('border-gray-300');
    event.currentTarget.classList.add('border-blue-500', 'bg-blue-50');
    
    document.getElementById('doctor-id').value = doctorId;
    selectedDoctorName = doctorName;
    selectedDoctorCost = cost;
    
    showNotification(`Dokter ${doctorName} dipilih!`, 'success');
}

function populateSummary() {
    document.getElementById('summary-nama').textContent = document.getElementById('nama').value;
    document.getElementById('summary-telepon').textContent = document.getElementById('telepon').value;
    document.getElementById('summary-email').textContent = document.getElementById('email').value;
    document.getElementById('summary-gender').textContent = document.getElementById('jenis-kelamin').value;
    document.getElementById('summary-dokter').textContent = selectedDoctorName;
    
    const tanggal = new Date(document.getElementById('tanggal').value);
    document.getElementById('summary-tanggal').textContent = tanggal.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    document.getElementById('summary-waktu').textContent = document.getElementById('waktu').value + ':00';
    document.getElementById('summary-biaya').textContent = 'Rp ' + selectedDoctorCost.toLocaleString('id-ID');
    document.getElementById('summary-keluhan').textContent = document.getElementById('keluhan').value || 'Konsultasi umum';
}

// Form submission
document.getElementById('appointment-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const agreeTerms = document.getElementById('agree-terms').checked;
    const agreePrivacy = document.getElementById('agree-privacy').checked;
    
    if (!agreeTerms || !agreePrivacy) {
        showNotification('Anda harus menyetujui syarat dan ketentuan!', 'error');
        return;
    }
    
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Memproses...';
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("appointment.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('appointment-form').classList.add('hidden');
            document.getElementById('registration-id').textContent = data.appointment_id;
            
            // Show different message for existing vs new users
            const passwordSection = document.getElementById('password-section');
            const existingUserNotice = document.getElementById('existing-user-notice');
            const patientIdDisplay = document.getElementById('patient-id-display');
            
            if (data.is_new_user && data.password) {
                // New user - show password
                document.getElementById('registration-password').textContent = data.password;
                passwordSection.classList.remove('hidden');
                existingUserNotice.classList.add('hidden');
            } else {
                // Existing user - hide password, show notice
                passwordSection.classList.add('hidden');
                existingUserNotice.classList.remove('hidden');
            }
            
            // Show patient ID
            if (data.patient_id) {
                document.getElementById('patient-id-value').textContent = data.patient_id;
                patientIdDisplay.classList.remove('hidden');
            }
            
            document.getElementById('success-message').classList.remove('hidden');
            
            showNotification(data.message, 'success');
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            // Check if user already registered
            if (data.already_registered && data.redirect_to_login) {
                // Show error with redirect to login
                showNotification(data.message, 'error');
                
                // Show modal or alert with redirect option
                if (confirm(data.message + '\n\nKlik OK untuk ke halaman login.')) {
                    window.location.href = '{{ route("login") }}';
                } else {
                    submitBtn.disabled = false;
                    submitBtn.textContent = '🎉 Daftar Sekarang';
                }
            } else {
                showNotification(data.message || 'Terjadi kesalahan!', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = '🎉 Daftar Sekarang';
            }
        }
} catch (error) {
showNotification('Terjadi kesalahan saat mengirim data!', 'error');
submitBtn.disabled = false;
submitBtn.textContent = '🎉 Daftar Sekarang';
}
});
</script>
@endpush
@endsection