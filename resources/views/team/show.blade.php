<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-slate-800 dark:text-slate-200 transition-colors">{{ $team->name }}</span>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showActivityModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2 shadow-sm transition-colors">
                    <span class="iconify" data-icon="lucide:check-circle" data-width="18"></span> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-600 dark:text-rose-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2 shadow-sm transition-colors">
                    <span class="iconify" data-icon="lucide:alert-circle" data-width="18"></span> {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    
                    @php
                        $teamTasks = \App\Models\Task::where('team_id', $team->id)->get();
                        $todoWorkspace = $teamTasks->where('status', 'todo')->count();
                        $progressWorkspace = $teamTasks->where('status', 'in_progress')->count();
                        $doneWorkspace = $teamTasks->where('status', 'done')->count();
                        $totalWorkspace = $teamTasks->count();
                    @endphp

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-4 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none flex items-center gap-3 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400">
                                <span class="iconify" data-icon="lucide:target" data-width="20"></span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Task</p>
                                <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 leading-none mt-0.5">{{ $totalWorkspace }}</h4>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-4 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none flex items-center gap-3 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400">
                                <span class="iconify" data-icon="lucide:list-todo" data-width="20"></span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Todo</p>
                                <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 leading-none mt-0.5">{{ $todoWorkspace }}</h4>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-4 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none flex items-center gap-3 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-500 dark:text-indigo-400">
                                <span class="iconify" data-icon="lucide:loader" data-width="20"></span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Proses</p>
                                <h4 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 leading-none mt-0.5">{{ $progressWorkspace }}</h4>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-4 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none flex items-center gap-3 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-500 dark:text-emerald-400">
                                <span class="iconify" data-icon="lucide:check-circle-2" data-width="20"></span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Selesai</p>
                                <h4 class="text-xl font-bold text-emerald-600 dark:text-emerald-400 leading-none mt-0.5">{{ $doneWorkspace }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none rounded-2xl p-6 sm:p-8 transition-colors duration-300">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b border-slate-100 dark:border-slate-700/50 pb-5 mb-6 gap-4 transition-colors">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2 transition-colors">
                                <span class="iconify text-indigo-500 dark:text-indigo-400" data-icon="lucide:list-todo"></span>
                                Daftar Task Workspace
                            </h3>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('teams.tasks.board', $team->slug) }}" class="bg-white dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold py-2 px-4 rounded-lg flex items-center gap-2 shadow-sm transition-all">
                                    <span class="iconify" data-icon="lucide:kanban-square" data-width="16"></span> Kanban Board
                                </a>
                                @if($team->status === 'active')
                                    <a href="{{ route('teams.tasks.create', $team->slug) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded-lg flex items-center gap-2 shadow-sm transition-all">
                                        <span class="iconify" data-icon="lucide:plus" data-width="16"></span> Buat Task
                                    </a>
                                @endif
                            </div>
                        </div>

                        <form method="GET" action="{{ route('teams.show', $team->slug) }}" class="mb-6 bg-slate-50 dark:bg-slate-900/50 p-5 rounded-xl border border-slate-100 dark:border-slate-700/50 transition-colors">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Pencarian</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari task..." class="text-sm rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 w-full focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Status</label>
                                    <select name="status" class="text-sm rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 w-full focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors">
                                        <option value="">Semua Status</option>
                                        <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>TODO</option>
                                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>DONE</option>
                                    </select>
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Assignee</label>
                                    <select name="assigned_to" class="text-sm rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 w-full focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors">
                                        <option value="">Semua Anggota</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ request('assigned_to') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-1 flex gap-2 h-[38px]">
                                    <button type="submit" class="bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white text-xs font-bold px-4 rounded-lg w-full transition-colors shadow-sm">Cari</button>
                                    @if(request()->hasAny(['search', 'status', 'assigned_to']) && (request('search') || request('status') || request('assigned_to')))
                                        <a href="{{ route('teams.show', $team->slug) }}" class="bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-500/20 text-xs font-bold px-3 rounded-lg flex items-center justify-center transition-colors shadow-sm" title="Reset Filter">X</a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        @if($tasks->isEmpty())
                            <div class="text-center py-12 bg-slate-50 dark:bg-slate-900/30 border border-dashed border-slate-200 dark:border-slate-700 rounded-xl transition-colors">
                                <span class="iconify text-slate-300 dark:text-slate-600 mx-auto mb-3" data-icon="lucide:inbox" data-width="40"></span>
                                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Tidak ada data yang tersedia.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700/50 transition-colors">
                                <table class="w-full text-left border-collapse whitespace-nowrap">
                                    <thead class="bg-slate-50 dark:bg-slate-900/50 transition-colors">
                                        <tr class="border-b border-slate-100 dark:border-slate-700/50 text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                            <th class="py-3 px-4 font-bold">Kode</th>
                                            <th class="py-3 px-4 font-bold">Judul Task</th>
                                            <th class="py-3 px-4 font-bold text-center">Prioritas</th>
                                            <th class="py-3 px-4 font-bold">Assignee</th>
                                            <th class="py-3 px-4 font-bold text-center">Status</th>
                                            <th class="py-3 px-4 font-bold text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50 text-sm transition-colors">
                                        @foreach($tasks as $task)
                                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/80 transition-colors group">
                                                <td class="py-3 px-4">
                                                    <span class="text-[10px] font-mono bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 shadow-sm text-slate-600 dark:text-slate-300 px-2 py-1 rounded-md">{{ $task->code }}</span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="flex flex-col">
                                                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $task->title }}</span>
                                                        @if($task->deadline_at)
                                                            <span class="text-[10px] flex items-center gap-1 mt-1 {{ \Carbon\Carbon::parse($task->deadline_at)->isPast() && $task->status !== 'done' ? 'text-rose-500 font-bold' : 'text-slate-400' }}">
                                                                <span class="iconify" data-icon="lucide:calendar-clock" data-width="12"></span>
                                                                {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M Y') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <span class="px-2.5 py-1 rounded-md text-[9px] font-bold uppercase tracking-wider
                                                        {{ $task->priority === 'high' ? 'bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400' : ($task->priority === 'medium' ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400') }}">
                                                        {{ $task->priority }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-6 h-6 rounded-full bg-indigo-50 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-[10px]">
                                                            {{ $task->assignee ? substr($task->assignee->name, 0, 1) : '?' }}
                                                        </div>
                                                        <span class="text-xs font-medium text-slate-600 dark:text-slate-300">
                                                            {{ $task->assignee->name ?? 'Unassigned' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <form action="{{ route('teams.tasks.update', [$team->id, $task->id]) }}" method="POST" class="inline m-0">
                                                        @csrf @method('PUT')
                                                        <select name="status" onchange="this.form.submit()" class="text-[10px] py-1.5 px-2 border-slate-200 dark:border-slate-600 dark:bg-slate-700 rounded-lg font-bold focus:ring-indigo-500 shadow-sm transition-colors
                                                            {{ $task->status === 'done' ? 'text-emerald-600 dark:text-emerald-400' : ($task->status === 'in_progress' ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300') }}">
                                                            <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>TODO</option>
                                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>DONE</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td class="py-3 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <a href="{{ route('teams.tasks.show', [$team->id, $task->id]) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-md transition-colors" title="Lihat Detail">
                                                            <span class="iconify" data-icon="lucide:eye" data-width="18"></span>
                                                        </a>
                                                        <a href="{{ route('teams.tasks.edit', [$team->id, $task->id]) }}" class="p-1.5 text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 rounded-md transition-colors" title="Edit Tugas">
                                                            <span class="iconify" data-icon="lucide:edit-3" data-width="18"></span>
                                                        </a>
                                                        
                                                        <div x-data="{ showDeleteTask: false }" class="flex items-center">
                                                            <button type="button" @click="showDeleteTask = true" class="p-1.5 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-md transition-colors" title="Hapus Tugas">
                                                                <span class="iconify" data-icon="lucide:trash-2" data-width="18"></span>
                                                            </button>

                                                            <div x-show="showDeleteTask" class="fixed inset-0 z-[70] overflow-y-auto" style="display: none;">
                                                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                                                    <div x-show="showDeleteTask" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" @click="showDeleteTask = false"></div>
                                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                                    <div x-show="showDeleteTask" x-transition.duration.300ms class="inline-block w-full max-w-sm p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-xl rounded-2xl relative z-10 whitespace-normal">
                                                                        <div class="flex items-center gap-4 mb-4">
                                                                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600 dark:text-rose-400">
                                                                                <span class="iconify" data-icon="lucide:trash-2" data-width="24"></span>
                                                                            </div>
                                                                            <div>
                                                                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Hapus Task</h3>
                                                                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 text-left">Yakin mau hapus task <strong>{{ $task->title }}</strong> secara permanen?</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-6 flex justify-end gap-3">
                                                                            <button type="button" @click="showDeleteTask = false" class="bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-bold py-2 px-4 rounded-lg transition-colors">Batal</button>
                                                                            <form action="{{ route('teams.tasks.destroy', [$team->id, $task->id]) }}" method="POST" class="m-0">
                                                                                @csrf @method('DELETE')
                                                                                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition-colors shadow-sm">Ya, Hapus</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6 lg:col-span-1">
                    
                    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none rounded-2xl p-6 sm:p-8 transition-colors duration-300 relative overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 dark:bg-indigo-500/5 rounded-full blur-xl pointer-events-none"></div>

                        <div class="flex justify-between items-center mb-5 border-b border-slate-100 dark:border-slate-700/50 pb-4 transition-colors relative z-10">
                            <h3 class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider flex items-center gap-2">
                                <span class="iconify" data-icon="lucide:info"></span> Detail Workspace
                            </h3>
                            <button @click="showActivityModal = true" class="text-indigo-500 hover:bg-indigo-50 dark:hover:bg-slate-700 p-2 rounded-lg transition-colors" title="Lihat Riwayat Aktivitas">
                                <span class="iconify" data-icon="lucide:clock-4" data-width="18"></span>
                            </button>
                        </div>

                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2 leading-tight transition-colors relative z-10">{{ $team->name }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 transition-colors relative z-10">{{ $team->description ?? 'Tidak ada deskripsi.' }}</p>

                        <div class="flex flex-col gap-4 text-sm font-medium mb-6 relative z-10">
                            <div class="flex justify-between items-center bg-slate-50 dark:bg-slate-900/50 p-3 rounded-lg border border-slate-100 dark:border-slate-700/50 transition-colors">
                                <span class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                                    <span class="iconify" data-icon="lucide:eye" data-width="16"></span> Visibilitas
                                </span>
                                <span class="text-slate-800 dark:text-slate-200 transition-colors">{{ ucfirst($team->visibility) }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 dark:bg-slate-900/50 p-3 rounded-lg border border-slate-100 dark:border-slate-700/50 transition-colors">
                                <span class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                                    <span class="iconify" data-icon="lucide:activity" data-width="16"></span> Status
                                </span>
                                <span class="font-bold {{ $team->status == 'active' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} transition-colors">
                                    {{ ucfirst($team->status) }}
                                </span>
                            </div>
                        </div>

                        @if($team->owner_id == Auth::id())
                            <div x-data="{ showDeleteWorkspace: false }" class="relative z-10">
                                <div class="grid grid-cols-2 gap-3 pt-2">
                                    <a href="{{ route('teams.edit', $team->slug) }}" class="bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 text-xs font-bold py-2.5 px-3 rounded-xl flex items-center justify-center gap-2 transition-colors shadow-sm">
                                        <span class="iconify" data-icon="lucide:settings-2" data-width="16"></span> Edit
                                    </a>
                                    <button @click="showDeleteWorkspace = true" type="button" class="bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 border border-rose-100 dark:border-rose-500/20 text-rose-600 dark:text-rose-400 text-xs font-bold py-2.5 px-3 rounded-xl flex items-center justify-center gap-2 transition-colors shadow-sm">
                                        <span class="iconify" data-icon="lucide:trash-2" data-width="16"></span> Hapus
                                    </button>
                                </div>

                                <div x-show="showDeleteWorkspace" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                        <div x-show="showDeleteWorkspace" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" @click="showDeleteWorkspace = false"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div x-show="showDeleteWorkspace" x-transition.duration.300ms class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-xl rounded-2xl relative z-10">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600 dark:text-rose-400">
                                                    <span class="iconify" data-icon="lucide:alert-triangle" data-width="24"></span>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Hapus Workspace</h3>
                                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Yakin mau hapus workspace <strong>{{ $team->name }}</strong>? Semua data di dalamnya akan hilang permanen.</p>
                                                </div>
                                            </div>
                                            <div class="mt-6 flex justify-end gap-3">
                                                <button type="button" @click="showDeleteWorkspace = false" class="bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-bold py-2 px-4 rounded-lg transition-colors">Batal</button>
                                                <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="m-0">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition-colors shadow-sm">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none sm:rounded-2xl transition-colors duration-300" x-data="{ openMembers: true }">
                        <div @click="openMembers = !openMembers" class="p-6 flex justify-between items-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors rounded-t-2xl">
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2 transition-colors">
                                <span class="iconify text-indigo-500" data-icon="lucide:users"></span>
                                Anggota Tim ({{ $members->count() }})
                            </h3>
                            <span class="iconify text-slate-400 transition-transform duration-300" :class="openMembers ? 'rotate-180' : ''" data-icon="lucide:chevron-down" data-width="20"></span>
                        </div>

                        <div x-show="openMembers" x-transition class="px-6 pb-6 pt-2" style="display: none;">
                            @if($team->owner_id == Auth::id())
                                <form action="{{ route('teams.members.store', $team->id) }}" method="POST" class="mb-5 flex flex-col gap-3">
                                    @csrf
                                    <div class="relative">
                                        <span class="iconify absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" data-icon="lucide:mail"></span>
                                        <input type="email" name="email" placeholder="Masukkan email user..." required class="pl-10 text-sm rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 w-full focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <button type="submit" class="bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white text-sm font-bold py-2.5 px-4 rounded-lg w-full shadow-sm transition-colors flex items-center justify-center gap-2">
                                        <span class="iconify" data-icon="lucide:user-plus"></span> Undang
                                    </button>
                                </form>
                            @endif

                            <ul class="divide-y divide-slate-100 dark:divide-slate-700/50 transition-colors">
                                @foreach($members as $member)
                                    <li class="py-3.5 flex justify-between items-center group">
                                        <div class="flex items-center gap-3 max-w-[60%]">
                                            <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs flex-shrink-0">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                            <div class="truncate">
                                                <span class="font-bold text-sm text-slate-800 dark:text-slate-200 block truncate transition-colors">{{ $member->name }}</span>
                                                <span class="text-[10px] font-medium text-slate-400 block truncate">{{ $member->email }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($team->owner_id == Auth::id() && $member->id != Auth::id())
                                                <form action="{{ route('teams.members.update', [$team->id, $member->id]) }}" method="POST" class="inline">
                                                    @csrf @method('PUT')
                                                    <select name="role" onchange="this.form.submit()" class="text-[10px] py-1 px-2 border-slate-200 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 rounded-md focus:ring-indigo-500 font-semibold shadow-sm">
                                                        <option value="admin" {{ $member->pivot->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="member" {{ $member->pivot->role == 'member' ? 'selected' : '' }}>Member</option>
                                                    </select>
                                                </form>
                                                
                                                <div x-data="{ showRemoveMember: false }" class="inline flex items-center">
                                                    <button type="button" @click="showRemoveMember = true" class="text-slate-400 hover:text-rose-500 p-1.5 rounded hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Keluarkan">
                                                        <span class="iconify" data-icon="lucide:user-minus" data-width="16"></span>
                                                    </button>

                                                    <div x-show="showRemoveMember" class="fixed inset-0 z-[70] overflow-y-auto" style="display: none;">
                                                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                                            <div x-show="showRemoveMember" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" @click="showRemoveMember = false"></div>
                                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                            <div x-show="showRemoveMember" x-transition.duration.300ms class="inline-block w-full max-w-sm p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-xl rounded-2xl relative z-10">
                                                                <div class="flex items-center gap-4 mb-4">
                                                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600 dark:text-rose-400">
                                                                        <span class="iconify" data-icon="lucide:user-x" data-width="24"></span>
                                                                    </div>
                                                                    <div>
                                                                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Keluarkan Anggota</h3>
                                                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Yakin mengeluarkan <strong>{{ $member->name }}</strong> dari tim?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-6 flex justify-end gap-3">
                                                                    <button type="button" @click="showRemoveMember = false" class="bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-bold py-2 px-4 rounded-lg transition-colors">Batal</button>
                                                                    <form action="{{ route('teams.members.destroy', [$team->id, $member->id]) }}" method="POST" class="m-0">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition-colors shadow-sm">Ya, Keluarkan</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 text-[10px] px-2.5 py-1 rounded-md font-bold uppercase">{{ $member->pivot->role }}</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showActivityModal" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showActivityModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" @click="showActivityModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showActivityModal" x-transition.duration.300ms class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-xl rounded-2xl relative z-10">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-700/50 pb-4 mb-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                            <span class="iconify text-indigo-500" data-icon="lucide:history"></span> Riwayat Aktivitas
                        </h3>
                        <button @click="showActivityModal = false" class="text-slate-400 hover:text-rose-500 bg-slate-50 hover:bg-rose-50 dark:bg-slate-700 dark:hover:bg-rose-500/20 p-1.5 rounded-lg transition-colors">
                            <span class="iconify" data-icon="lucide:x" data-width="20"></span>
                        </button>
                    </div>

                    <div class="max-h-[60vh] overflow-y-auto pr-2">
                        @if($activities->isEmpty())
                            <div class="text-center py-8">
                                <span class="iconify text-slate-300 dark:text-slate-600 mx-auto mb-3" data-icon="lucide:clock" data-width="32"></span>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada riwayat aktivitas.</p>
                            </div>
                        @else
                            <div class="relative border-l-2 border-slate-100 dark:border-slate-700 ml-4 mt-2">
                                @foreach($activities as $activity)
                                    <div class="mb-8 ml-6 group">
                                        <span class="absolute flex items-center justify-center w-5 h-5 bg-indigo-100 dark:bg-indigo-500/20 rounded-full -left-[11px] ring-4 ring-white dark:ring-slate-800 text-indigo-500">
                                            <div class="w-2 h-2 bg-indigo-500 rounded-full group-hover:scale-125 transition-transform"></div>
                                        </span>
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1.5">
                                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $activity->actor->name ?? 'Sistem' }}</h4>
                                            <time class="text-[10px] font-bold text-slate-400 dark:text-slate-500 sm:ml-3 bg-slate-50 dark:bg-slate-900/50 px-2 py-1 rounded-md">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</time>
                                        </div>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $activity->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>