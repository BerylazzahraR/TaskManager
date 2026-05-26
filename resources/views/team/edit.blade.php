<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Workspace: {{ $team->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Pengaturan Utama</h3>
                <form action="{{ route('teams.update', $team->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Workspace</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $team->description) }}</textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="visibility" class="block text-sm font-medium text-gray-700">Visibilitas</label>
                        <select name="visibility" id="visibility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="private" {{ old('visibility', $team->visibility) == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="internal" {{ old('visibility', $team->visibility) == 'internal' ? 'selected' : '' }}>Internal</option>
                        </select>
                        @error('visibility') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('teams.show', $team->slug) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-red-200">
                <h3 class="text-lg font-bold text-red-600 mb-4">Zona Berbahaya</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Mengarsipkan workspace akan mencegah penambahan task baru. Lo tetap bisa melihat histori task yang ada.
                </p>
                
                @if($team->status === 'active')
                    <form action="{{ route('teams.archive', $team->id) }}" method="POST" onsubmit="return confirm('Yakin mau mengarsipkan workspace ini?');">
                        @csrf
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            Arsipkan Workspace
                        </button>
                    </form>
                @else
                    <form action="{{ route('teams.restore', $team->id) }}" method="POST" onsubmit="return confirm('Aktifkan kembali workspace ini?');">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Pulihkan (Restore) Workspace
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>