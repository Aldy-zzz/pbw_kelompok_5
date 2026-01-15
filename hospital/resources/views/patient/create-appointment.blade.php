@extends('layouts.app')

@section('title', 'Buat Janji Temu Baru')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-green-600 text-white p-6">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold">Buat Janji Temu Baru</h2>
        <p class="opacity-90">Isi form di bawah untuk membuat appointment baru</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Info Pasien -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Data Pasien</h3>
            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600">Nama</p>
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Telepon</p>
                    <p class="font-semibold">{{ auth()->user()->phone }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Email</p>
                    <p class="font-semibold">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600">ID Pasien</p>
                    <p class="font-semibold text-blue-600">{{ $patient->patient_id }}</p>
                </div>
            </div>
        </div>

        <!-- Form Appointment -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Form Janji Temu</h3>
            
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-red-800">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-sm text-red-700">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('patient.appointments.store') }}" method="POST">
                @csrf
                
                <!-- Pilih Dokter -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Pilih Dokter <span class="text-red-500">*</span>
                    </label>
                    <select name="doctor_id" id="doctor_id" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" data-fee="{{ $doctor->consultation_fee }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} - {{ $doctor->specialization }}
                        </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Appointment -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Tanggal Appointment <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="appointment_date" id="appointment_date" required
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           value="{{ old('appointment_date') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('appointment_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waktu Appointment -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Waktu Appointment <span class="text-red-500">*</span>
                    </label>
                    <select name="appointment_time" id="appointment_time" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Waktu --</option>
                        <option value="08:00" {{ old('appointment_time') == '08:00' ? 'selected' : '' }}>08:00</option>
                        <option value="09:00" {{ old('appointment_time') == '09:00' ? 'selected' : '' }}>09:00</option>
                        <option value="10:00" {{ old('appointment_time') == '10:00' ? 'selected' : '' }}>10:00</option>
                        <option value="11:00" {{ old('appointment_time') == '11:00' ? 'selected' : '' }}>11:00</option>
                        <option value="13:00" {{ old('appointment_time') == '13:00' ? 'selected' : '' }}>13:00</option>
                        <option value="14:00" {{ old('appointment_time') == '14:00' ? 'selected' : '' }}>14:00</option>
                        <option value="15:00" {{ old('appointment_time') == '15:00' ? 'selected' : '' }}>15:00</option>
                        <option value="16:00" {{ old('appointment_time') == '16:00' ? 'selected' : '' }}>16:00</option>
                    </select>
                    @error('appointment_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keluhan -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Keluhan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="complaints" id="complaints" rows="4" required
                              placeholder="Jelaskan keluhan Anda..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('complaints') }}</textarea>
                    @error('complaints')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biaya Konsultasi -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-semibold">Biaya Konsultasi:</span>
                        <span id="consultation_fee" class="text-2xl font-bold text-blue-600">Rp 0</span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4">
                    <a href="{{ route('patient.dashboard') }}" 
                       class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 text-center">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                        Buat Janji Temu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Update consultation fee when doctor is selected
document.getElementById('doctor_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const fee = selectedOption.getAttribute('data-fee');
    
    if (fee) {
        const formattedFee = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(fee);
        
        document.getElementById('consultation_fee').textContent = formattedFee;
    } else {
        document.getElementById('consultation_fee').textContent = 'Rp 0';
    }
});

// Trigger change event if doctor is already selected (for old input)
if (document.getElementById('doctor_id').value) {
    document.getElementById('doctor_id').dispatchEvent(new Event('change'));
}
</script>
@endsection
