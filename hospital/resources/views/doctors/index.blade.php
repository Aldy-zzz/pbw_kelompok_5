@extends('layouts.app')

@section('title', 'Daftar Dokter - RS Sehat Sejahtera')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 py-12 px-4">
    <div class="container mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">👨‍⚕️ Tim Dokter Kami</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Dokter spesialis berpengalaman siap melayani kesehatan Anda dengan profesional
            </p>
        </div>
        
        @if($doctors->isEmpty())
            <div class="text-center py-12">
                <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">Belum Ada Dokter</h3>
                <p class="text-gray-500">Dokter akan ditampilkan di sini</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($doctors as $index => $doctor)
                    @include('partials.doctor-card', ['doctor' => $doctor, 'index' => $index])
                @endforeach
            </div>
        @endif
        
        <div class="text-center mt-12">
            <a href="{{ route('appointment.create') }}" class="inline-block bg-blue-600 text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-blue-700 transition-all shadow-lg">
                📅 Buat Janji Temu
            </a>
        </div>
    </div>
</div>
@endsection