@extends('layouts.app')

@section('title', 'RS Sehat Sejahtera - Beranda')

@section('content')
<!-- Hero Section -->
<section id="beranda" class="gradient-animation min-h-screen flex items-center relative overflow-hidden">
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full floating-animation"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-green-300 bg-opacity-20 rounded-full floating-animation delay-200"></div>
        <div class="absolute bottom-40 left-20 w-24 h-24 bg-blue-300 bg-opacity-15 rounded-full floating-animation delay-400"></div>
        <div class="absolute bottom-20 right-10 w-12 h-12 bg-white bg-opacity-10 rounded-full floating-animation delay-600"></div>
    </div>
    
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-5xl md:text-6xl font-bold mb-6 slide-in-left">
                Kesehatan Anda, <span class="text-green-300">Prioritas Kami</span>
            </h2>
            <p class="text-xl md:text-2xl mb-8 slide-in-right delay-300 opacity-90">
                Melayani dengan sepenuh hati, memberikan perawatan terbaik untuk keluarga Indonesia
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center scale-in delay-500">
                <a href="{{ route('appointment.create') }}" class="btn-primary btn-loading text-white px-8 py-4 rounded-full font-semibold text-lg shadow-lg hover-lift hover-glow">
                    Buat Janji Temu
                </a>
                <a href="#layanan" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold text-lg shadow-lg hover-lift transition-all">
                    Lihat Layanan
                </a>
            </div>
            
            <!-- Stats Section -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 bounce-in delay-600">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-green-300 mb-2">15+</div>
                    <div class="text-sm md:text-base opacity-90">Tahun Pengalaman</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-green-300 mb-2">{{ $doctors->count() }}+</div>
                    <div class="text-sm md:text-base opacity-90">Dokter Spesialis</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-green-300 mb-2">24/7</div>
                    <div class="text-sm md:text-base opacity-90">Layanan IGD</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-green-300 mb-2">10K+</div>
                    <div class="text-sm md:text-base opacity-90">Pasien Puas</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alur Pendaftaran Section -->
<section id="alur" class="py-20 bg-gradient-to-br from-blue-50 to-green-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h3 class="text-4xl font-bold text-gray-800 mb-4">Alur Pelayanan Pasien</h3>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Proses mudah dan cepat dari pendaftaran hingga pembayaran untuk kenyamanan Anda
            </p>
        </div>
        
        <div class="max-w-6xl mx-auto">
            <!-- Timeline with 6 steps (copy dari HTML asli dengan adaptasi Blade) -->
            @include('partials.service-flow')
        </div>
    </div>
</section>

<!-- Layanan Section -->
<section id="layanan" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h3 class="text-4xl font-bold text-gray-800 mb-4">Layanan Unggulan Kami</h3>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Kami menyediakan berbagai layanan kesehatan komprehensif dengan standar internasional
            </p>
        </div>
        
        @include('partials.services')
    </div>
</section>

<!-- Dokter Section -->
<section id="dokter" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h3 class="text-4xl font-bold text-gray-800 mb-4">Tim Dokter Berpengalaman</h3>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Dokter spesialis terbaik dengan pengalaman puluhan tahun siap melayani Anda
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($doctors->take(6) as $index => $doctor)
                @include('partials.doctor-card', ['doctor' => $doctor, 'index' => $index])
            @endforeach
        </div>
        
        @if($doctors->count() > 6)
            <div class="text-center mt-12">
                <a href="{{ route('doctors') }}" class="btn-primary text-white px-8 py-4 rounded-full font-semibold text-lg shadow-lg hover-lift">
                    Lihat Semua Dokter
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Kontak Section -->
<section id="kontak" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h3 class="text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h3>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Buat janji temu atau konsultasi dengan mudah. Tim kami siap membantu Anda 24/7
            </p>
        </div>
        
        <div class="max-w-4xl mx-auto text-center">
            <a href="{{ route('appointment.create') }}" class="inline-block btn-primary text-white px-12 py-6 rounded-full font-bold text-xl shadow-2xl hover-lift hover-glow">
                🗓️ Daftar Sekarang
            </a>
            
            <div class="mt-12 grid md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-green-50 p-8 rounded-2xl shadow-lg">
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Informasi Kontak</h4>
                    <div class="space-y-3 text-left">
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Jl. Kesehatan Raya No. 123, Jakarta
                        </p>
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            (021) 123-4567
                        </p>
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            info@rssehat.co.id
                        </p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-8 rounded-2xl shadow-lg text-white text-center pulse hover-lift">
                    <svg class="w-16 h-16 mx-auto mb-4 floating-animation" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <h4 class="text-2xl font-bold mb-2">Gawat Darurat</h4>
                    <p class="mb-4">Hubungi segera untuk kondisi darurat</p>
                    <p class="text-4xl font-bold bounce-in">119</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection