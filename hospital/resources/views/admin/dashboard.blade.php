@extends('layouts.app')

@section('title', 'Dashboard Admin - RS Sehat Sejahtera')

@section('content')
<!-- Admin Header -->
<div class="bg-gradient-to-r from-blue-600 to-green-600 text-white p-6">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">Dashboard Administrator</h2>
            <p class="opacity-90">Kelola pendaftaran dan pembayaran pasien</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-sm opacity-75">{{ now()->format('l, d F Y') }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-white bg-opacity-20 px-4 py-2 rounded-lg hover:bg-opacity-30">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Dashboard Stats -->
<div class="container mx-auto px-4 py-8">
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Pendaftaran</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_registrations'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-4h3v4h2v-7.5c0-.83.67-1.5 1.5-1.5S12 9.67 12 10.5V18h2v-4h3v4h2V8.5c0-1.1-.9-2-2-2H7c-1.1 0-2 .9-2 2V18H4z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-yellow-500 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Menunggu Konfirmasi</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_confirmations'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-green-500 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pembayaran Lunas</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['paid_appointments'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-purple-500 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Hari Ini</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['today_appointments'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Navigation Tabs -->
    <div class="bg-white rounded-2xl shadow-lg mb-8">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6">
                <a href="{{ route('admin.appointments') }}" class="py-4 px-2 border-b-2 {{ request()->routeIs('admin.appointments*') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }} font-semibold transition-colors">
                    📋 Pendaftaran Pasien
                </a>
                <a href="{{ route('admin.doctors') }}" class="py-4 px-2 border-b-2 {{ request()->routeIs('admin.doctors*') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }} font-semibold transition-colors">
                    👨‍⚕️ Kelola Dokter
                </a>
                <a href="{{ route('admin.payments') }}" class="py-4 px-2 border-b-2 {{ request()->routeIs('admin.payments*') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }} font-semibold transition-colors">
                    💰 Pembayaran
                </a>
            </nav>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800">Pendaftaran Terbaru</h3>
                <a href="{{ route('admin.appointments') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Lihat Semua
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentAppointments as $appointment)
                    <tr class="table-row hover:bg-blue-50 transition-all">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $appointment->appointment_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $appointment->patient->user->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $appointment->doctor->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $appointment->formatted_date }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                    'pending_payment_verification' => 'bg-purple-100 text-purple-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    'completed' => 'bg-gray-100 text-gray-800',
                                ];
                                
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'confirmed' => 'Dikonfirmasi',
                                    'pending_payment_verification' => 'Verifikasi Bayar',
                                    'paid' => 'Lunas',
                                    'cancelled' => 'Dibatalkan',
                                    'completed' => 'Selesai',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @if($appointment->status === 'pending')
                                    <form action="{{ route('admin.appointments.confirm', $appointment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                            Konfirmasi
                                        </button>
                                    </form>
                                @elseif($appointment->status === 'pending_payment_verification' && $appointment->payment)
                                    <form action="{{ route('admin.payments.verify', $appointment->payment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                                            Verifikasi
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="bg-gray-600 text-white px-3 py-1 rounded text-xs hover:bg-gray-700">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                            </svg>
                            <p class="text-lg font-semibold">Belum Ada Pendaftaran</p>
                            <p class="text-sm">Pendaftaran baru akan muncul di sini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection