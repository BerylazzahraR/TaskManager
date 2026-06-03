<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f] dark:text-gray-200 transition-colors">Edit Workspace</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-[#242424] overflow-hidden border border-gray-200 dark:border-gray-700 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8 transition-colors duration-300">
                <div class="mb-6 border-b border-gray-100 dark:border-gray-700 pb-4 transition-colors">
                    <h3 class="text-xl font-bold text-[#37352f] dark:text-gray-100 flex items-center gap-2 transition-colors">
                        <span class="iconify" data-icon="lucide:settings"></span> Pengaturan Utama
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 transition-colors">Perbarui informasi dasar untuk ruang kerja <strong>{{ $team->name }}</strong>.</p>
                </div>

                <form action="{{ route('teams.update', $team->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Nama Workspace <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">{{ old('description', $team->description) }}</textarea>
                    </div>

                    <div class="mb-8">
                        <label for="visibility" class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Visibilitas</label>
                        <select name="visibility" id="visibility" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                            <option value="private" {{ old('visibility', $team->visibility) == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="internal" {{ old('visibility', $team->visibility) == 'internal' ? 'selected' : '' }}>Internal</option>
                        </select>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700 transition-colors">
                        <a href="{{ route('teams.show', $team->slug) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-[#37352f] dark:hover:text-gray-200 font-medium py-2 px-4 rounded-md transition-colors">Batal</a>
                        <button type="submit" class="bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white text-sm font-medium py-2.5 px-6 rounded-md shadow-sm transition-all flex items-center gap-2">
                            <span class="iconify" data-icon="lucide:save" data-width="16"></span> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- KARTU ZONA BERBAHAYA -->
            <div class="bg-red-50/30 dark:bg-red-900/10 overflow-hidden border border-red-200 dark:border-red-900/50 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8 mt-6 transition-colors duration-300">
                <div class="flex items-start sm:items-center justify-between flex-col sm:flex-row gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-red-600 dark:text-red-400 flex items-center gap-2 mb-1 transition-colors">
                            <span class="iconify" data-icon="lucide:alert-triangle"></span> Zona Berbahaya
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors">Mengarsipkan workspace akan mencegah penambahan task baru. Lo tetap bisa melihat histori task.</p>
                    </div>
                    @if($team->status === 'active')
                        <form action="{{ route('teams.archive', $team->id) }}" method="POST" onsubmit="return confirm('Yakin mau mengarsipkan workspace ini?');" class="shrink-0">
                            @csrf
                            <button type="submit" class="bg-white dark:bg-[#242424] border border-yellow-500 dark:border-yellow-600 text-yellow-600 dark:text-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 font-bold py-2 px-4 rounded-md text-sm transition-colors flex items-center gap-2 shadow-sm">
                                <span class="iconify" data-icon="lucide:archive"></span> Arsipkan Workspace
                            </button>
                        </form>
                    @else
                        <form action="{{ route('teams.restore', $team->id) }}" method="POST" onsubmit="return confirm('Aktifkan kembali workspace ini?');" class="shrink-0">
                            @csrf
                            <button type="submit" class="bg-white dark:bg-[#242424] border border-green-500 dark:border-green-600 text-green-600 dark:text-green-500 hover:bg-green-50 dark:hover:bg-green-900/30 font-bold py-2 px-4 rounded-md text-sm transition-colors flex items-center gap-2 shadow-sm">
                                <span class="iconify" data-icon="lucide:refresh-cw"></span> Pulihkan (Restore)
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</x-app-layout>