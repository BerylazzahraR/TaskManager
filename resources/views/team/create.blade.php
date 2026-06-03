<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f] dark:text-gray-200 transition-colors">Buat Workspace Baru</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-[#242424] overflow-hidden border border-gray-200 dark:border-gray-700 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8 transition-colors duration-300">
                
                <div class="mb-6 border-b border-gray-100 dark:border-gray-700 pb-4 transition-colors">
                    <h3 class="text-xl font-bold text-[#37352f] dark:text-gray-100 flex items-center gap-2 transition-colors">
                        <span class="iconify" data-icon="lucide:folder-plus"></span> Detail Workspace
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 transition-colors">Isi informasi di bawah ini untuk membuat ruang kerja baru.</p>
                </div>

                <form action="{{ route('teams.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">
                            Nama Workspace <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Panitia Dies Natalis 2026" required 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                        @error('name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Deskripsi (Opsional)</label>
                        <textarea name="description" id="description" rows="4" placeholder="Tuliskan tujuan atau deskripsi singkat workspace ini..." 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label for="visibility" class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Visibilitas <span class="text-red-500 dark:text-red-400">*</span></label>
                        <select name="visibility" id="visibility" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                            <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private (Hanya anggota yang diundang)</option>
                            <option value="internal" {{ old('visibility') == 'internal' ? 'selected' : '' }}>Internal (Bisa dilihat oleh semua user)</option>
                        </select>
                        @error('visibility') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700 transition-colors">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-[#37352f] dark:hover:text-gray-200 font-medium py-2 px-4 rounded-md transition-colors">Batal</a>
                        <button type="submit" class="bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white text-sm font-medium py-2.5 px-6 rounded-md shadow-sm transition-all flex items-center gap-2">
                            <span class="iconify" data-icon="lucide:plus" data-width="16"></span> Buat Workspace
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</x-app-layout>