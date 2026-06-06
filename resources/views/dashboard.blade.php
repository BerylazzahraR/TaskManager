<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        // 1. Tarik semua workspace milik user (buat nampilin Grid Workspace)
        $userTeams = \App\Models\Team::where('owner_id', Auth::id())
                        ->orWhereHas('users', function($q) {
                            $q->where('users.id', Auth::id());
                        })->get();
        $teamIds = $userTeams->pluck('id');

        // 2. Tarik semua task dari workspace di atas yang DITUGASKAN KE USER INI
        $myTasks = \App\Models\Task::whereIn('team_id', $teamIds)
                        ->where('assigned_to', Auth::id())
                        ->get();

        // 3. Hitung statistik task
        $inProgressCount = $myTasks->where('status', 'in_progress')->count();
        $doneCount = $myTasks->where('status', 'done')->count();
        
        // 4. Tarik 4 task Mendesak (Deadline terdekat & belum selesai)
        $urgentTasks = \App\Models\Task::with('team')
                        ->whereIn('team_id', $teamIds)
                        ->where('assigned_to', Auth::id())
                        ->where('status', '!=', 'done')
                        ->whereNotNull('deadline_at')
                        ->orderBy('deadline_at', 'asc')
                        ->take(4)
                        ->get();
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Notifikasi Sukses Bikin/Hapus Workspace -->
            @if (session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2 shadow-sm transition-colors">
                    <span class="iconify" data-icon="lucide:check-circle" data-width="18"></span> {{ session('success') }}
                </div>
            @endif

            <!-- SECTION 1: WELCOME BANNER & STATISTIC CARDS -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Welcome Banner Card -->
                <div class="lg:col-span-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 sm:p-8 text-white shadow-[0_8px_30px_rgb(0,0,0,0.08)] relative overflow-hidden flex flex-col justify-center">
                    <div class="relative z-10">
                        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
                        <p class="text-indigo-100 text-sm sm:text-base max-w-md">Senang melihatmu kembali. Pantau terus progres kerjamu dan jangan lewatkan deadline tugas kepanitiaanmu.</p>
                    </div>
                    <!-- Dekorasi Background -->
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute right-20 -bottom-10 w-32 h-32 bg-purple-400/20 rounded-full blur-xl"></div>
                    <span class="iconify absolute right-4 bottom-4 text-white/10 w-32 h-32 transform rotate-12" data-icon="lucide:rocket"></span>
                </div>

                <!-- Stat Card: In Progress -->
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-6 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none flex flex-col justify-center transition-colors">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500 dark:text-blue-400">
                            <span class="iconify" data-icon="lucide:loader" data-width="24"></span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">In Progress</p>
                            <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 leading-none">{{ $inProgressCount }} <span class="text-sm font-medium text-slate-500">Tasks</span></h3>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Done -->
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-6 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none flex flex-col justify-center transition-colors">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-500 dark:text-emerald-400">
                            <span class="iconify" data-icon="lucide:check-circle-2" data-width="24"></span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Selesai Dikerjakan</p>
                            <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 leading-none">{{ $doneCount }} <span class="text-sm font-medium text-slate-500">Tasks</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: WORKSPACE GRID & URGENT TASKS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- KOLOM KIRI: Daftar Workspace (Diubah jadi Grid Card) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <span class="iconify text-indigo-500" data-icon="lucide:folders"></span> Project Workspaces
                        </h3>
                        <!-- Tombol Buat Baru tetep aman -->
                        <a href="{{ route('teams.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 px-4 rounded-lg flex items-center gap-2 transition-all shadow-sm">
                            <span class="iconify" data-icon="lucide:plus"></span> Buat Baru
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($userTeams as $team)
                            <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-5 hover:shadow-md transition-all group flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-lg">
                                        {{ strtoupper(substr($team->name, 0, 1)) }}
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $team->status == 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400' }}">
                                        {{ $team->status }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100 text-base mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-1">{{ $team->name }}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 line-clamp-2 h-8">{{ $team->description ?? 'Tidak ada deskripsi untuk workspace ini.' }}</p>
                                
                                <div class="mt-auto flex items-center justify-between border-t border-slate-50 dark:border-slate-700/50 pt-4">
                                    <span class="text-xs font-medium text-slate-400 flex items-center gap-1.5">
                                        <span class="iconify" data-icon="lucide:shield-check" data-width="14"></span> 
                                        {{ $team->owner_id === Auth::id() ? 'Owner' : 'Member' }}
                                    </span>
                                    <a href="{{ route('teams.show', $team->slug) }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center gap-1 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 px-3 py-1.5 rounded-lg transition-colors">
                                        Buka <span class="iconify transform group-hover:translate-x-0.5 transition-transform" data-icon="lucide:arrow-right" data-width="14"></span>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-slate-50 dark:bg-slate-800/50 border border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-8 text-center">
                                <span class="iconify text-slate-400 mx-auto mb-3" data-icon="lucide:folder-open" data-width="32"></span>
                                <p class="text-slate-500 dark:text-slate-400 text-sm">Kamu belum bergabung dengan workspace manapun.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- KOLOM KANAN: Task Mendesak (Task Today) -->
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-5 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base flex items-center gap-2">
                            <span class="iconify text-orange-500" data-icon="lucide:clock-4"></span> Tenggat Waktu Terdekat
                        </h3>
                    </div>

                    <div class="space-y-3">
                        @forelse($urgentTasks as $task)
                            <a href="{{ route('teams.tasks.show', [$task->team_id, $task->id]) }}" class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 border border-transparent hover:border-slate-100 dark:hover:border-slate-600 transition-colors group block">
                                <div class="mt-0.5">
                                    <span class="iconify text-slate-400 group-hover:text-indigo-500 transition-colors" data-icon="lucide:calendar-clock" data-width="18"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200 truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $task->title }}</h4>
                                    <p class="text-[10px] font-medium text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1.5 truncate">
                                        <span class="iconify" data-icon="lucide:folder" data-width="12"></span> {{ $task->team->name }}
                                    </p>
                                </div>
                                <div class="text-right whitespace-nowrap ml-2">
                                    <span class="block text-[10px] font-bold text-orange-600 dark:text-orange-400">{{ \Carbon\Carbon::parse($task->deadline_at)->format('d M') }}</span>
                                    <span class="text-[9px] uppercase font-bold text-slate-400">{{ $task->priority }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-500 mx-auto mb-3">
                                    <span class="iconify" data-icon="lucide:party-popper" data-width="24"></span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Yeay! Tidak ada tugas mendesak untukmu.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>