<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-[#0056b3] transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f]">Buat Task Baru</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border border-gray-200 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8">
                
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-[#37352f] flex items-center gap-2">
                        <span class="iconify" data-icon="lucide:check-square"></span>
                        Detail Tugas Baru
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Tambahkan tugas baru ke dalam workspace <strong>{{ $team->name }}</strong>.</p>
                </div>

                <form action="{{ route('teams.tasks.store', $team->id) }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Judul Task <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Prioritas</label>
                            <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Deadline (Opsional)</label>
                            <input type="date" name="deadline_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Tugaskan Ke (PIC)</label>
                        <select name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm">
                            <option value="">-- Biarkan Kosong --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('teams.show', $team->slug) }}" class="text-sm text-gray-600 hover:text-[#37352f] font-medium py-2 px-4 rounded-md transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="bg-[#37352f] hover:bg-[#2f2d27] text-white text-sm font-medium py-2.5 px-6 rounded-md shadow-sm transition-all">
                            Buat Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</x-app-layout>