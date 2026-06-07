<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) 
      }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager | Kolaborasi Tanpa Batas</title>
    
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 min-h-screen flex flex-col transition-colors duration-300">
    
    <nav class="flex justify-between items-center px-8 py-6 max-w-7xl mx-auto w-full">
        <div class="flex items-center gap-3">
            <img src="{{ asset('asset/logo1.png') }}" alt="Logo" class="h-9 w-auto">
            <span class="text-xl font-bold tracking-tight text-slate-800 dark:text-white">Task Manager</span>
        </div>
        
        <div class="flex items-center gap-3">
            <button @click="darkMode = !darkMode" class="p-2.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 bg-white dark:bg-slate-800 rounded-full shadow-sm transition-all border border-slate-200 dark:border-slate-700">
                <span x-show="darkMode" class="iconify" data-icon="lucide:sun" data-width="18" style="display: none;"></span>
                <span x-show="!darkMode" class="iconify" data-icon="lucide:moon" data-width="18"></span>
            </button>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 px-4 py-2 transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 px-4 py-2 transition-colors">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 mb-20">
        <div class="max-w-2xl">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-6 text-slate-900 dark:text-white leading-[1.1]">
                Kelola Tugas Tim <br> dengan <span class="text-indigo-600">Mudah & Cepat</span>
            </h1>
            <p class="text-lg text-slate-500 dark:text-slate-400 mb-10 leading-relaxed">
                Platform manajemen tugas Sederhana.
            </p>
            
            <div class="flex gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all flex items-center gap-2 group text-sm">
                    Mulai Sekarang
                    <span class="iconify group-hover:translate-x-1 transition-transform" data-icon="lucide:arrow-right" data-width="16"></span>
                </a>
            </div>
        </div>
    </main>

    <footer class="py-8 text-center text-xs font-medium text-slate-400 dark:text-slate-600">
        &copy; {{ date('Y') }} Team Task Manager. Developed by Beryl
    </footer>
</body>
</html>