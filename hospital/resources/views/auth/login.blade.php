@extends('layouts.app')

@section('title', 'Login - RS Sehat Sejahtera')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl w-full grid md:grid-cols-2 gap-8">
        
        <!-- Patient Login -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 scale-in">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">Login Pasien</h3>
                <p class="text-gray-600">Masuk untuk cek status pendaftaran</p>
            </div>
            
            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200 mb-6">
                <button onclick="switchPatientTab('id')" id="patient-tab-id" class="flex-1 py-3 text-center font-semibold text-green-600 border-b-2 border-green-600 transition-colors">
                    Login dengan ID
                </button>
                <button onclick="switchPatientTab('email')" id="patient-tab-email" class="flex-1 py-3 text-center font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-700 transition-colors">
                    Login dengan Email
                </button>
            </div>
            
            <!-- Login with Appointment ID -->
            <form id="patient-login-id-form" action="{{ route('patient.login.id') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">ID Pendaftaran</label>
                    <input type="text" name="patient_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: RSH001">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">No. Telepon</label>
                    <input type="tel" name="phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="08xxxxxxxxxx">
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-green-700">
                        <strong>💡 Info:</strong> Gunakan ID Pendaftaran dan Nomor Telepon yang Anda daftarkan untuk login.
                    </p>
                </div>
                
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-all shadow-lg">
                    Login
                </button>
            </form>
            
            <!-- Login with Email (Hidden by default) -->
            <form id="patient-login-email-form" action="{{ route('patient.login') }}" method="POST" class="space-y-4 hidden">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="email@example.com">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="••••••••">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="patient-remember" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <label for="patient-remember" class="ml-2 text-sm text-gray-700">Ingat saya</label>
                </div>
                
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-all shadow-lg">
                    Login
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600">Belum punya akun?</p>
                <a href="{{ route('appointment.create') }}" class="text-green-600 font-semibold hover:text-green-700">Daftar Sekarang</a>
            </div>
        </div>
        
        <!-- Admin Login -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 scale-in delay-200">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">Login Administrator</h3>
                <p class="text-gray-600">Masuk ke dashboard admin</p>
            </div>
            
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="admin@rssehat.co.id">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="••••••••">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="admin-remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="admin-remember" class="ml-2 text-sm text-gray-700">Ingat saya</label>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-700">
                        <strong>🔐 Demo Login:</strong><br>
                        Email: admin@rssehat.co.id<br>
                        Password: admin123
                    </p>
                </div>
                
                <button type="submit" class="w-full btn-primary text-white py-3 rounded-lg font-semibold shadow-lg">
                    Login
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                    </svg>
                    Area aman untuk staff rumah sakit
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchPatientTab(tab) {
        const idTab = document.getElementById('patient-tab-id');
        const emailTab = document.getElementById('patient-tab-email');
        const idForm = document.getElementById('patient-login-id-form');
        const emailForm = document.getElementById('patient-login-email-form');
        
        if (tab === 'id') {
            idTab.classList.add('text-green-600', 'border-green-600');
            idTab.classList.remove('text-gray-500', 'border-transparent');
            emailTab.classList.remove('text-green-600', 'border-green-600');
            emailTab.classList.add('text-gray-500', 'border-transparent');
            
            idForm.classList.remove('hidden');
            emailForm.classList.add('hidden');
        } else {
            emailTab.classList.add('text-green-600', 'border-green-600');
            emailTab.classList.remove('text-gray-500', 'border-transparent');
            idTab.classList.remove('text-green-600', 'border-green-600');
            idTab.classList.add('text-gray-500', 'border-transparent');
            
            emailForm.classList.remove('hidden');
            idForm.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection