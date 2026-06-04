<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f] dark:text-gray-200 transition-colors">Detail Task: {{ $task->title }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-700 dark:text-green-400 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm transition-colors">
                    <span class="iconify" data-icon="lucide:check-circle" data-width="18"></span> {{ session('success') }}
                </div>
            @endif

            <!-- KARTU INFO DETAIL TASK -->
            <div class="bg-white dark:bg-[#242424] overflow-hidden border border-gray-200 dark:border-gray-700 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8 transition-colors duration-300">
                <div class="flex justify-between items-start mb-6 border-b border-gray-100 dark:border-gray-700 pb-4 transition-colors">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-mono bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 px-2 py-0.5 rounded shadow-sm transition-colors">{{ $task->title }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase transition-colors
                                {{ $task->priority === 'high' ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50' : ($task->priority === 'medium' ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 border border-yellow-100 dark:border-yellow-800/50' : 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 border border-green-100 dark:border-green-800/50') }}">
                                {{ $task->priority }}
                            </span>
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider transition-colors
                                {{ $task->status === 'in_progress' ? 'text-yellow-600 dark:text-yellow-500' : '' }}">
                                [{{ str_replace('_', ' ', strtoupper($task->status)) }}]
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#37352f] dark:text-gray-100 transition-colors">{{ $task->title }}</h3>
                    </div>
                    <a href="{{ route('teams.tasks.edit', [$team->id, $task->id]) }}" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-[#37352f] dark:text-gray-200 text-xs font-bold py-2 px-3 rounded-md flex items-center gap-1 transition-colors">
                        <span class="iconify" data-icon="lucide:edit-3"></span> Edit
                    </a>
                </div>

                <div class="mb-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi</h4>
                    <div class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-[#1a1a1a] p-4 rounded-md border border-gray-100 dark:border-gray-800 min-h-[60px] transition-colors">
                        {{ $task->description ?? 'Tidak ada deskripsi untuk tugas ini.' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Assignee</h4>
                        <p class="text-sm font-medium text-[#37352f] dark:text-gray-200 flex items-center gap-1.5 transition-colors">
                            <span class="iconify text-gray-400" data-icon="lucide:user" data-width="16"></span>
                            {{ $task->assignee->name ?? 'Unassigned' }}
                        </p>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tenggat Waktu</h4>
                        @if($task->deadline_at)
                            <p class="text-sm font-semibold flex items-center gap-1.5 transition-colors {{ \Carbon\Carbon::parse($task->deadline_at)->isPast() ? 'text-red-500 dark:text-red-400' : 'text-[#37352f] dark:text-gray-200' }}">
                                <span class="iconify" data-icon="lucide:calendar-clock" data-width="16"></span>
                                {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M Y') }}
                            </p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic transition-colors">Tanpa tenggat</p>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Terakhir Diedit</h4>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 flex items-center gap-1.5 transition-colors">
                            <span class="iconify text-gray-400" data-icon="lucide:history" data-width="16"></span>
                            {{ $task->updated_at ? $task->updated_at->diffForHumans() : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- KARTU DISKUSI / KOMENTAR -->
            <div class="bg-white dark:bg-[#242424] overflow-hidden border border-gray-200 dark:border-gray-700 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-8 transition-colors duration-300">
                <h3 class="text-lg font-bold text-[#37352f] dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3 mb-6 flex items-center gap-2 transition-colors">
                    <span class="iconify text-gray-500 dark:text-gray-400" data-icon="lucide:message-square"></span>
                    Diskusi Tugas
                </h3>

                <div class="space-y-5 mb-6">
                    @forelse($task->comments as $comment)
                        <div class="flex gap-3 {{ $comment->user_id == Auth::id() ? 'flex-row-reverse' : '' }}">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-sm transition-colors
                                {{ $comment->user_id == Auth::id() ? 'bg-[#0056b3] dark:bg-blue-600' : 'bg-gray-400 dark:bg-gray-600' }}">
                                {{ substr($comment->user->name, 0, 2) }}
                            </div>
                            <div class="max-w-[85%] {{ $comment->user_id == Auth::id() ? 'text-right' : 'text-left' }}">
                                <div class="text-[11px] text-gray-500 dark:text-gray-400 mb-1 flex items-center gap-1 transition-colors {{ $comment->user_id == Auth::id() ? 'justify-end' : '' }}">
                                    <span class="font-bold text-[#37352f] dark:text-gray-200">{{ $comment->user->name }}</span> 
                                    <span>&bull;</span> 
                                    <span class="flex items-center gap-0.5"><span class="iconify" data-icon="lucide:clock" data-width="10"></span> {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="px-4 py-2.5 rounded-lg text-sm inline-block text-left shadow-sm border transition-colors
                                    {{ $comment->user_id == Auth::id() ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800/30 text-[#37352f] dark:text-gray-200 rounded-tr-none' : 'bg-gray-50 dark:bg-gray-800 border-gray-100 dark:border-gray-700 text-[#37352f] dark:text-gray-200 rounded-tl-none' }}">
                                    {!! nl2br(e($comment->body)) !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <span class="iconify text-gray-300 dark:text-gray-600 mx-auto mb-2 transition-colors" data-icon="lucide:messages-square" data-width="32"></span>
                            <p class="text-sm text-gray-400">Belum ada diskusi. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endforelse
                </div>

                <form action="{{ route('teams.tasks.comments.store', [$team->id, $task->id]) }}" method="POST" class="mt-6 border-t border-gray-100 dark:border-gray-700 pt-6 transition-colors">
                    @csrf
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white bg-[#0056b3] dark:bg-blue-600 shadow-sm mt-1 transition-colors">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="flex-1 flex flex-col sm:flex-row gap-2">
                            <textarea name="body" rows="2" placeholder="Tulis komentar atau update progres di sini..." required 
                                class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#1a1a1a] dark:text-gray-200 shadow-sm focus:border-[#0056b3] focus:ring focus:ring-[#0056b3] focus:ring-opacity-20 text-sm transition-all resize-none"></textarea>
                            <button type="submit" class="bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white font-medium py-2 px-5 rounded-md shadow-sm text-sm h-full transition-all flex items-center justify-center gap-2 whitespace-nowrap self-end sm:self-stretch">
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