<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f]">{{ $team->name }}</span>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showActivityModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm">
                    <span class="iconify" data-icon="lucide:check-circle"></span> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm">
                    <span class="iconify" data-icon="lucide:alert-circle"></span> {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white border border-gray-200 shadow-[0_1px_3px_rgba(0,0,0,0.02)] sm:rounded-lg p-6">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b border-gray-100 pb-4 mb-5 gap-4">
                            <h3 class="text-lg font-bold text-[#37352f] flex items-center gap-2">
                                <span class="iconify text-gray-500" data-icon="lucide:list-todo"></span>
                                Daftar Task Workspace
                            </h3>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('teams.tasks.board', $team->slug) }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-[#37352f] text-xs font-bold py-2 px-3 rounded flex items-center gap-1 shadow-sm transition-all">
                                    <span class="iconify" data-icon="lucide:kanban-square"></span> Kanban Board
                                </a>
                                @if($team->status === 'active')
                                    <a href="{{ route('teams.tasks.create', $team->slug) }}" class="bg-[#37352f] hover:bg-[#2f2d27] text-white text-xs font-bold py-2 px-3 rounded flex items-center gap-1 shadow-sm transition-all">
                                        <span class="iconify" data-icon="lucide:plus"></span> Buat Task
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if($team->status !== 'active')
                            <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-700 p-3 rounded-md text-xs flex items-center gap-2">
                                <span class="iconify" data-icon="lucide:alert-triangle"></span> Workspace diarsipkan. Tidak dapat menambah task baru.
                            </div>
                        @endif

                        <form method="GET" action="{{ route('teams.show', $team->slug) }}" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Pencarian</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari task..." class="text-xs rounded-md border-gray-300 w-full focus:ring-[#0056b3]">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status</label>
                                    <select name="status" class="text-xs rounded-md border-gray-300 w-full focus:ring-[#0056b3]">
                                        <option value="">Semua</option>
                                        <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>TODO</option>
                                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>DONE</option>
                                    </select>
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Assignee</label>
                                    <select name="assigned_to" class="text-xs rounded-md border-gray-300 w-full focus:ring-[#0056b3]">
                                        <option value="">Semua</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ request('assigned_to') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-1 flex gap-2 h-[34px]">
                                    <button type="submit" class="bg-[#37352f] hover:bg-[#2f2d27] text-white text-xs font-bold px-4 rounded-md w-full transition-colors shadow-sm">Cari</button>
                                    @if(request()->hasAny(['search', 'status', 'assigned_to']) && (request('search') || request('status') || request('assigned_to')))
                                        <a href="{{ route('teams.show', $team->slug) }}" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 text-xs font-bold px-3 rounded-md flex items-center justify-center transition-colors shadow-sm" title="Reset Filter">X</a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        @if($tasks->isEmpty())
                            <div class="text-center py-10 border border-dashed border-gray-200 rounded-lg">
                                <span class="iconify text-gray-300 mx-auto mb-2" data-icon="lucide:inbox" data-width="32"></span>
                                <p class="text-sm text-gray-500">Tidak ada data yang tersedia.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto rounded-lg border border-gray-100">
                                <table class="w-full text-left border-collapse whitespace-nowrap">
                                    <thead class="bg-gray-50/80">
                                        <tr class="border-b border-gray-100 text-[10px] uppercase tracking-wider text-gray-500">
                                            <th class="py-3 px-4 font-bold">Kode</th>
                                            <th class="py-3 px-4 font-bold">Judul Task</th>
                                            <th class="py-3 px-4 font-bold text-center">Prioritas</th>
                                            <th class="py-3 px-4 font-bold">Assignee</th>
                                            <th class="py-3 px-4 font-bold">Deadline</th>
                                            <th class="py-3 px-4 font-bold text-center">Status</th>
                                            <th class="py-3 px-4 font-bold text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 text-sm">
                                        @foreach($tasks as $task)
                                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                                <td class="py-3 px-4">
                                                    <span class="text-[10px] font-mono bg-white border border-gray-200 shadow-sm text-gray-600 px-1.5 py-0.5 rounded">{{ $task->code }}</span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="font-bold text-[#37352f]">{{ $task->title }}</span>
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                                        {{ $task->priority === 'high' ? 'bg-red-50 text-red-600 border border-red-100' : ($task->priority === 'medium' ? 'bg-yellow-50 text-yellow-600 border border-yellow-100' : 'bg-green-50 text-green-600 border border-green-100') }}">
                                                        {{ $task->priority }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="text-xs text-gray-600 flex items-center gap-1.5">
                                                        <span class="iconify text-gray-400" data-icon="lucide:user" data-width="12"></span>
                                                        {{ $task->assignee->name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4 text-xs text-gray-500">
                                                    @if($task->deadline_at)
                                                        <span class="{{ \Carbon\Carbon::parse($task->deadline_at)->isPast() ? 'text-red-500 font-semibold' : '' }}">
                                                            {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M Y') }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    <form action="{{ route('teams.tasks.update', [$team->id, $task->id]) }}" method="POST" class="inline m-0">
                                                        @csrf @method('PUT')
                                                        <select name="status" onchange="this.form.submit()" class="text-[10px] py-1 px-2 border-gray-300 rounded-md font-semibold focus:ring-[#0056b3] shadow-sm
                                                            {{ $task->status === 'done' ? 'text-green-600' : ($task->status === 'in_progress' ? 'text-yellow-600' : 'text-gray-600') }}">
                                                            <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>TODO</option>
                                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>DONE</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td class="py-3 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-3">
                                                        <a href="{{ route('teams.tasks.show', [$team->id, $task->id]) }}" class="text-green-600 hover:text-green-800 transition-colors" title="Lihat Detail">
                                                            <span class="iconify" data-icon="lucide:eye" data-width="16"></span>
                                                        </a>
                                                        <a href="{{ route('teams.tasks.edit', [$team->id, $task->id]) }}" class="text-[#0056b3] hover:text-blue-800 transition-colors" title="Edit Tugas">
                                                            <span class="iconify" data-icon="lucide:edit-3" data-width="16"></span>
                                                        </a>
                                                        
                                                        <div x-data="{ showDeleteTask: false }" class="flex items-center">
                                                            <button type="button" @click="showDeleteTask = true" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus Tugas">
                                                                <span class="iconify" data-icon="lucide:trash-2" data-width="16"></span>
                                                            </button>

                                                            <div x-show="showDeleteTask" class="fixed inset-0 z-[70] overflow-y-auto" style="display: none;">
                                                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                                                    <div x-show="showDeleteTask" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 backdrop-blur-sm" @click="showDeleteTask = false"></div>
                                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                                    <div x-show="showDeleteTask" x-transition.duration.300ms class="inline-block w-full max-w-sm p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl relative z-10 whitespace-normal">
                                                                        <div class="flex items-center gap-4 mb-4">
                                                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                                                                <span class="iconify" data-icon="lucide:trash-2" data-width="24"></span>
                                                                            </div>
                                                                            <div>
                                                                                <h3 class="text-lg font-bold text-[#37352f]">Hapus Task</h3>
                                                                                <p class="text-sm text-gray-500 mt-1 text-left">Yakin mau hapus task <strong>{{ $task->code }}</strong> secara permanen?</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-6 flex justify-end gap-3">
                                                                            <button type="button" @click="showDeleteTask = false" class="bg-gray-100 hover:bg-gray-200 text-[#37352f] text-sm font-bold py-2 px-4 rounded-md transition-colors">Batal</button>
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
                    
                    <div class="bg-white border border-gray-200 shadow-[0_1px_3px_rgba(0,0,0,0.02)] sm:rounded-lg p-6">
                        
                        <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                                <span class="iconify" data-icon="lucide:info"></span> Detail Workspace
                            </h3>
                            <button @click="showActivityModal = true" class="text-[#0056b3] hover:bg-blue-50 p-1.5 rounded transition-colors" title="Lihat Riwayat Aktivitas">
                                <span class="iconify" data-icon="lucide:clock" data-width="16"></span>
                            </button>
                        </div>

                        <h3 class="text-xl font-bold text-[#37352f] mb-2 leading-tight">{{ $team->name }}</h3>
                        <p class="text-sm text-gray-500 mb-6">{{ $team->description ?? 'Tidak ada deskripsi.' }}</p>

                        <div class="flex flex-col gap-3 text-sm font-medium mb-6">
                            <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                                <span class="flex items-center gap-2 text-gray-500">
                                    <span class="iconify" data-icon="lucide:eye" data-width="16"></span> Visibilitas
                                </span>
                                <span class="text-[#37352f]">{{ ucfirst($team->visibility) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="flex items-center gap-2 text-gray-500">
                                    <span class="iconify" data-icon="lucide:activity" data-width="16"></span> Status
                                </span>
                                <span class="font-bold {{ $team->status == 'active' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($team->status) }}
                                </span>
                            </div>
                        </div>

                        @if($team->owner_id == Auth::id())
                            <div x-data="{ showDeleteWorkspace: false }">
                                <div class="grid grid-cols-2 gap-3 border-t border-gray-100 pt-5">
                                    <a href="{{ route('teams.edit', $team->slug) }}" class="bg-gray-50 hover:bg-gray-100 border border-gray-200 text-[#37352f] text-xs font-bold py-2 px-3 rounded-md flex items-center justify-center gap-1.5 transition-colors shadow-sm">
                                        <span class="iconify" data-icon="lucide:settings" data-width="14"></span> Edit
                                    </a>
                                    <button @click="showDeleteWorkspace = true" type="button" class="bg-red-50 hover:bg-red-100 border border-red-100 text-red-600 text-xs font-bold py-2 px-3 rounded-md flex items-center justify-center gap-1.5 transition-colors shadow-sm">
                                        <span class="iconify" data-icon="lucide:trash-2" data-width="14"></span> Hapus
                                    </button>
                                </div>

                                <div x-show="showDeleteWorkspace" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                        <div x-show="showDeleteWorkspace" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 backdrop-blur-sm" @click="showDeleteWorkspace = false"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div x-show="showDeleteWorkspace" x-transition.duration.300ms class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl relative z-10">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                                    <span class="iconify" data-icon="lucide:alert-triangle" data-width="24"></span>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-[#37352f]">Hapus Workspace</h3>
                                                    <p class="text-sm text-gray-500 mt-1">Yakin mau hapus <strong>{{ $team->name }}</strong>? Semua data akan hilang permanen.</p>
                                                </div>
                                            </div>
                                            <div class="mt-6 flex justify-end gap-3">
                                                <button type="button" @click="showDeleteWorkspace = false" class="bg-gray-100 hover:bg-gray-200 text-[#37352f] text-sm font-bold py-2 px-4 rounded-md transition-colors">Batal</button>
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

                    <div class="bg-white border border-gray-200 shadow-[0_1px_3px_rgba(0,0,0,0.02)] sm:rounded-lg" x-data="{ openMembers: false }">
                        <div @click="openMembers = !openMembers" class="p-5 flex justify-between items-center cursor-pointer hover:bg-gray-50 transition-colors">
                            <h3 class="text-sm font-bold text-[#37352f] flex items-center gap-2">
                                <span class="iconify text-gray-500" data-icon="lucide:users"></span>
                                Anggota Tim ({{ $members->count() }})
                            </h3>
                            <span class="iconify text-gray-400 transition-transform duration-300" :class="openMembers ? 'rotate-180' : ''" data-icon="lucide:chevron-down" data-width="18"></span>
                        </div>

                        <div x-show="openMembers" x-transition class="px-5 pb-5 border-t border-gray-100 pt-4" style="display: none;">
                            @if($team->owner_id == Auth::id())
                                <form action="{{ route('teams.members.store', $team->id) }}" method="POST" class="mb-5 flex flex-col gap-2">
                                    @csrf
                                    <input type="email" name="email" placeholder="Masukkan email..." required class="text-sm rounded-md border-gray-300 w-full focus:ring-[#0056b3] focus:border-[#0056b3]">
                                    <button type="submit" class="bg-[#37352f] hover:bg-[#2f2d27] text-white text-sm font-bold py-2 px-4 rounded w-full shadow-sm">
                                        + Undang
                                    </button>
                                </form>
                                @error('email') <span class="text-red-500 text-xs block mb-2">{{ $message }}</span> @enderror
                            @endif

                            <ul class="divide-y divide-gray-100">
                                @foreach($members as $member)
                                    <li class="py-3 flex justify-between items-center">
                                        <div class="max-w-[60%]">
                                            <span class="font-semibold text-[#37352f] block truncate" title="{{ $member->name }}">{{ $member->name }}</span>
                                            <span class="bg-gray-100 text-gray-600 text-[9px] px-1.5 py-0.5 rounded font-bold uppercase mt-1 inline-block">{{ $member->pivot->role }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($team->owner_id == Auth::id() && $member->id != Auth::id())
                                                <form action="{{ route('teams.members.update', [$team->id, $member->id]) }}" method="POST" class="inline">
                                                    @csrf @method('PUT')
                                                    <select name="role" onchange="this.form.submit()" class="text-[10px] py-1 px-1 border-gray-300 rounded focus:ring-[#0056b3]">
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
                                                            <div x-show="showRemoveMember" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 backdrop-blur-sm" @click="showRemoveMember = false"></div>
                                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                            <div x-show="showRemoveMember" x-transition.duration.300ms class="inline-block w-full max-w-sm p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl relative z-10">
                                                                <div class="flex items-center gap-4 mb-4">
                                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                                                                        <span class="iconify" data-icon="lucide:user-x" data-width="24"></span>
                                                                    </div>
                                                                    <div>
                                                                        <h3 class="text-lg font-bold text-[#37352f]">Keluarkan Anggota</h3>
                                                                        <p class="text-sm text-gray-500 mt-1">Yakin mengeluarkan <strong>{{ $member->name }}</strong> dari tim?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-6 flex justify-end gap-3">
                                                                    <button type="button" @click="showRemoveMember = false" class="bg-gray-100 hover:bg-gray-200 text-[#37352f] text-sm font-bold py-2 px-4 rounded-md transition-colors">Batal</button>
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

        <div x-show="showActivityModal" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showActivityModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 backdrop-blur-sm" @click="showActivityModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showActivityModal" x-transition.duration.300ms class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl relative z-10">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                        <h3 class="text-lg font-bold text-[#37352f] flex items-center gap-2" id="modal-title">
                            <span class="iconify text-gray-500" data-icon="lucide:clock"></span>
                            Riwayat Aktivitas
                        </h3>
                        <button @click="showActivityModal = false" class="text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                            <span class="iconify" data-icon="lucide:x" data-width="20"></span>
                        </button>
                    </div>

                    <div class="max-h-[60vh] overflow-y-auto pr-2">
                        @if($activities->isEmpty())
                            <div class="text-center py-6">
                                <span class="iconify text-gray-300 mx-auto mb-2" data-icon="lucide:activity" data-width="32"></span>
                                <p class="text-sm text-gray-500">Belum ada riwayat aktivitas di workspace ini.</p>
                            </div>
                        @else
                            <div class="relative border-l-2 border-gray-200 ml-3 mt-2">
                                @foreach($activities as $activity)
                                    <div class="mb-6 ml-6">
                                        <span class="absolute flex items-center justify-center w-4 h-4 bg-gray-200 rounded-full -left-2.5 ring-4 ring-white"></span>
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1">
                                            <h4 class="text-sm font-semibold text-[#37352f]">
                                                {{ $activity->actor->name ?? 'Sistem' }}
                                            </h4>
                                            <time class="text-[10px] font-medium text-gray-400 sm:ml-3 bg-gray-50 px-2 py-0.5 rounded">
                                                {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                            </time>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $activity->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-6 border-t border-gray-100 pt-4 flex justify-end">
                        <button @click="showActivityModal = false" class="bg-gray-100 hover:bg-gray-200 text-[#37352f] text-sm font-bold py-2 px-6 rounded-md transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</x-app-layout>