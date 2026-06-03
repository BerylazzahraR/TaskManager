<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#37352f] dark:text-gray-200 leading-tight transition-colors duration-300">
            {{ __('Dashboard for HIMATIF') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-[#242424] overflow-hidden border border-gray-200 dark:border-gray-700 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)] transition-colors duration-300">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-[#37352f] dark:text-gray-100 flex items-center gap-2 transition-colors">
                        Halo, {{ Auth::user()->name }}! 
                        <span class="iconify text-yellow-500" data-icon="lucide:hand"></span>
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 transition-colors">Selamat datang kembali. Berikut adalah ringkasan pekerjaanmu saat ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-[#242424] border border-gray-200 dark:border-gray-700 sm:rounded-lg p-6 flex items-center justify-between shadow-[0_1px_3px_rgba(0,0,0,0.02)] transition-all hover:shadow-md duration-300">
                    <div>
                        <p class="text-xs font-bold text-yellow-600 dark:text-yellow-500 uppercase tracking-wider mb-1 transition-colors">Tugas Pending</p>
                        <p class="text-3xl font-bold text-[#37352f] dark:text-gray-100 transition-colors">{{ $pendingTasks }}</p>
                    </div>
                    <div class="text-yellow-400 dark:text-yellow-500/50 text-4xl opacity-50 flex items-center transition-colors">
                        <span class="iconify" data-icon="lucide:clock"></span>
                    </div>
                </div>
                
                <div class="bg-red-50/30 dark:bg-red-900/20 border border-red-100 dark:border-red-800/50 sm:rounded-lg p-6 flex items-center justify-between shadow-[0_1px_3px_rgba(0,0,0,0.02)] transition-all hover:shadow-md duration-300">
                    <div>
                        <p class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wider mb-1 transition-colors">Task Terlambat</p>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400 transition-colors">{{ $overdueTasks }}</p>
                    </div>
                    <div class="text-red-400 dark:text-red-500/50 text-4xl opacity-50 flex items-center transition-colors">
                        <span class="iconify" data-icon="lucide:alert-triangle"></span>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#242424] border border-gray-200 dark:border-gray-700 sm:rounded-lg p-6 flex items-center justify-between shadow-[0_1px_3px_rgba(0,0,0,0.02)] transition-all hover:shadow-md duration-300">
                    <div>
                        <p class="text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider mb-1 transition-colors">Tugas Selesai</p>
                        <p class="text-3xl font-bold text-[#37352f] dark:text-gray-100 transition-colors">{{ $completedTasks }}</p>
                    </div>
                    <div class="text-green-400 dark:text-green-500/50 text-4xl opacity-50 flex items-center transition-colors">
                        <span class="iconify" data-icon="lucide:check-circle-2"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="bg-white dark:bg-[#242424] border border-gray-200 dark:border-gray-700 sm:rounded-lg p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)] self-start lg:col-span-1 transition-colors duration-300">
                    <h3 class="text-lg font-bold text-[#37352f] dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3 mb-4 flex items-center gap-2 transition-colors">
                        <span class="iconify text-gray-500 dark:text-gray-400" data-icon="lucide:layers" data-width="20"></span>
                        Workspacemu
                    </h3>
                    
                    @if($myWorkspaces->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4 transition-colors">Kamu belum bergabung dengan workspace manapun.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($myWorkspaces as $workspace)
                                <li>
                                    <a href="{{ route('teams.show', $workspace->slug) }}" class="block p-3 rounded-lg border border-gray-100 dark:border-gray-700 hover:border-[#0056b3] dark:hover:border-blue-500 hover:shadow-sm transition-all group bg-gray-50/50 dark:bg-gray-800/50">
                                        <div class="flex justify-between items-center">
                                            <h4 class="font-bold text-[#37352f] dark:text-gray-200 group-hover:text-[#0056b3] dark:group-hover:text-blue-400 transition-colors">{{ $workspace->name }}</h4>
                                            <span class="text-gray-300 dark:text-gray-600 group-hover:text-[#0056b3] dark:group-hover:text-blue-400 transition-colors">
                                                <span class="iconify" data-icon="lucide:chevron-right"></span>
                                            </span>
                                        </div>
                                        <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 px-2 py-0.5 rounded mt-2 inline-flex items-center gap-1 shadow-sm transition-colors">
                                            @if($workspace->owner_id === Auth::id())
                                                <span class="iconify text-yellow-500" data-icon="lucide:crown" data-width="12"></span> Owner
                                            @else
                                                <span class="iconify text-gray-400 dark:text-gray-500" data-icon="lucide:users" data-width="12"></span> Member
                                            @endif
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        
                        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700 transition-colors">
                            <a href="{{ route('teams.create') }}" class="flex items-center justify-center gap-2 w-full bg-[#37352f] dark:bg-gray-700 hover:bg-[#2f2d27] dark:hover:bg-gray-600 text-white text-xs font-semibold py-2.5 rounded-md transition-colors shadow-sm">
                                <span class="iconify" data-icon="lucide:plus-circle"></span> Buat Workspace
                            </a>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-[#242424] border border-gray-200 dark:border-gray-700 sm:rounded-lg p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)] transition-colors duration-300">
                    <h3 class="text-lg font-bold text-[#37352f] dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3 mb-4 flex items-center gap-2 transition-colors">
                        <span class="iconify text-gray-500 dark:text-gray-400" data-icon="lucide:layout-list" data-width="20"></span> 
                        Tugas Saya (My Pending Tasks)
                    </h3>
                    
                    @if($myTasks->isEmpty())
                        <div class="text-center py-8 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-dashed border-gray-300 dark:border-gray-600 transition-colors">
                            <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors">Mantap! Tidak ada tugas yang tertunda. Waktunya bersantai!</p>
                        </div>
                    @else
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700 transition-colors">
                            @foreach($myTasks as $task)
                                <li class="py-4 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-md px-3 transition-colors border border-transparent hover:border-gray-100 dark:hover:border-gray-700">
                                    <div class="mb-2 sm:mb-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[10px] font-mono bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded shadow-sm transition-colors">{{ $task->code }}</span>
                                            <span class="text-[10px] font-bold text-[#0056b3] dark:text-blue-400 uppercase tracking-wider transition-colors">{{ $task->team->name ?? 'Unknown Team' }}</span>
                                        </div>
                                        <h4 class="font-bold text-[#37352f] dark:text-gray-200 transition-colors">{{ $task->title }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase transition-colors
                                                {{ $task->priority === 'high' ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50' : ($task->priority === 'medium' ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 border border-yellow-100 dark:border-yellow-800/50' : 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 border border-green-100 dark:border-green-800/50') }}">
                                                {{ $task->priority }}
                                            </span>
                                            <span class="text-[10px] text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider transition-colors
                                                {{ $task->status === 'in_progress' ? 'text-yellow-600 dark:text-yellow-500' : '' }}">
                                                [{{ str_replace('_', ' ', strtoupper($task->status)) }}]
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2">
                                        @if($task->deadline_at)
                                            <div class="text-xs text-right">
                                                <span class="block text-gray-400 dark:text-gray-500 uppercase tracking-wider text-[10px] font-bold transition-colors">Tenggat Waktu</span>
                                                <span class="font-semibold flex items-center justify-end gap-1 transition-colors {{ \Carbon\Carbon::parse($task->deadline_at)->isPast() ? 'text-red-500 dark:text-red-400' : 'text-[#37352f] dark:text-gray-300' }}">
                                                    <span class="iconify" data-icon="lucide:calendar-clock" data-width="12"></span>
                                                    {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M Y') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500 italic transition-colors">Tanpa tenggat</span>
                                        @endif
                                        
                                        @if($task->team)
                                            <a href="{{ route('teams.tasks.show', [$task->team->id, $task->id]) }}" class="flex items-center gap-1 text-[10px] bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-[#37352f] dark:text-gray-200 font-bold py-1 px-3 rounded shadow-sm transition-all">
                                                Lihat Task <span class="iconify" data-icon="lucide:arrow-right" data-width="12"></span>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>