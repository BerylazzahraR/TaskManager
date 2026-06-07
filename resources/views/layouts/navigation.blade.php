@php
    $userWorkspaces = \App\Models\Team::where('owner_id', Auth::id())
                        ->orWhereHas('users', function($q) {
                            $q->where('users.id', Auth::id());
                        })->get();
@endphp

<div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-transition.opacity style="display: none;"></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:-ml-64'" class="fixed inset-y-0 left-0 z-50 w-64 lg:static flex flex-col bg-white dark:bg-slate-800 border-r border-slate-100 dark:border-slate-700/50 transition-all duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.02)] dark:shadow-none">
    
    <div class="flex items-center justify-between h-20 px-6">
        <div class="flex items-center gap-3">
            <img src="{{ asset('asset/logo1.png') }}" alt="Logo" class="h-8 w-auto">
            <span class="text-xl font-bold text-slate-800 dark:text-white tracking-tight">Task Manager</span>
        </div>
        
        <button @click="sidebarOpen = false" class="hidden lg:block p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:text-slate-300 dark:hover:bg-slate-700/50 transition-all focus:outline-none" title="Tutup Sidebar">
            <span class="iconify" data-icon="lucide:panel-left-close" data-width="20"></span>
        </button>
        
        <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:text-slate-300 dark:hover:bg-slate-700/50 transition-all focus:outline-none">
            <span class="iconify" data-icon="lucide:x" data-width="20"></span>
        </button>
    </div>

    <div class="flex flex-col flex-1 overflow-y-auto py-4 px-4 space-y-1">
        
        <p class="px-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 mt-2">Overview</p>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all relative group {{ request()->routeIs('dashboard') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-700 dark:hover:text-slate-200' }}">
            @if(request()->routeIs('dashboard'))
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-indigo-600 dark:bg-indigo-400 rounded-r-full"></span>
            @endif
            <span class="iconify" data-icon="lucide:layout-dashboard" data-width="20"></span>
            Dashboard
        </a>

        <p class="px-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 mt-6">Manajemen</p>

        <div x-data="{ openWorkspace: {{ request()->routeIs('teams.*') ? 'true' : 'false' }} }">
            <button @click="openWorkspace = !openWorkspace" class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-medium transition-all relative group {{ request()->routeIs('teams.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-700 dark:hover:text-slate-200' }}">
                <div class="flex items-center gap-3">
                    @if(request()->routeIs('teams.*'))
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-indigo-600 dark:bg-indigo-400 rounded-r-full"></span>
                    @endif
                    <span class="iconify" data-icon="lucide:folder-kanban" data-width="20"></span>
                    Workspaces
                </div>
                <span class="iconify transition-transform duration-300" :class="openWorkspace ? 'rotate-180' : ''" data-icon="lucide:chevron-down" data-width="16"></span>
            </button>

            <div x-show="openWorkspace" x-transition class="mt-1 space-y-1 pl-11 pr-2">
                @forelse($userWorkspaces as $ws)
                    <a href="{{ route('teams.show', $ws->slug) }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('teams/'.$ws->slug.'*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-500/10' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/30' }}">
                        {{ $ws->name }}
                    </a>
                @empty
                    <span class="block px-3 py-2 text-xs text-slate-400 italic">Belum ada workspace</span>
                @endforelse
                
                <a href="{{ route('teams.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-bold text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-400 transition-colors mt-2 bg-indigo-50/50 hover:bg-indigo-100 dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40">
                    <span class="iconify" data-icon="lucide:plus" data-width="14"></span> Buat Baru
                </a>
            </div>
        </div>

    </div>

    <div class="p-4 mt-auto border-t border-slate-100 dark:border-slate-700/50">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-700 dark:hover:text-slate-200 transition-all">
            <span class="iconify" data-icon="lucide:settings" data-width="20"></span>
            Settings
        </a>
        <div class="mt-4 bg-indigo-50/50 dark:bg-indigo-900/20 p-4 rounded-xl text-center border border-indigo-100/50 dark:border-indigo-800/30 relative overflow-hidden">
            <span class="iconify text-indigo-500 dark:text-indigo-400 mx-auto mb-2" data-icon="lucide:life-buoy" data-width="24"></span>
            <p class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Help & Support</p>
            <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1">Kontak Admin Beryl</p>
            <div class="absolute -right-4 -bottom-4 w-12 h-12 bg-indigo-500/10 rounded-full blur-md"></div>
        </div>
    </div>
</aside>