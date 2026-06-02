<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Team Task Manager</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- MENGHUBUNGKAN STYLE.CSS DARI TEMPLATE LO -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-[#37352f] min-h-screen flex flex-col selection:bg-gray-200">
    
    <nav class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
        <div class="font-bold text-lg tracking-tight flex items-center gap-2">
            <!-- MENGGANTI SVG DENGAN LOGO DARI TEMPLATE LO -->
            <img src="{{ asset('asset/logo1.png') }}" alt="Logo" class="h-8 w-auto">
            <span>Task Manager</span>
        </div>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:bg-gray-100 px-3 py-2 rounded-md transition-colors">Masuk ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:bg-gray-100 px-3 py-2 rounded-md transition-colors">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-[#37352f] text-white hover:bg-[#2f2d27] px-3 py-2 rounded-md transition-colors ml-2 shadow-sm">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8 mt-10 mb-20">
        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight mb-6 max-w-2xl text-[#37352f] leading-tight">
            Solusi Manajemen Tugas untuk Tim Kolaboratif
        </h1>
        <p class="text-lg text-gray-500 mb-10 max-w-xl">
            Lebih terorganisir, lebih produktif. Kelola kepanitiaan, delegasikan tugas, dan pantau progres kolaborasi secara real-time 
        </p>
        <div class="flex gap-4">
            <a href="{{ route('register') }}" class="bg-[#37352f] hover:bg-[#2f2d27] text-white font-medium py-2.5 px-6 rounded-md shadow-sm transition-all flex items-center justify-center gap-2 group">
                Mulai Sekarang 
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
            <a href="{{ route('login') }}" class="bg-white border border-gray-200 hover:bg-gray-50 text-[#37352f] font-medium py-2.5 px-6 rounded-md shadow-sm transition-all">
                Login
            </a>
        </div>
    </main>

    <footer class="py-6 text-center text-xs text-gray-400 border-t border-gray-50">
        &copy; {{ date('Y') }} Team Task Manager. Developed by Beryl 
    </footer>
</body>
</html>