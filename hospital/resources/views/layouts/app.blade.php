<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RS Sehat Sejahtera - Pelayanan Kesehatan Terpercaya')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/hospital.css') }}">
    
    @stack('styles')
</head>
<body class="font-sans bg-gray-50">
    
    @include('layouts.header')
    
    @yield('content')
    
    @include('layouts.footer')
    
    <!-- Custom JS -->
    <script src="{{ asset('js/hospital.js') }}"></script>
    
    <!-- Notification System -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
    
    <script>
        // Global notification function
        function showNotification(message, type = 'info') {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500'
            };
            
            notification.className = `notification ${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg max-w-md animate-slideIn`;
            notification.innerHTML = `
                <div class="flex items-start justify-between">
                    <span class="text-sm leading-relaxed pr-2">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200 flex-shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Show Laravel session messages
        @if(session('success'))
            showNotification("{{ session('success') }}", 'success');
        @endif
        
        @if(session('error'))
            showNotification("{{ session('error') }}", 'error');
        @endif
        
        @if(session('info'))
            showNotification("{{ session('info') }}", 'info');
        @endif
        
        @if(session('warning'))
            showNotification("{{ session('warning') }}", 'warning');
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                showNotification("{{ $error }}", 'error');
            @endforeach
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>