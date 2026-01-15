@extends('layouts.app')

@section('title', 'Login - RS Sehat Sejahtera')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        
        <!-- Unified Login -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 scale-in">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">Login</h3>
                <p class="text-gray-600 mt-2">RS Sehat Sejahtera</p>
                <p class="text-sm text-gray-500 mt-1">Admin & Pasien</p>
            </div>
            
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <div>
                        @foreach($errors->all() as $error)
                        <p class="text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
            @endif
            
            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200 mb-6">
                <button onclick="switchTab('email')" id="tab-email" class="flex-1 py-3 text-center font-semibold text-blue-600 border-b-2 border-blue-600 transition-colors">
                    Email & Password
                </button>
                <button onclick="switchTab('simple')" id="tab-simple" class="flex-1 py-3 text-center font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-700 transition-colors">
                    Email & No. HP
                </button>
            </div>
            
            <!-- Login with Email & Password (Unified for Admin & Patient) -->
            <form id="login-email-form" action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="email@example.com">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="••••••••">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-gray-700">Ingat saya</label>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-green-600 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-green-700 transition-all shadow-lg">
                    Login
                </button>
            </form>
            
            <!-- Login with Email & Phone (Simple Login for Patient) -->
            <form id="login-simple-form" action="{{ route('patient.login.id') }}" method="POST" class="space-y-4 hidden">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                           placeholder="contoh@gmail.com">
                    <p class="text-xs text-gray-500 mt-1">Email yang Anda gunakan saat daftar</p>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">No. HP</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                           placeholder="08123456789">
                    <p class="text-xs text-gray-500 mt-1">Nomor HP yang Anda daftarkan</p>
                </div>
                
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-700 mb-2">
                        <strong>✨ Login Mudah Tanpa Password!</strong>
                    </p>
                    <ul class="text-xs text-green-700 space-y-1">
                        <li>• Masukkan <strong>Email</strong> yang Anda gunakan saat daftar</li>
                        <li>• Masukkan <strong>Nomor HP</strong> yang sama</li>
                        <li>• Tidak perlu mengingat password!</li>
                        <li>• Setiap appointment Anda akan mendapat ID unik (RSH001, RSH002, dst)</li>
                    </ul>
                </div>
                
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-all shadow-lg">
                    Login Pasien
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600">Belum punya akun?</p>
                <a href="{{ route('appointment.create') }}" class="text-blue-600 font-semibold hover:text-blue-700">Daftar Sekarang</a>
                <p class="text-xs text-gray-500 mt-2">Jika sudah punya akun, silakan login untuk membuat janji temu baru</p>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 text-center">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                    </svg>
                    Login aman untuk pasien dan staff rumah sakit
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        const emailTab = document.getElementById('tab-email');
        const simpleTab = document.getElementById('tab-simple');
        const emailForm = document.getElementById('login-email-form');
        const simpleForm = document.getElementById('login-simple-form');
        
        if (tab === 'email') {
            emailTab.classList.add('text-blue-600', 'border-blue-600');
            emailTab.classList.remove('text-gray-500', 'border-transparent');
            simpleTab.classList.remove('text-blue-600', 'border-blue-600');
            simpleTab.classList.add('text-gray-500', 'border-transparent');
            
            emailForm.classList.remove('hidden');
            simpleForm.classList.add('hidden');
        } else {
            simpleTab.classList.add('text-blue-600', 'border-blue-600');
            simpleTab.classList.remove('text-gray-500', 'border-transparent');
            emailTab.classList.remove('text-blue-600', 'border-blue-600');
            emailTab.classList.add('text-gray-500', 'border-transparent');
            
            simpleForm.classList.remove('hidden');
            emailForm.classList.add('hidden');
        }
    }
</script>
@endsection