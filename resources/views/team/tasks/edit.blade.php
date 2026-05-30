<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task: {{ $task->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

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

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold border-b pb-2 mb-4">💬 Diskusi Tugas</h3>

                <div class="space-y-4 mb-6">
                    @forelse($task->comments as $comment)
                        <div class="flex gap-3 {{ $comment->user_id == Auth::id() ? 'flex-row-reverse' : '' }}">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white
                                {{ $comment->user_id == Auth::id() ? 'bg-blue-500' : 'bg-gray-500' }}">
                                {{ substr($comment->user->name, 0, 2) }}
                            </div>
                            
                            <div class="max-w-[80%] {{ $comment->user_id == Auth::id() ? 'text-right' : 'text-left' }}">
                                <div class="text-xs text-gray-500 mb-1">
                                    <span class="font-bold text-gray-800">{{ $comment->user->name }}</span> &bull; 
                                    {{ $comment->created_at->diffForHumans() }}
                                </div>
                                <div class="p-3 rounded-lg text-sm inline-block text-left
                                    {{ $comment->user_id == Auth::id() ? 'bg-blue-100 text-blue-900 rounded-tr-none' : 'bg-gray-100 text-gray-800 rounded-tl-none' }}">
                                    {!! nl2br(e($comment->body)) !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada diskusi. Jadilah yang pertama berkomentar!</p>
                    @endforelse
                </div>

                <form action="{{ route('teams.tasks.comments.store', [$team->id, $task->id]) }}" method="POST" class="mt-4 border-t pt-4">
                    @csrf
                    <div class="flex items-start gap-2">
                        <textarea name="body" rows="2" placeholder="Tulis komentar atau update progres di sini..." required class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow-sm text-sm h-full">
                            Kirim
                        </button>
                    </div>
                    @error('body') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                </form>
            </div>

        </div>
    </div>
</x-app-layout>