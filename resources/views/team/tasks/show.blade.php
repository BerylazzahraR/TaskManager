<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-[#0056b3] transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f]">Detail Task: {{ $task->code }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm">
                    <span class="iconify" data-icon="lucide:check-circle" data-width="18"></span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden border border-gray-200 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8">
                <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-mono bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded shadow-sm">{{ $task->code }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase 
                                {{ $task->priority === 'high' ? 'bg-red-50 text-red-600 border border-red-100' : ($task->priority === 'medium' ? 'bg-yellow-50 text-yellow-600 border border-yellow-100' : 'bg-green-50 text-green-600 border border-green-100') }}">
                                {{ $task->priority }}
                            </span>
                            <span class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider
                                {{ $task->status === 'in_progress' ? 'text-yellow-600' : '' }}">
                                [{{ str_replace('_', ' ', strtoupper($task->status)) }}]
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#37352f]">{{ $task->title }}</h3>
                    </div>
                    <a href="{{ route('teams.tasks.edit', [$team->id, $task->id]) }}" class="bg-gray-100 hover:bg-gray-200 text-[#37352f] text-xs font-bold py-2 px-3 rounded-md flex items-center gap-1 transition-colors">
                        <span class="iconify" data-icon="lucide:edit-3"></span> Edit
                    </a>
                </div>

                <div class="mb-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi</h4>
                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded-md border border-gray-100 min-h-[60px]">
                        {{ $task->description ?? 'Tidak ada deskripsi untuk tugas ini.' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Assignee</h4>
                        <p class="text-sm font-medium text-[#37352f] flex items-center gap-1.5">
                            <span class="iconify text-gray-400" data-icon="lucide:user" data-width="16"></span>
                            {{ $task->assignee->name ?? 'Unassigned' }}
                        </p>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tenggat Waktu</h4>
                        @if($task->deadline_at)
                            <p class="text-sm font-semibold flex items-center gap-1.5 {{ \Carbon\Carbon::parse($task->deadline_at)->isPast() ? 'text-red-500' : 'text-[#37352f]' }}">
                                <span class="iconify" data-icon="lucide:calendar-clock" data-width="16"></span>
                                {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M Y') }}
                            </p>
                        @else
                            <p class="text-sm text-gray-500 italic">Tanpa tenggat</p>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Terakhir Diedit</h4>
                        <p class="text-sm font-medium text-gray-600 flex items-center gap-1.5">
                            <span class="iconify text-gray-400" data-icon="lucide:history" data-width="16"></span>
                            {{ $task->updated_at ? $task->updated_at->diffForHumans() : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden border border-gray-200 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8">
                <h3 class="text-lg font-bold text-[#37352f] border-b border-gray-100 pb-3 mb-6 flex items-center gap-2">
                    <span class="iconify text-gray-500" data-icon="lucide:message-square"></span>
                    Diskusi Tugas
                </h3>

                <div class="space-y-5 mb-6">
                    @forelse($task->comments as $comment)
                        <div class="flex gap-3 {{ $comment->user_id == Auth::id() ? 'flex-row-reverse' : '' }}">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-sm
                                {{ $comment->user_id == Auth::id() ? 'bg-[#0056b3]' : 'bg-gray-400' }}">
                                {{ substr($comment->user->name, 0, 2) }}
                            </div>
                            <div class="max-w-[85%] {{ $comment->user_id == Auth::id() ? 'text-right' : 'text-left' }}">
                                <div class="text-[11px] text-gray-500 mb-1 flex items-center gap-1 {{ $comment->user_id == Auth::id() ? 'justify-end' : '' }}">
                                    <span class="font-bold text-[#37352f]">{{ $comment->user->name }}</span> 
                                    <span>&bull;</span> 
                                    <span class="flex items-center gap-0.5"><span class="iconify" data-icon="lucide:clock" data-width="10"></span> {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="px-4 py-2.5 rounded-lg text-sm inline-block text-left shadow-sm border
                                    {{ $comment->user_id == Auth::id() ? 'bg-blue-50 border-blue-100 text-[#37352f] rounded-tr-none' : 'bg-gray-50 border-gray-100 text-[#37352f] rounded-tl-none' }}">
                                    {!! nl2br(e($comment->body)) !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <span class="iconify text-gray-300 mx-auto mb-2" data-icon="lucide:messages-square" data-width="32"></span>
                            <p class="text-sm text-gray-400">Belum ada diskusi. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endforelse
                </div>

                <form action="{{ route('teams.tasks.comments.store', [$team->id, $task->id]) }}" method="POST" class="mt-6 border-t border-gray-100 pt-6">
                    @csrf
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white bg-[#0056b3] shadow-sm mt-1">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="flex-1 flex flex-col sm:flex-row gap-2">
                            <textarea name="body" rows="2" placeholder="Tulis komentar atau update progres di sini..." required 
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all resize-none"></textarea>
                            <button type="submit" class="bg-[#37352f] hover:bg-[#2f2d27] text-white font-medium py-2 px-5 rounded-md shadow-sm text-sm h-full transition-all flex items-center justify-center gap-2 whitespace-nowrap self-end sm:self-stretch">
                                <span class="iconify" data-icon="lucide:send" data-width="16"></span> Kirim
                            </button>
                        </div>
                    </div>
                    @error('body') <span class="text-red-500 text-xs block mt-1 ml-11">{{ $message }}</span> @enderror
                </form>
            </div>

        </div>
    </div>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</x-app-layout>