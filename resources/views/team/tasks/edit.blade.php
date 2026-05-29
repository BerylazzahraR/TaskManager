<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task: {{ $task->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-4">
                    <a href="{{ route('teams.show', $team->slug) }}" class="text-sm text-blue-500 hover:underline">&larr; Kembali ke Workspace</a>
                </div>

                <form action="{{ route('teams.tasks.update', [$team->id, $task->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Task</label>
                        <input type="text" name="title" value="{{ old('title', $task->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="todo" {{ (old('status', $task->status) == 'todo') ? 'selected' : '' }}>TODO</option>
                                <option value="in_progress" {{ (old('status', $task->status) == 'in_progress') ? 'selected' : '' }}>IN PROGRESS</option>
                                <option value="done" {{ (old('status', $task->status) == 'done') ? 'selected' : '' }}>DONE</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                            <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="low" {{ (old('priority', $task->priority) == 'low') ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ (old('priority', $task->priority) == 'medium') ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ (old('priority', $task->priority) == 'high') ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tugaskan Ke (Assignee)</label>
                            <select name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Bebas / Unassigned --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ (old('assigned_to', $task->assigned_to) == $member->id) ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                            <input type="date" name="deadline_at" value="{{ old('deadline_at', $task->deadline_at ? \Carbon\Carbon::parse($task->deadline_at)->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>