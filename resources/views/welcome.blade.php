<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Team Task Manager</title>
    
    <!-- Script Iconify dipasang di sini bro -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- MENGHUBUNGKAN STYLE.CSS DARI TEMPLATE LO -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white dark:bg-[#1a1a1a] text-[#37352f] dark:text-gray-200 min-h-screen flex flex-col selection:bg-gray-200 dark:selection:bg-gray-700 transition-colors duration-300">
    
    <!-- NAVIGATION BAR -->
    <nav class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800 transition-colors duration-300">
        <div class="font-bold text-lg tracking-tight flex items-center gap-2 text-[#37352f] dark:text-gray-100">
            <!-- LOGO TIM -->
            <img src="{{ asset('asset/logo1.png') }}" alt="Logo" class="h-8 w-auto">
            <span>Task Manager</span>
        </div>
        
        <div class="flex items-center gap-2">
            <!-- TOMBOL SWITCH DARK MODE -->
            <button @click="darkMode = !darkMode" class="p-2 mr-1 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors focus:outline-none" title="Toggle Tema">
                <span x-show="darkMode" class="iconify" data-icon="lucide:sun" data-width="18" style="display: none;"></span>
                <span x-show="!darkMode" class="iconify" data-icon="lucide:moon" data-width="18"></span>
            </button>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 px-3 py-2 rounded-md transition-colors">
                        Masuk ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 px-3 py-2 rounded-md transition-colors">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-[#37352f] dark:bg-gray-700 text-white hover:bg-[#2f2d27] dark:hover:bg-gray-600 px-3 py-2 rounded-md transition-colors shadow-sm">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- HERO SECTION -->
    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8 mt-10 mb-20">
        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight mb-6 max-w-2xl text-[#37352f] dark:text-gray-100 leading-tight transition-colors duration-300">
            Solusi Manajemen Tugas untuk Tim Kolaboratif
        </h1>
        <p class="text-lg text-gray-500 dark:text-gray-400 mb-10 max-w-xl transition-colors duration-300">
            Lebih terorganisir, lebih produktif. Kelola kepanitiaan, delegasikan tugas, dan pantau progres kolaborasi secara real-time.
        </p>
        
        <div class="flex gap-4">
            <a href="{{ route('register') }}" class="bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white font-medium py-2.5 px-6 rounded-md shadow-sm transition-all flex items-center justify-center gap-2 group">
                Mulai Sekarang 
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
            <a href="{{ route('login') }}" class="bg-white dark:bg-[#242424] border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 text-[#37352f] dark:text-gray-200 font-medium py-2.5 px-6 rounded-md shadow-sm transition-all">
                Login
            </a>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="py-6 text-center text-xs text-gray-400 dark:text-gray-500 border-t border-gray-50 dark:border-gray-800 transition-colors duration-300">
        &copy; {{ date('Y') }} Team Task Manager. Developed by Beryl
    </footer>
</body>
</html>