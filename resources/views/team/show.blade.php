<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $team->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-2">Informasi Workspace</h3>
                <p><strong>Deskripsi:</strong> {{ $team->description ?? '-' }}</p>
                <p><strong>Visibilitas:</strong> {{ ucfirst($team->visibility) }}</p>
                <p><strong>Status:</strong> <span class="{{ $team->status == 'active' ? 'text-green-600' : 'text-red-600' }} font-bold">{{ ucfirst($team->status) }}</span></p>
                
                @if($team->owner_id == Auth::id())
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('teams.edit', $team->slug) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-2 rounded flex items-center">
                            Edit Pengaturan
                        </a>

                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus workspace ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded flex items-center">
                                Hapus Workspace
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold border-b pb-2 mb-4">Anggota Tim ({{ $members->count() }})</h3>
                    
                    @if($team->owner_id == Auth::id())
                        <form action="{{ route('teams.members.store', $team->id) }}" method="POST" class="mb-4 flex gap-2">
                            @csrf
                            <input type="email" name="email" placeholder="Masukkan email user..." required class="text-sm rounded-md border-gray-300 flex-1 focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-sm font-bold py-1 px-3 rounded">
                                + Undang
                            </button>
                        </form>
                        @error('email') <span class="text-red-500 text-xs block mb-2">{{ $message }}</span> @enderror
                    @endif

                    <ul class="divide-y divide-gray-100">
                        @foreach($members as $member)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <span class="font-semibold">{{ $member->name }}</span> 
                                    <span class="text-xs text-gray-500 block">{{ $member->email }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <span class="bg-gray-200 text-gray-800 text-[10px] px-2 py-1 rounded font-bold">{{ strtoupper($member->pivot->role) }}</span>
                                    
                                    @if($team->owner_id == Auth::id() && $member->id != Auth::id())
                                        <form action="{{ route('teams.members.update', [$team->id, $member->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" onchange="this.form.submit()" class="text-xs py-1 px-2 border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                                <option value="admin" {{ $member->pivot->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="member" {{ $member->pivot->role == 'member' ? 'selected' : '' }}>Member</option>
                                            </select>
                                        </form>

                                        <form action="{{ route('teams.members.destroy', [$team->id, $member->id]) }}" method="POST" class="inline" onsubmit="return confirm('Keluarkan user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold px-1">
                                                [X]
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center border-b pb-2 mb-4">
    <h3 class="text-lg font-bold">Daftar Task Workspace</h3>
    <a href="{{ route('teams.tasks.board', $team->slug) }}" class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold py-1 px-3 rounded flex items-center gap-1 shadow-sm">
        📊 Buka Kanban Board
    </a>
</div>

                    <form method="GET" action="{{ route('teams.show', $team->slug) }}" class="mb-6 bg-blue-50 p-3 rounded-lg border border-blue-100 flex flex-col sm:flex-row gap-2 items-end sm:items-center">
                        <div class="flex-1 w-full sm:w-auto">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Pencarian</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul task atau TSK-..." class="text-xs rounded-md border-gray-300 w-full focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="w-full sm:w-1/4">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Status</label>
                            <select name="status" class="text-xs rounded-md border-gray-300 w-full focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>TODO</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>DONE</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-1/4">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Assignee</label>
                            <select name="assigned_to" class="text-xs rounded-md border-gray-300 w-full focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Member</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ request('assigned_to') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-1 w-full sm:w-auto">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold py-2 px-4 rounded w-full sm:w-auto mt-4 sm:mt-0">
                                Cari
                            </button>
                            
                            @if(request()->hasAny(['search', 'status', 'assigned_to']) && (request('search') || request('status') || request('assigned_to')))
                                <a href="{{ route('teams.show', $team->slug) }}" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-2 px-3 rounded text-center mt-4 sm:mt-0 flex items-center justify-center">
                                    X
                                </a>
                            @endif
                        </div>
                    </form>

                    @if($team->status === 'active')
                        <form action="{{ route('teams.tasks.store', $team->id) }}" method="POST" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            @csrf
                            <h4 class="text-sm font-bold text-gray-700 mb-3">+ Buat Tugas Baru</h4>
                            
                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <input type="text" name="title" placeholder="Judul Task..." required class="text-sm rounded-md border-gray-300 w-full focus:ring-blue-500 focus:border-blue-500">
                                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <textarea name="description" placeholder="Deskripsi Task (Opsional)..." rows="2" class="text-sm rounded-md border-gray-300 w-full focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Prioritas</label>
                                        <select name="priority" class="text-xs rounded-md border-gray-300 w-full focus:ring-blue-500 focus:border-blue-500">
                                            <option value="low">Low</option>
                                            <option value="medium" selected>Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Tugaskan Ke</label>
                                        <select name="assigned_to" class="text-xs rounded-md border-gray-300 w-full focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">-- Bebas --</option>
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Deadline</label>
                                    <input type="date" name="deadline_at" class="text-xs rounded-md border-gray-300 w-full focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded w-full mt-1">
                                    Simpan Tugas
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-700 p-3 rounded-md text-xs">
                            ⚠️ Workspace diarsipkan. Lo nggak bisa nambahin task baru di sini.
                        </div>
                    @endif

                    @if($tasks->isEmpty())
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada task di workspace ini. Ayo buat satu!</p>
                    @else
                        <ul class="divide-y divide-gray-100">
                            @foreach($tasks as $task)
                                <li class="py-4 space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="text-xs font-mono bg-gray-100 border border-gray-200 text-gray-600 px-1.5 py-0.5 rounded mr-2">{{ $task->code }}</span>
                                            <span class="font-bold text-gray-800">{{ $task->title }}</span>
                                            @if($task->description)
                                                <p class="text-xs text-gray-500 mt-1.5">{{ $task->description }}</p>
                                            @endif
                                        </div>
                                        
                                        <div class="flex gap-2">
                                            <a href="{{ route('teams.tasks.edit', [$team->id, $task->id]) }}" class="text-blue-500 hover:text-blue-700 text-xs font-bold bg-blue-50 px-2 py-1 rounded">
                                                Edit
                                            </a>

                                            <form action="{{ route('teams.tasks.destroy', [$team->id, $task->id]) }}" method="POST" onsubmit="return confirm('Yakin mau hapus task ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs font-bold bg-red-50 px-2 py-1 rounded">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center text-xs bg-gray-50 p-2 rounded">
                                        <div class="flex gap-3 items-center">
                                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider
                                                {{ $task->priority === 'high' ? 'bg-red-100 text-red-700' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                                {{ $task->priority }}
                                            </span>
                                            
                                            <span class="text-gray-600">
                                                PIC: <span class="font-semibold">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                                            </span>
                                        </div>

                                        <form action="{{ route('teams.tasks.update', [$team->id, $task->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" onchange="this.form.submit()" class="text-xs py-1 px-2 border-gray-300 rounded font-semibold focus:ring-blue-500 focus:border-blue-500
                                                {{ $task->status === 'done' ? 'text-green-600' : ($task->status === 'in_progress' ? 'text-yellow-600' : 'text-gray-600') }}">
                                                <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>TODO</option>
                                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>DONE</option>
                                            </select>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
        <div class="mt-6 bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold border-b pb-2 mb-6">Riwayat Aktivitas</h3>
                
                @if($activities->isEmpty())
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada riwayat aktivitas di workspace ini.</p>
                @else
                    <div class="relative border-l-2 border-gray-100 ml-3">
                        @foreach($activities as $activity)
                            <div class="mb-6 ml-6">
                                <span class="absolute flex items-center justify-center w-4 h-4 bg-blue-500 rounded-full -left-2 ring-4 ring-white"></span>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1">
                                    <h4 class="text-sm font-semibold text-gray-900">
                                        {{ $activity->actor->name ?? 'Sistem' }}
                                    </h4>
                                    <time class="text-xs font-normal text-gray-400 sm:ml-3">
                                        {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                    </time>
                                </div>
                                
                                <p class="text-sm text-gray-600">
                                    {{ $activity->description }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
    </div>
</x-app-layout>