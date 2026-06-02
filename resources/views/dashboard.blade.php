<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#37352f] leading-tight">
            {{ __('Dashboard ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Ucapan Selamat Datang -->
            <div class="bg-white overflow-hidden border border-gray-200 sm:rounded-lg shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-[#37352f] flex items-center gap-2">
                        Halo, {{ Auth::user()->name }}! 
                        <span class="iconify text-yellow-500" data-icon="lucide:hand"></span>
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Selamat datang kembali. Berikut adalah ringkasan pekerjaanmu saat ini.</p>
                </div>
            </div>

            <!-- Kartu Statistik (Revisi: Menghapus Total Task, sisa 3 kolom) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white border border-gray-200 sm:rounded-lg p-6 flex items-center justify-between shadow-[0_1px_3px_rgba(0,0,0,0.02)] transition-all hover:shadow-md">
                    <div>
                        <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider mb-1">Tugas Pending</p>
                        <p class="text-3xl font-bold text-[#37352f]">{{ $pendingTasks }}</p>
                    </div>
                    <div class="text-yellow-400 text-4xl opacity-50 flex items-center">
                        <span class="iconify" data-icon="lucide:clock"></span>
                    </div>
                </div>
                
                <!-- KOTAK TASK TERLAMBAT -->
                <div class="bg-red-50/30 border border-red-100 sm:rounded-lg p-6 flex items-center justify-between shadow-[0_1px_3px_rgba(0,0,0,0.02)] transition-all hover:shadow-md">
                    <div>
                        <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Task Terlambat</p>
                        <p class="text-3xl font-bold text-red-600">{{ $overdueTasks }}</p>
                    </div>
                    <div class="text-red-400 text-4xl opacity-50 flex items-center">
                        <span class="iconify" data-icon="lucide:alert-triangle"></span>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 sm:rounded-lg p-6 flex items-center justify-between shadow-[0_1px_3px_rgba(0,0,0,0.02)] transition-all hover:shadow-md">
                    <div>
                        <p class="text-xs font-bold text-green-600 uppercase tracking-wider mb-1">Tugas Selesai</p>
                        <p class="text-3xl font-bold text-[#37352f]">{{ $completedTasks }}</p>
                    </div>
                    <div class="text-green-400 text-4xl opacity-50 flex items-center">
                        <span class="iconify" data-icon="lucide:check-circle-2"></span>
                    </div>
                </div>
            </div>

            <!-- Konten Utama: Workspace (Kiri) & Task (Kanan) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri: Daftar Workspace (Porsi: 1/3) -->
                <div class="bg-white border border-gray-200 sm:rounded-lg p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)] self-start lg:col-span-1">
                    <h3 class="text-lg font-bold text-[#37352f] border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <span class="iconify text-gray-500" data-icon="lucide:layers" data-width="20"></span>
                        Workspacemu
                    </h3>
                    
                    @if($myWorkspaces->isEmpty())
                        <p class="text-sm text-gray-500 text-center py-4">Kamu belum bergabung dengan workspace manapun.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($myWorkspaces as $workspace)
                                <li>
                                    <a href="{{ route('teams.show', $workspace->slug) }}" class="block p-3 rounded-lg border border-gray-100 hover:border-[#0056b3] hover:shadow-sm transition-all group bg-gray-50/50">
                                        <div class="flex justify-between items-center">
                                            <h4 class="font-bold text-[#37352f] group-hover:text-[#0056b3] transition-colors">{{ $workspace->name }}</h4>
                                            <span class="text-gray-300 group-hover:text-[#0056b3]">
                                                <span class="iconify" data-icon="lucide:chevron-right"></span>
                                            </span>
                                        </div>
                                        <span class="text-[10px] font-medium text-gray-500 bg-white border border-gray-200 px-2 py-0.5 rounded mt-2 inline-flex items-center gap-1 shadow-sm">
                                            @if($workspace->owner_id === Auth::id())
                                                <span class="iconify text-yellow-500" data-icon="lucide:crown" data-width="12"></span> Owner
                                            @else
                                                <span class="iconify text-gray-400" data-icon="lucide:users" data-width="12"></span> Member
                                            @endif
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        
                        <!-- Tombol Buat Baru -->
                        <div class="mt-5 pt-4 border-t border-gray-100">
                            <a href="{{ route('teams.create') }}" class="flex items-center justify-center gap-2 w-full bg-[#37352f] hover:bg-[#2f2d27] text-white text-xs font-semibold py-2.5 rounded-md transition-colors shadow-sm">
                                <span class="iconify" data-icon="lucide:plus-circle"></span> Buat Workspace
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Kolom Kanan: Daftar Tugas (Porsi lebih lebar: 2/3) -->
                <div class="lg:col-span-2 bg-white border border-gray-200 sm:rounded-lg p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                    <h3 class="text-lg font-bold text-[#37352f] border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <span class="iconify text-gray-500" data-icon="lucide:layout-list" data-width="20"></span> 
                        Tugas Saya (My Pending Tasks)
                    </h3>
                    
                    @if($myTasks->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500 text-sm">Mantap! Tidak ada tugas yang tertunda. Waktunya bersantai!</p>
                        </div>
                    @else
                        <ul class="divide-y divide-gray-100">
                            @foreach($myTasks as $task)
                                <li class="py-4 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-gray-50 rounded-md px-3 transition-colors border border-transparent hover:border-gray-100">
                                    <div class="mb-2 sm:mb-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[10px] font-mono bg-white border border-gray-200 text-gray-600 px-1.5 py-0.5 rounded shadow-sm">{{ $task->code }}</span>
                                            <span class="text-[10px] font-bold text-[#0056b3] uppercase tracking-wider">{{ $task->team->name ?? 'Unknown Team' }}</span>
                                        </div>
                                        <h4 class="font-bold text-[#37352f]">{{ $task->title }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase 
                                                {{ $task->priority === 'high' ? 'bg-red-50 text-red-600 border border-red-100' : ($task->priority === 'medium' ? 'bg-yellow-50 text-yellow-600 border border-yellow-100' : 'bg-green-50 text-green-600 border border-green-100') }}">
                                                {{ $task->priority }}
                                            </span>
                                            <span class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider
                                                {{ $task->status === 'in_progress' ? 'text-yellow-600' : '' }}">
                                                [{{ str_replace('_', ' ', strtoupper($task->status)) }}]
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2">
                                        @if($task->deadline_at)
                                            <div class="text-xs text-right">
                                                <span class="block text-gray-400 uppercase tracking-wider text-[10px] font-bold">Tenggat Waktu</span>
                                                <span class="font-semibold flex items-center justify-end gap-1 {{ \Carbon\Carbon::parse($task->deadline_at)->isPast() ? 'text-red-500' : 'text-[#37352f]' }}">
                                                    <span class="iconify" data-icon="lucide:calendar-clock" data-width="12"></span>
                                                    {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M Y') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Tanpa tenggat</span>
                                        @endif
                                        
                                        @if($task->team)
                                            <a href="{{ route('teams.show', $task->team->slug) }}" class="flex items-center gap-1 text-[10px] bg-white border border-gray-300 hover:bg-gray-50 text-[#37352f] font-bold py-1 px-3 rounded shadow-sm transition-all">
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
    
    <!-- Script Iconify dipanggil langsung di sini -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</x-app-layout>