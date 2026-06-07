<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $userTeams = \App\Models\Team::where('owner_id', Auth::id())
                        ->orWhereHas('users', function($q) {
                            $q->where('users.id', Auth::id());
                        })->get();
        $teamIds = $userTeams->pluck('id');

        $myTasks = \App\Models\Task::whereIn('team_id', $teamIds)
                        ->where('assigned_to', Auth::id())
                        ->get();

        // Hitung Statistik
        $inProgressCount = $myTasks->where('status', 'in_progress')->count();
        $doneCount = $myTasks->where('status', 'done')->count();
        
        // Task Telat (Status bukan done DAN deadline sudah lewat)
        $overdueCount = $myTasks->filter(function($task) {
            return $task->status !== 'done' && $task->deadline_at && \Carbon\Carbon::parse($task->deadline_at)->isPast();
        })->count();

        // 4 Task Mendesak
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
            
            <!-- HEADING RINGKAS -->
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
            </div>

            <!-- STATISTIK CARD (3 Kolom) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- In Progress -->
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                        <span class="iconify" data-icon="lucide:loader" data-width="24"></span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">In Progress</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $inProgressCount }} Tasks</h3>
                    </div>
                </div>

                <!-- Selesai -->
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                        <span class="iconify" data-icon="lucide:check-circle-2" data-width="24"></span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Done</p>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $doneCount }} Tasks</h3>
                    </div>
                </div>

                <!-- Task Telat -->
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-500">
                        <span class="iconify" data-icon="lucide:alert-triangle" data-width="24"></span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Overdue Task</p>
                        <h3 class="text-2xl font-bold text-rose-600 dark:text-rose-400">{{ $overdueCount }} Tasks</h3>
                    </div>
                </div>
            </div>

            <!-- SECTION WORKSPACE & URGENT TASKS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- KOLOM KIRI: Daftar Workspace -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <span class="iconify text-indigo-500" data-icon="lucide:folders"></span> Project Workspaces
                        </h3>
                        <a href="{{ route('teams.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 px-4 rounded-lg flex items-center gap-2 transition-all shadow-sm">
                            <span class="iconify" data-icon="lucide:plus"></span> Buat Baru
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($userTeams as $team)
                            <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-5 hover:shadow-md transition-all flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-lg">
                                        {{ strtoupper(substr($team->name, 0, 1)) }}
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                        {{ $team->status }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-1 line-clamp-1">{{ $team->name }}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 line-clamp-2 h-8">{{ $team->description ?? 'Tidak ada deskripsi.' }}</p>
                                
                                <a href="{{ route('teams.show', $team->slug) }}" class="mt-auto w-full text-center text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 py-2.5 rounded-lg transition-colors">
                                    Buka Workspace
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full py-8 text-center text-slate-400 italic">Belum ada workspace.</div>
                        @endforelse
                    </div>
                </div>

                <!-- KOLOM KANAN: Task Terdekat -->
                <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-5 shadow-sm">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base mb-5 flex items-center gap-2">
                        <span class="iconify text-orange-500" data-icon="lucide:clock-4"></span> Tenggat Terdekat
                    </h3>

                    <div class="space-y-3">
                        @forelse($urgentTasks as $task)
                            <a href="{{ route('teams.tasks.show', [$task->team_id, $task->id]) }}" class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                                <span class="iconify text-slate-400 group-hover:text-indigo-500 mt-0.5" data-icon="lucide:calendar-clock" data-width="18"></span>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200 truncate">{{ $task->title }}</h4>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ $task->team->name }}</p>
                                </div>
                                <span class="text-[10px] font-bold text-orange-600 dark:text-orange-400">{{ \Carbon\Carbon::parse($task->deadline_at)->format('d M') }}</span>
                            </a>
                        @empty
                            <p class="text-center text-xs text-slate-500 py-4">Semua aman!</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>