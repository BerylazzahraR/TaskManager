<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard for HIMATIF') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Ucapan Selamat Datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-sm text-gray-500">Selamat datang kembali. Berikut adalah ringkasan pekerjaanmu saat ini.</p>
                </div>
            </div>

            <!-- Kartu Statistik -->
            <!-- Kartu Statistik -->
            <!-- Ubah grid dari md:grid-cols-3 jadi md:grid-cols-4 -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-b-4 border-gray-400">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Tugasmu</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalTasks }}</p>
                    </div>
                    <div class="text-gray-300 text-2xl">📋</div>
                </div>
                
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-b-4 border-yellow-400">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Tugas Pending</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendingTasks }}</p>
                    </div>
                    <div class="text-yellow-200 text-2xl">⏳</div>
                </div>
                
                <!-- INI KOTAK BARU BUAT TASK TERLAMBAT -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-b-4 border-red-500">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Task Terlambat</p>
                        <p class="text-3xl font-bold text-red-600">{{ $overdueTasks }}</p>
                    </div>
                    <div class="text-red-200 text-2xl">🚨</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center justify-between border-b-4 border-green-400">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Tugas Selesai</p>
                        <p class="text-3xl font-bold text-green-600">{{ $completedTasks }}</p>
                    </div>
                    <div class="text-green-200 text-2xl">✅</div>
                </div>
            </div>

            <!-- Konten Utama: Task & Workspace -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri: Daftar Tugas (Porsi lebih lebar: 2/3) -->
                <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold border-b pb-2 mb-4">⏳ Tugas Saya (My Pending Tasks)</h3>
                    
                    @if($myTasks->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500 text-sm">Mantap! Tidak ada tugas yang tertunda. Waktunya bersantai!</p>
                        </div>
                    @else
                        <ul class="divide-y divide-gray-100">
                            @foreach($myTasks as $task)
                                <li class="py-4 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-gray-50 rounded px-2 transition-colors">
                                    <div class="mb-2 sm:mb-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[10px] font-mono bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded">{{ $task->code }}</span>
                                            <!-- Menampilkan nama Workspace asal task -->
                                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">{{ $task->team->name ?? 'Unknown Team' }}</span>
                                        </div>
                                        <h4 class="font-bold text-gray-800">{{ $task->title }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase 
                                                {{ $task->priority === 'high' ? 'bg-red-100 text-red-700' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                                {{ $task->priority }}
                                            </span>
                                            <span class="text-xs text-gray-500 font-semibold
                                                {{ $task->status === 'in_progress' ? 'text-yellow-600' : '' }}">
                                                [{{ str_replace('_', ' ', strtoupper($task->status)) }}]
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2">
                                        @if($task->deadline_at)
                                            <div class="text-xs text-right">
                                                <span class="block text-gray-500">Tenggat Waktu:</span>
                                                <span class="font-bold {{ \Carbon\Carbon::parse($task->deadline_at)->isPast() ? 'text-red-500' : 'text-gray-700' }}">
                                                    {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M Y') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Tanpa tenggat</span>
                                        @endif
                                        
                                        <!-- Tombol langsung ke Workspace task tersebut -->
                                        @if($task->team)
                                            <a href="{{ route('teams.show', $task->team->slug) }}" class="text-[10px] bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold py-1 px-2 rounded">
                                                Lihat Task &rarr;
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Kolom Kanan: Daftar Workspace (Porsi: 1/3) -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 self-start">
                    <h3 class="text-lg font-bold border-b pb-2 mb-4">🚀 Workspacemu</h3>
                    
                    @if($myWorkspaces->isEmpty())
                        <p class="text-sm text-gray-500 text-center py-4">Kamu belum bergabung dengan workspace manapun.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($myWorkspaces as $workspace)
                                <li>
                                    <a href="{{ route('teams.show', $workspace->slug) }}" class="block p-3 rounded-lg border border-gray-200 hover:border-blue-400 hover:shadow-sm transition-all group">
                                        <div class="flex justify-between items-center">
                                            <h4 class="font-bold text-gray-800 group-hover:text-blue-600">{{ $workspace->name }}</h4>
                                            <span class="text-xs text-gray-400">&rarr;</span>
                                        </div>
                                        <span class="text-[10px] text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded mt-1 inline-block">
                                            {{ $workspace->owner_id === Auth::id() ? 'Owner' : 'Member' }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        
                        <!-- Tombol Buat Baru dari Dashboard -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('teams.create') }}" class="block w-full text-center bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold py-2 px-4 rounded">
                                + Buat Workspace Baru
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>