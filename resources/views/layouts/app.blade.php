<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          sidebarOpen: window.innerWidth >= 1024 
      }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      x-bind:class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Task Manager') }}</title>
        
        <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
            .dark ::-webkit-scrollbar-thumb { background: #475569; }
        </style>
    </head>
    
    <body class="font-sans antialiased text-slate-800 dark:text-slate-200 transition-colors duration-300">
        
        <div class="flex h-screen overflow-hidden bg-[#f4f7fe] dark:bg-slate-900 transition-colors duration-300">
            
            @include('layouts.navigation')

            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <header class="sticky top-0 z-30 bg-[#f4f7fe]/90 dark:bg-slate-900/90 backdrop-blur-md transition-colors duration-300">
                    <div class="flex items-center justify-between px-6 py-4">
                        
                        <div class="flex items-center mr-4" x-show="!sidebarOpen" style="display: none;">
                            <button @click="sidebarOpen = true" class="p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-slate-200/50 dark:text-slate-400 dark:hover:text-indigo-400 dark:hover:bg-slate-800 focus:outline-none transition-all" title="Buka Sidebar">
                                <span class="iconify" data-icon="lucide:panel-left" data-width="24"></span>
                            </button>
                        </div>

                        <div class="hidden sm:block transition-all" :class="!sidebarOpen ? 'ml-0' : ''">
                            @isset($header)
                                {{ $header }}
                            @endisset
                        </div>

                        <div class="flex items-center gap-4 ml-auto">
                            <button @click="darkMode = !darkMode" class="p-2.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 bg-white dark:bg-slate-800 rounded-full shadow-sm transition-all focus:outline-none border border-transparent dark:border-slate-700">
                                <span x-show="darkMode" class="iconify" data-icon="lucide:sun" data-width="18" style="display: none;"></span>
                                <span x-show="!darkMode" class="iconify" data-icon="lucide:moon" data-width="18"></span>
                            </button>

                            @php
                                $unreadNotifications = \App\Models\Notification::where('user_id', Auth::id())
                                    ->whereNull('read_at')
                                    ->latest()
                                    ->take(5)
                                    ->get();
                                    
                                $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                                    ->whereNull('read_at')
                                    ->count();
                            @endphp

                            <div class="relative flex items-center" x-data="{ openNotif: false }" @click.outside="openNotif = false">
                                
                                <button @click="openNotif = !openNotif" class="relative p-2.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 bg-white dark:bg-slate-800 rounded-full shadow-sm transition-all focus:outline-none border border-transparent dark:border-slate-700">
                                    <span class="iconify" data-icon="lucide:bell" data-width="18"></span>
                                    
                                    @if($unreadCount > 0)
                                        <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white dark:ring-slate-800 border border-white dark:border-slate-800"></span>
                                    @endif
                                </button>

                                <div x-show="openNotif" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                     class="absolute right-0 top-12 mt-2 w-80 sm:w-96 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700/50 z-[100] overflow-hidden"
                                     style="display: none;">
                                     
                                     <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700/50 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/20">
                                         <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Notifikasi</h3>
                                         @if($unreadCount > 0)
                                             <span class="bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold px-2.5 py-1 rounded-md">{{ $unreadCount }} Baru</span>
                                         @endif
                                     </div>

                                     <div class="max-h-[350px] overflow-y-auto">
                                         @forelse($unreadNotifications as $notif)
                                             <div class="px-5 py-4 border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors flex items-start gap-4 group relative">
                                                 <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5">
                                                     <span class="iconify" data-icon="lucide:clipboard-list" data-width="16"></span>
                                                 </div>
                                                 
                                                 <div class="flex-1 min-w-0 pr-8">
                                                     <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                                         {{ $notif->message }}
                                                     </p>
                                                     <p class="text-[10px] font-bold text-slate-400 mt-1.5 flex items-center gap-1">
                                                         <span class="iconify" data-icon="lucide:clock" data-width="10"></span>
                                                         {{ $notif->created_at->diffForHumans() }}
                                                     </p>
                                                 </div>
                                                 
                                                 <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity absolute right-4 top-1/2 -translate-y-1/2">
                                                     @csrf @method('PATCH')
                                                     <button type="submit" class="bg-white dark:bg-slate-700 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 text-slate-400 hover:text-emerald-500 p-2 rounded-xl border border-slate-200 dark:border-slate-600 shadow-sm transition-colors" title="Tandai sudah dibaca">
                                                         <span class="iconify" data-icon="lucide:check" data-width="14"></span>
                                                     </button>
                                                 </form>
                                             </div>
                                         @empty
                                             <div class="px-4 py-10 text-center">
                                                 <div class="w-12 h-12 rounded-full bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center text-slate-400 mx-auto mb-3">
                                                     <span class="iconify" data-icon="lucide:bell-off" data-width="24"></span>
                                                 </div>
                                                 <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Belum ada notifikasi baru.</p>
                                             </div>
                                         @endforelse
                                     </div>
                                </div>
                            </div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center gap-2 p-1.5 bg-white dark:bg-slate-800 rounded-full shadow-sm border border-slate-100 dark:border-slate-700 transition-all focus:outline-none hover:ring-2 hover:ring-indigo-100 dark:hover:ring-indigo-900/30">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div class="hidden md:block text-sm font-semibold text-left ml-1 mr-2">
                                            <span class="block text-slate-700 dark:text-slate-200">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                        </div>
                                        <span class="iconify text-slate-400 mr-2" data-icon="lucide:chevron-down" data-width="16"></span>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        <div class="flex items-center gap-2"><span class="iconify" data-icon="lucide:user" data-width="16"></span> {{ __('Profile') }}</div>
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <div class="flex items-center gap-2 text-red-500 dark:text-red-400"><span class="iconify" data-icon="lucide:log-out" data-width="16"></span> {{ __('Log Out') }}</div>
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <main class="w-full grow p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>

            </div>
        </div>
        
        @if (session('success') || session('error'))
        <div x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-10 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 translate-x-10"
             x-init="setTimeout(() => show = false, 4000)"
             class="fixed bottom-6 right-6 z-[100] flex items-center p-4 min-w-[300px] bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700/50"
             style="display: none;">

            @if(session('success'))
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <span class="iconify" data-icon="lucide:check-circle-2" data-width="24"></span>
                </div>
                <div class="ml-4 mr-6">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">Berhasil!</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600 dark:text-rose-400">
                    <span class="iconify" data-icon="lucide:alert-triangle" data-width="24"></span>
                </div>
                <div class="ml-4 mr-6">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">Oops, Gagal!</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ session('error') }}</p>
                </div>
            @endif

            <button type="button" @click="show = false" class="ml-auto flex-shrink-0 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 bg-slate-50 hover:bg-slate-100 dark:bg-slate-700/50 dark:hover:bg-slate-700 p-1.5 rounded-lg transition-colors">
                <span class="iconify" data-icon="lucide:x" data-width="16"></span>
            </button>
        </div>
        @endif

    </body>
</html>