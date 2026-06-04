<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f] dark:text-gray-200 transition-colors">{{ $team->name }}</span>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showActivityModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-700 dark:text-green-400 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm transition-colors">
                    <span class="iconify" data-icon="lucide:check-circle"></span> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-700 dark:text-red-400 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm transition-colors">
                    <span class="iconify" data-icon="lucide:alert-circle"></span> {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-[#242424] border border-gray-200 dark:border-gray-700 shadow-[0_1px_3px_rgba(0,0,0,0.02)] sm:rounded-lg p-6 transition-colors duration-300">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-5 gap-4 transition-colors">
                            <h3 class="text-lg font-bold text-[#37352f] dark:text-gray-100 flex items-center gap-2 transition-colors">
                                <span class="iconify text-gray-500 dark:text-gray-400" data-icon="lucide:list-todo"></span>
                                Daftar Task Workspace
                            </h3>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('teams.tasks.board', $team->slug) }}" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-[#37352f] dark:text-gray-200 text-xs font-bold py-2 px-3 rounded flex items-center gap-1 shadow-sm transition-all">
                                    <span class="iconify" data-icon="lucide:kanban-square"></span> Kanban Board
                                </a>
                                @if($team->status === 'active')
                                    <a href="{{ route('teams.tasks.create', $team->slug) }}" class="bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white text-xs font-bold py-2 px-3 rounded flex items-center gap-1 shadow-sm transition-all">
                                        <span class="iconify" data-icon="lucide:plus"></span> Buat Task
                                    </a>
                                @endif
                            </div>
                        </div>

                        <form method="GET" action="{{ route('teams.show', $team->slug) }}" class="mb-6 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Pencarian</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari task..." class="text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 w-full focus:ring-[#0056b3]">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Status</label>
                                    <select name="status" class="text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 w-full focus:ring-[#0056b3]">
                                        <option value="">Semua</option>
                                        <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>TODO</option>
                                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>DONE</option>
                                    </select>
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Assignee</label>
                                    <select name="assigned_to" class="text-xs rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 w-full focus:ring-[#0056b3]">
                                        <option value="">Semua</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ request('assigned_to') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-1 flex gap-2 h-[34px]">
                                    <button type="submit" class="bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white text-xs font-bold px-4 rounded-md w-full transition-colors shadow-sm">Cari</button>
                                    @if(request()->hasAny(['search', 'status', 'assigned_to']) && (request('search') || request('status') || request('assigned_to')))
                                        <a href="{{ route('teams.show', $team->slug) }}" class="bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-800/50 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50 text-xs font-bold px-3 rounded-md flex items-center justify-center transition-colors shadow-sm">X</a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        @if($tasks->isEmpty())
                            <div class="text-center py-10 border border-dashed border-gray-200 dark:border-gray-700 rounded-lg transition-colors">
                                <span class="iconify text-gray-300 dark:text-gray-600 mx-auto mb-2" data-icon="lucide:inbox" data-width="32"></span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada data yang tersedia.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-gray-700 transition-colors">
                                <table class="w-full text-left border-collapse whitespace-nowrap">
                                    <thead class="bg-gray-50/80 dark:bg-gray-800/80 transition-colors">
                                        <tr class="border-b border-gray-100 dark:border-gray-700 text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            <th class="py-3 px-4 font-bold">Kode</th>
                                            <th class="py-3 px-4 font-bold">Judul Task</th>
                                            <th class="py-3 px-4 font-bold text-center">Prioritas</th>
                                            <th class="py-3 px-4 font-bold">Assignee</th>
                                            <th class="py-3 px-4 font-bold">Deadline</th>
                                            <th class="py-3 px-4 font-bold text-center">Status</th>
                                            <th class="py-3 px-4 font-bold text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50 text-sm transition-colors">
                                        @foreach($tasks as $task)
                                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors group">
                                                <td class="py-3 px-4">
                                                    <span class="text-[10px] font-mono bg-white dark:bg-[#1a1a1a] border border-gray-200 dark:border-gray-700 shadow-sm text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded">{{ $task->code }}</span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="font-bold text-[#37352f] dark:text-gray-200">{{ $task->title }}</span>
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                                        {{ $task->priority === 'high' ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50' : ($task->priority === 'medium' ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 border border-yellow-100 dark:border-yellow-800/50' : 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 border border-green-100 dark:border-green-800/50') }}">
                                                        {{ $task->priority }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="text-xs text-gray-600 dark:text-gray-300 flex items-center gap-1.5">
                                                        <span class="iconify text-gray-400 dark:text-gray-500" data-icon="lucide:user" data-width="12"></span>
                                                        {{ $task->assignee->name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4 text-xs text-gray-500 dark:text-gray-400">
                                                    @if($task->deadline_at)
                                                        <span class="{{ \Carbon\Carbon::parse($task->deadline_at)->isPast() ? 'text-red-500 dark:text-red-400 font-semibold' : '' }}">
                                                            {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M Y') }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <form action="{{ route('teams.tasks.update', [$team->id, $task->id]) }}" method="POST" class="inline m-0">
                                                        @csrf @method('PUT')
                                                        <select name="status" onchange="this.form.submit()" class="text-[10px] py-1 px-2 border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] rounded-md font-semibold focus:ring-[#0056b3] shadow-sm
                                                            {{ $task->status === 'done' ? 'text-green-600 dark:text-green-400' : ($task->status === 'in_progress' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-300') }}">
                                                            <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>TODO</option>
                                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>DONE</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td class="py-3 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-3">
                                                        <a href="{{ route('teams.tasks.show', [$team->id, $task->id]) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors" title="Lihat Detail">
                                                            <span class="iconify" data-icon="lucide:eye" data-width="16"></span>
                                                        </a>
                                                        <a href="{{ route('teams.tasks.edit', [$team->id, $task->id]) }}" class="text-[#0056b3] dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors" title="Edit Tugas">
                                                            <span class="iconify" data-icon="lucide:edit-3" data-width="16"></span>
                                                        </a>
                                                        
                                                        <div x-data="{ showDeleteTask: false }" class="flex items-center">
                                                            <button type="button" @click="showDeleteTask = true" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors" title="Hapus Tugas">
                                                                <span class="iconify" data-icon="lucide:trash-2" data-width="16"></span>
                                                            </button>

                                                            <div x-show="showDeleteTask" class="fixed inset-0 z-[70] overflow-y-auto" style="display: none;">
                                                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                                                    <div x-show="showDeleteTask" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-80 backdrop-blur-sm" @click="showDeleteTask = false"></div>
                                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                                    <div x-show="showDeleteTask" x-transition.duration.300ms class="inline-block w-full max-w-sm p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#242424] shadow-xl rounded-2xl relative z-10 whitespace-normal">
                                                                        <div class="flex items-center gap-4 mb-4">
                                                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                                                                                <span class="iconify" data-icon="lucide:trash-2" data-width="24"></span>
                                                                            </div>
                                                                            <div>
                                                                                <h3 class="text-lg font-bold text-[#37352f] dark:text-gray-100">Hapus Task</h3>
                                                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 text-left">Yakin mau hapus task <strong>{{ $task->title }}</strong> secara permanen?</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-6 flex justify-end gap-3">
                                                                            <button type="button" @click="showDeleteTask = false" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-[#37352f] dark:text-gray-200 text-sm font-bold py-2 px-4 rounded-md transition-colors">Batal</button>
                                                                            <form action="{{ route('teams.tasks.destroy', [$team->id, $task->id]) }}" method="POST" class="m-0">
                                                                                @csrf @method('DELETE')
                                                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded-md transition-colors">Ya, Hapus</button>
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
                    
                    <div class="bg-white dark:bg-[#242424] border border-gray-200 dark:border-gray-700 shadow-[0_1px_3px_rgba(0,0,0,0.02)] sm:rounded-lg p-6 transition-colors duration-300">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-3 transition-colors">
                            <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider flex items-center gap-2">
                                <span class="iconify" data-icon="lucide:info"></span> Detail Workspace
                            </h3>
                            <button @click="showActivityModal = true" class="text-[#0056b3] dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 p-1.5 rounded transition-colors" title="Lihat Riwayat Aktivitas">
                                <span class="iconify" data-icon="lucide:clock" data-width="16"></span>
                            </button>
                        </div>

                        <h3 class="text-xl font-bold text-[#37352f] dark:text-gray-100 mb-2 leading-tight transition-colors">{{ $team->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 transition-colors">{{ $team->description ?? 'Tidak ada deskripsi.' }}</p>

                        <div class="flex flex-col gap-3 text-sm font-medium mb-6">
                            <div class="flex justify-between items-center border-b border-gray-50 dark:border-gray-700/50 pb-2 transition-colors">
                                <span class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <span class="iconify" data-icon="lucide:eye" data-width="16"></span> Visibilitas
                                </span>
                                <span class="text-[#37352f] dark:text-gray-200 transition-colors">{{ ucfirst($team->visibility) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <span class="iconify" data-icon="lucide:activity" data-width="16"></span> Status
                                </span>
                                <span class="font-bold {{ $team->status == 'active' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} transition-colors">
                                    {{ ucfirst($team->status) }}
                                </span>
                            </div>
                        </div>

                        @if($team->owner_id == Auth::id())
                            <div x-data="{ showDeleteWorkspace: false }">
                                <div class="grid grid-cols-2 gap-3 border-t border-gray-100 dark:border-gray-700 pt-5 transition-colors">
                                    <a href="{{ route('teams.edit', $team->slug) }}" class="bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600 text-[#37352f] dark:text-gray-200 text-xs font-bold py-2 px-3 rounded-md flex items-center justify-center gap-1.5 transition-colors shadow-sm">
                                        <span class="iconify" data-icon="lucide:settings" data-width="14"></span> Edit
                                    </a>
                                    <button @click="showDeleteWorkspace = true" type="button" class="bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-800/50 border border-red-100 dark:border-red-800/50 text-red-600 dark:text-red-400 text-xs font-bold py-2 px-3 rounded-md flex items-center justify-center gap-1.5 transition-colors shadow-sm">
                                        <span class="iconify" data-icon="lucide:trash-2" data-width="14"></span> Hapus
                                    </button>
                                </div>

                                <div x-show="showDeleteWorkspace" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                        <div x-show="showDeleteWorkspace" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-80 backdrop-blur-sm" @click="showDeleteWorkspace = false"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div x-show="showDeleteWorkspace" x-transition.duration.300ms class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#242424] shadow-xl rounded-2xl relative z-10">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                                                    <span class="iconify" data-icon="lucide:alert-triangle" data-width="24"></span>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-[#37352f] dark:text-gray-100">Hapus Workspace</h3>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Yakin mau hapus workspace <strong>{{ $team->name }}</strong>? Semua data di dalamnya akan hilang permanen.</p>
                                                </div>
                                            </div>
                                            <div class="mt-6 flex justify-end gap-3">
                                                <button type="button" @click="showDeleteWorkspace = false" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-[#37352f] dark:text-gray-200 text-sm font-bold py-2 px-4 rounded-md transition-colors">Batal</button>
                                                <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="m-0">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded-md transition-colors">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-[#242424] border border-gray-200 dark:border-gray-700 shadow-[0_1px_3px_rgba(0,0,0,0.02)] sm:rounded-lg transition-colors duration-300" x-data="{ openMembers: false }">
                        <div @click="openMembers = !openMembers" class="p-5 flex justify-between items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <h3 class="text-sm font-bold text-[#37352f] dark:text-gray-100 flex items-center gap-2 transition-colors">
                                <span class="iconify text-gray-500 dark:text-gray-400" data-icon="lucide:users"></span>
                                Anggota Tim ({{ $members->count() }})
                            </h3>
                            <span class="iconify text-gray-400 transition-transform duration-300" :class="openMembers ? 'rotate-180' : ''" data-icon="lucide:chevron-down" data-width="18"></span>
                        </div>

                        <div x-show="openMembers" x-transition class="px-5 pb-5 border-t border-gray-100 dark:border-gray-700 pt-4" style="display: none;">
                            @if($team->owner_id == Auth::id())
                                <form action="{{ route('teams.members.store', $team->id) }}" method="POST" class="mb-5 flex flex-col gap-2">
                                    @csrf
                                    <input type="email" name="email" placeholder="Masukkan email user..." required class="text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 w-full focus:ring-[#0056b3]">
                                    <button type="submit" class="bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white text-sm font-bold py-2 px-4 rounded w-full shadow-sm transition-colors">
                                        + Undang
                                    </button>
                                </form>
                            @endif

                            <ul class="divide-y divide-gray-100 dark:divide-gray-700 transition-colors">
                                @foreach($members as $member)
                                    <li class="py-3 flex justify-between items-center">
                                        <div class="max-w-[50%]">
                                            <span class="font-semibold text-[#37352f] dark:text-gray-200 block truncate transition-colors">{{ $member->name }}</span>
                                            <span class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-[9px] px-1.5 py-0.5 rounded font-bold uppercase mt-1 inline-block transition-colors">{{ $member->pivot->role }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($team->owner_id == Auth::id() && $member->id != Auth::id())
                                                <form action="{{ route('teams.members.update', [$team->id, $member->id]) }}" method="POST" class="inline">
                                                    @csrf @method('PUT')
                                                    <select name="role" onchange="this.form.submit()" class="text-[10px] py-1 px-1 border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 rounded focus:ring-[#0056b3]">
                                                        <option value="admin" {{ $member->pivot->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="member" {{ $member->pivot->role == 'member' ? 'selected' : '' }}>Member</option>
                                                    </select>
                                                </form>
                                                
                                                <div x-data="{ showRemoveMember: false }" class="inline flex items-center">
                                                    <button type="button" @click="showRemoveMember = true" class="text-red-400 hover:text-red-600 p-1" title="Keluarkan">
                                                        <span class="iconify" data-icon="lucide:x-circle" data-width="16"></span>
                                                    </button>

                                                    <div x-show="showRemoveMember" class="fixed inset-0 z-[70] overflow-y-auto" style="display: none;">
                                                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                                            <div x-show="showRemoveMember" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-80 backdrop-blur-sm" @click="showRemoveMember = false"></div>
                                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                            <div x-show="showRemoveMember" x-transition.duration.300ms class="inline-block w-full max-w-sm p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#242424] shadow-xl rounded-2xl relative z-10">
                                                                <div class="flex items-center gap-4 mb-4">
                                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400">
                                                                        <span class="iconify" data-icon="lucide:user-x" data-width="24"></span>
                                                                    </div>
                                                                    <div>
                                                                        <h3 class="text-lg font-bold text-[#37352f] dark:text-gray-100">Keluarkan Anggota</h3>
                                                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Yakin mengeluarkan <strong>{{ $member->name }}</strong> dari tim?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-6 flex justify-end gap-3">
                                                                    <button type="button" @click="showRemoveMember = false" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-[#37352f] dark:text-gray-200 text-sm font-bold py-2 px-4 rounded-md transition-colors">Batal</button>
                                                                    <form action="{{ route('teams.members.destroy', [$team->id, $member->id]) }}" method="POST" class="m-0">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold py-2 px-4 rounded-md transition-colors">Ya, Keluarkan</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                <div x-show="showActivityModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-80 backdrop-blur-sm" @click="showActivityModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showActivityModal" x-transition.duration.300ms class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#242424] shadow-xl rounded-2xl relative z-10">
                    <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-4">
                        <h3 class="text-lg font-bold text-[#37352f] dark:text-gray-100 flex items-center gap-2">
                            <span class="iconify text-gray-500" data-icon="lucide:clock"></span> Riwayat Aktivitas
                        </h3>
                        <button @click="showActivityModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                            <span class="iconify" data-icon="lucide:x" data-width="20"></span>
                        </button>
                    </div>

                    <div class="max-h-[60vh] overflow-y-auto pr-2">
                        @if($activities->isEmpty())
                            <div class="text-center py-6">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat aktivitas.</p>
                            </div>
                        @else
                            <div class="relative border-l-2 border-gray-200 dark:border-gray-700 ml-3 mt-2">
                                @foreach($activities as $activity)
                                    <div class="mb-6 ml-6">
                                        <span class="absolute flex items-center justify-center w-4 h-4 bg-gray-200 dark:bg-gray-700 rounded-full -left-2.5 ring-4 ring-white dark:ring-[#242424]"></span>
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1">
                                            <h4 class="text-sm font-semibold text-[#37352f] dark:text-gray-200">{{ $activity->actor->name ?? 'Sistem' }}</h4>
                                            <time class="text-[10px] font-medium text-gray-400 dark:text-gray-500 sm:ml-3 bg-gray-50 dark:bg-gray-800 px-2 py-0.5 rounded">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</time>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $activity->description }}</p>
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