@extends('layouts.app')

@section('title', 'Kontak - RS Sehat Sejahtera')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 py-12 px-4">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">📞 Hubungi Kami</h2>
            <p class="text-xl text-gray-600">Kami siap melayani Anda 24/7</p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Informasi Kontak -->
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h3>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-1">Alamat</h5>
                            <p class="text-gray-600">Jl. Kesehatan Raya No. 123<br>Jakarta Pusat, DKI Jakarta 10110</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-1">Telepon</h5>
                            <p class="text-gray-600">(021) 123-4567<br>0800-1234-5678 (Bebas Pulsa)</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-1">Email</h5>
                            <p class="text-gray-600">info@rssehat.co.id<br>emergency@rssehat.co.id</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-1">Jam Operasional</h5>
                            <p class="text-gray-600">Senin - Jumat: 08:00 - 20:00<br>Sabtu - Minggu: 08:00 - 16:00<br><span class="text-red-600 font-semibold">IGD: 24 Jam</span></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Emergency -->
            <div>
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-8 rounded-2xl shadow-lg text-white text-center mb-8 hover-lift">
                    <svg class="w-16 h-16 mx-auto mb-4 floating-animation" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <h4 class="text-2xl font-bold mb-2">Gawat Darurat</h4>
                    <p class="mb-4">Hubungi segera untuk kondisi darurat</p>
                    <p class="text-4xl font-bold">119</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Buat Janji Temu</h3>
                    <p class="text-gray-600 mb-6">Daftar sekarang untuk konsultasi dengan dokter spesialis kami</p>
                    <a href="{{ route('appointment.create') }}" class="block text-center bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-lg">
                        📅 Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Doctors List -->
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Dokter Spesialis Kami</h3>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($doctors->take(3) as $doctor)
                    <div class="text-center p-4 border border-gray-200 rounded-lg hover:shadow-md transition-all">
                        <div class="w-20 h-20 bg-{{ $doctor->color }}-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-800">{{ $doctor->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $doctor->specialty }}</p>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('doctors') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                    Lihat Semua Dokter →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection