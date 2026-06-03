<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      x-bind:class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Task Manager') }} - Authentication</title>

        <!-- Script Iconify -->
        <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased transition-colors duration-300">
        
        <!-- Tombol Switch Tema Melayang di Pojok Kanan Atas -->
        <div class="absolute top-4 right-4 sm:top-6 sm:right-8">
            <button @click="darkMode = !darkMode" class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800 rounded-full transition-colors focus:outline-none shadow-sm" title="Toggle Tema">
                <span x-show="darkMode" class="iconify" data-icon="lucide:sun" data-width="20" style="display: none;"></span>
                <span x-show="!darkMode" class="iconify" data-icon="lucide:moon" data-width="20"></span>
            </button>
        </div>

        <!-- Wrapper Utama -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-[#1a1a1a] transition-colors duration-300">
            
            <!-- Logo -->
            <div class="mb-4">
                <a href="/" class="flex flex-col items-center gap-2">
                    <img src="{{ asset('asset/logo1.png') }}" alt="Logo" class="h-14 w-auto">
                    <span class="font-bold text-xl text-[#37352f] dark:text-gray-200">Task Manager</span>
                </a>
            </div>

            <!-- Kotak Form Login/Register -->
            <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white dark:bg-[#242424] shadow-[0_4px_10px_rgba(0,0,0,0.03)] border border-gray-200 dark:border-gray-800 overflow-hidden sm:rounded-xl transition-colors duration-300">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-xs text-gray-400 dark:text-gray-500 text-center">
                &copy; {{ date('Y') }} Team Task Manager.
            </div>
        </div>
    </body>
</html>