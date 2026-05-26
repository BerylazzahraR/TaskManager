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

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-bold border-b pb-2 mb-4">Anggota Tim ({{ $members->count() }})</h3>
    
    @if($team->owner_id == Auth::id())
        <form action="{{ route('teams.members.store', $team->id) }}" method="POST" class="mb-4 flex gap-2">
            @csrf
            <input type="email" name="email" placeholder="Masukkan email user..." required class="text-sm rounded-md border-gray-300 flex-1">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-sm font-bold py-1 px-3 rounded">
                + Undang
            </button>
        </form>
        @error('email') <span class="text-red-500 text-xs block mb-2">{{ $message }}</span> @enderror
        @if(session('error')) <span class="text-red-500 text-xs block mb-2">{{ session('error') }}</span> @endif
    @endif

    <ul class="divide-y divide-gray-100">
        @foreach($members as $member)
            <li class="py-3 flex justify-between items-center">
                <div>
                    <span class="font-semibold">{{ $member->name }}</span> 
                    <span class="text-xs text-gray-500 block">{{ $member->email }}</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded">{{ strtoupper($member->pivot->role) }}</span>
                    
                    @if($team->owner_id == Auth::id() && $member->id != Auth::id())
                        <form action="{{ route('teams.members.update', [$team->id, $member->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <select name="role" onchange="this.form.submit()" class="text-xs py-1 px-2 border-gray-300 rounded">
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

        </div>
    </div>
</x-app-layout>