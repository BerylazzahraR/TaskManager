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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold border-b pb-2 mb-4">Anggota Tim ({{ $members->count() }})</h3>
                    <ul>
                        @foreach($members as $member)
                            <li class="py-1">- {{ $member->name }} <span class="text-xs text-gray-500">({{ $member->pivot->role }})</span></li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold border-b pb-2 mb-4">Daftar Task</h3>
                    @if($tasks->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada task di workspace ini.</p>
                    @else
                        <ul>
                            @foreach($tasks as $task)
                                <li class="py-1">- {{ $task->title }} <span class="text-xs text-gray-500">[{{ $task->status }}]</span></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>