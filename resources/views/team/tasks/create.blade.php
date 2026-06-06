<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-slate-800 dark:text-slate-200 transition-colors">Buat Task Baru</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- FORM CARD -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden border border-slate-100 dark:border-slate-700/50 sm:rounded-2xl shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none p-6 sm:p-8 transition-colors duration-300">
                
                <div class="mb-8 border-b border-slate-100 dark:border-slate-700/50 pb-5">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="iconify text-indigo-500" data-icon="lucide:file-plus-2"></span> Detail Tugas Baru
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5">Tambahkan tugas baru ke dalam workspace <strong class="text-slate-700 dark:text-slate-300">{{ $team->name }}</strong>.</p>
                </div>

                <form action="{{ route('teams.tasks.store', $team->id) }}" method="POST">
                    @csrf
                    <!-- Judul -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Judul Task <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Bikin desain banner..."
                            class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                        @error('title') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="4" placeholder="Jelaskan detail tugas ini..."
                            class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors resize-y">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-5">
                        <!-- Prioritas -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Prioritas</label>
                            <select name="priority" class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Status</label>
                            <select name="status" class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                                <option value="todo" {{ old('status', 'todo') == 'todo' ? 'selected' : '' }}>TODO</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>DONE</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                        <!-- Assignee -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tugaskan Ke</label>
                            <select name="assigned_to" class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                                <option value="">-- Bebas / Unassigned --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('assigned_to') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Deadline -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Deadline (Opsional)</label>
                            <input type="date" name="deadline_at" value="{{ old('deadline_at') }}" 
                                class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-5 border-t border-slate-100 dark:border-slate-700/50">
                        <a href="{{ route('teams.show', $team->slug) }}" class="text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2.5 px-6 rounded-lg shadow-sm transition-all flex items-center gap-2">
                            <span class="iconify" data-icon="lucide:save" data-width="16"></span> Simpan Task Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>