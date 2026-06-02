<x-app-layout>
    <x-slot name="header">
        <!-- Breadcrumb Header -->
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-[#0056b3] transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f]">Edit Task: {{ $task->code }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm">
                    <span class="iconify" data-icon="lucide:check-circle" data-width="18"></span>
                    {{ session('success') }}
                </div>
            @endif

            <!-- 1. KARTU FORM EDIT TASK -->
            <div class="bg-white overflow-hidden border border-gray-200 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8">
                
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-[#37352f] flex items-center gap-2">
                        <span class="iconify" data-icon="lucide:edit-3"></span>
                        Edit Detail Tugas
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Perbarui informasi tugas <span class="font-mono bg-gray-100 px-1 rounded">{{ $task->code }}</span> di bawah ini.</p>
                </div>

                <form action="{{ route('teams.tasks.update', [$team->id, $task->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Judul Task <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $task->title) }}" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                        @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Deskripsi</label>
                        <textarea name="description" rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all font-semibold
                                {{ $task->status === 'done' ? 'text-green-600' : ($task->status === 'in_progress' ? 'text-yellow-600' : 'text-gray-700') }}">
                                <option value="todo" {{ (old('status', $task->status) == 'todo') ? 'selected' : '' }}>TODO</option>
                                <option value="in_progress" {{ (old('status', $task->status) == 'in_progress') ? 'selected' : '' }}>IN PROGRESS</option>
                                <option value="done" {{ (old('status', $task->status) == 'done') ? 'selected' : '' }}>DONE</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Prioritas</label>
                            <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                                <option value="low" {{ (old('priority', $task->priority) == 'low') ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ (old('priority', $task->priority) == 'medium') ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ (old('priority', $task->priority) == 'high') ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Tugaskan Ke (Assignee)</label>
                            <select name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                                <option value="">-- Bebas / Unassigned --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ (old('assigned_to', $task->assigned_to) == $member->id) ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Deadline</label>
                            <input type="date" name="deadline_at" value="{{ old('deadline_at', $task->deadline_at ? \Carbon\Carbon::parse($task->deadline_at)->format('Y-m-d') : '') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('teams.show', $team->slug) }}" class="text-sm text-gray-600 hover:text-[#37352f] font-medium py-2 px-4 rounded-md transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="bg-[#37352f] hover:bg-[#2f2d27] text-white text-sm font-medium py-2.5 px-6 rounded-md shadow-sm transition-all flex items-center gap-2">
                            <span class="iconify" data-icon="lucide:save" data-width="16"></span> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            

        </div>
    </div>
    
    <!-- Script Iconify dipanggil langsung di sini -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</x-app-layout>