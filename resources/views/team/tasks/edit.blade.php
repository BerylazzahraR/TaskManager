<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f] dark:text-gray-200 transition-colors">Edit Task: {{ $task->code }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-700 dark:text-green-400 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm transition-colors">
                    <span class="iconify" data-icon="lucide:check-circle" data-width="18"></span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-[#242424] overflow-hidden border border-gray-200 dark:border-gray-700 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8 transition-colors duration-300">
                <div class="mb-6 border-b border-gray-100 dark:border-gray-700 pb-4 transition-colors">
                    <h3 class="text-xl font-bold text-[#37352f] dark:text-gray-100 flex items-center gap-2 transition-colors">
                        <span class="iconify" data-icon="lucide:edit-3"></span> Edit Detail Tugas
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 transition-colors">Perbarui informasi tugas <span class="font-mono bg-gray-100 dark:bg-gray-800 px-1 rounded">{{ $task->code }}</span> di bawah ini.</p>
                </div>

                <form action="{{ route('teams.tasks.update', [$team->id, $task->id]) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Judul Task <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $task->title) }}" required 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                        @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Deskripsi</label>
                        <textarea name="description" rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all font-semibold {{ $task->status === 'done' ? 'text-green-600 dark:text-green-400' : ($task->status === 'in_progress' ? 'text-yellow-600 dark:text-yellow-500' : 'text-gray-700 dark:text-gray-300') }}">
                                <option value="todo" {{ (old('status', $task->status) == 'todo') ? 'selected' : '' }}>TODO</option>
                                <option value="in_progress" {{ (old('status', $task->status) == 'in_progress') ? 'selected' : '' }}>IN PROGRESS</option>
                                <option value="done" {{ (old('status', $task->status) == 'done') ? 'selected' : '' }}>DONE</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Prioritas</label>
                            <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                                <option value="low" {{ (old('priority', $task->priority) == 'low') ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ (old('priority', $task->priority) == 'medium') ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ (old('priority', $task->priority) == 'high') ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Tugaskan Ke (Assignee)</label>
                            <select name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                                <option value="">-- Bebas / Unassigned --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ (old('assigned_to', $task->assigned_to) == $member->id) ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] dark:text-gray-200 mb-1 transition-colors">Deadline</label>
                            <input type="date" name="deadline_at" value="{{ old('deadline_at', $task->deadline_at ? \Carbon\Carbon::parse($task->deadline_at)->format('Y-m-d') : '') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all">
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700 transition-colors">
                        <a href="{{ route('teams.show', $team->slug) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-[#37352f] dark:hover:text-gray-200 font-medium py-2 px-4 rounded-md transition-colors">Batal</a>
                        <button type="submit" class="bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white text-sm font-medium py-2.5 px-6 rounded-md shadow-sm transition-all flex items-center gap-2">
                            <span class="iconify" data-icon="lucide:save" data-width="16"></span> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</x-app-layout>