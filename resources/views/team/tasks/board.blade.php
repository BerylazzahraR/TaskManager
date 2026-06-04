<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-[#0056b3] dark:hover:text-blue-400 transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-[#37352f] dark:text-gray-200 transition-colors">Kanban Board</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[98%] mx-auto sm:px-6 lg:px-8">
            
            <div id="toast" class="fixed bottom-5 right-5 bg-[#37352f] dark:bg-gray-800 text-white dark:text-gray-100 px-4 py-3 rounded-md shadow-lg transition-opacity duration-300 opacity-0 pointer-events-none z-50 flex items-center gap-2 text-sm font-medium border border-gray-700 dark:border-gray-600">
                <span class="iconify text-green-400" data-icon="lucide:check-circle" data-width="18"></span> Status task berhasil diperbarui!
            </div>

            <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-gray-200 dark:border-gray-700 pb-4 transition-colors">
                <div>
                    <h2 class="text-xl font-bold text-[#37352f] dark:text-gray-100 flex items-center gap-2 transition-colors">
                        <span class="iconify text-gray-500 dark:text-gray-400" data-icon="lucide:kanban-square"></span>
                        Kanban Board
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 transition-colors">Geser kartu untuk mengubah status tugas di workspace <strong>{{ $team->name }}</strong>.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('teams.show', $team->slug) }}" class="bg-white dark:bg-[#242424] border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-[#37352f] dark:text-gray-200 text-xs font-bold py-2 px-3 rounded-md flex items-center gap-1 shadow-sm transition-all">
                        <span class="iconify" data-icon="lucide:list-todo" data-width="16"></span> List View
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                
                <div class="bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col h-[75vh] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-gray-700 pb-3 transition-colors">
                        <h3 class="font-bold text-gray-600 dark:text-gray-300 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span> TODO
                        </h3>
                        <span class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $todoTasks->count() }}</span>
                    </div>
                    <div id="todo" class="kanban-column flex-1 overflow-y-auto pr-2 pb-10 space-y-3" data-status="todo">
                        @foreach($todoTasks as $task) @include('team.tasks._kanban_card', ['task' => $task]) @endforeach
                    </div>
                </div>

                <div class="bg-blue-50/40 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/30 rounded-lg p-4 flex flex-col h-[75vh] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4 border-b border-blue-100 dark:border-blue-800/30 pb-3 transition-colors">
                        <h3 class="font-bold text-[#0056b3] dark:text-blue-400 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-[#0056b3] dark:bg-blue-400"></span> IN PROGRESS
                        </h3>
                        <span class="bg-blue-100 dark:bg-blue-900/50 text-[#0056b3] dark:text-blue-300 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $inProgressTasks->count() }}</span>
                    </div>
                    <div id="in_progress" class="kanban-column flex-1 overflow-y-auto pr-2 pb-10 space-y-3" data-status="in_progress">
                        @foreach($inProgressTasks as $task) @include('team.tasks._kanban_card', ['task' => $task]) @endforeach
                    </div>
                </div>

                <div class="bg-green-50/40 dark:bg-green-900/10 border border-green-100 dark:border-green-800/30 rounded-lg p-4 flex flex-col h-[75vh] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4 border-b border-green-100 dark:border-green-800/30 pb-3 transition-colors">
                        <h3 class="font-bold text-green-700 dark:text-green-400 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-green-500 dark:bg-green-400"></span> DONE
                        </h3>
                        <span class="bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $doneTasks->count() }}</span>
                    </div>
                    <div id="done" class="kanban-column flex-1 overflow-y-auto pr-2 pb-10 space-y-3" data-status="done">
                        @foreach($doneTasks as $task) @include('team.tasks._kanban_card', ['task' => $task]) @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const columns = document.querySelectorAll('.kanban-column');
            const csrfToken = '{{ csrf_token() }}';
            const teamId = '{{ $team->id }}';

            columns.forEach(column => {
                new Sortable(column, {
                    group: 'shared', // Mengizinkan drag antar kolom
                    animation: 150,
                    ghostClass: 'opacity-40', // Efek pas ditarik
                    
                    onEnd: function (evt) {
                        const itemEl = evt.item;
                        const newColumn = evt.to;
                        
                        const taskId = itemEl.getAttribute('data-task-id');
                        const newStatus = newColumn.getAttribute('data-status');
                        const oldStatus = evt.from.getAttribute('data-status');

                        // Kalau dipindah ke kolom yang berbeda, update ke database
                        if (newStatus !== oldStatus) {
                            fetch(`/teams/${teamId}/tasks/${taskId}/status`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ status: newStatus })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if(data.success) {
                                    showToast();
                                    updateCounters(); // Update angka total task di atas kolom
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    },
                });
            });

            // Fungsi nampilin notifikasi toast
            function showToast() {
                const toast = document.getElementById('toast');
                toast.classList.remove('opacity-0');
                setTimeout(() => { toast.classList.add('opacity-0'); }, 3000);
            }

            // Fungsi ngitung otomatis angka di atas kolom
            function updateCounters() {
                ['todo', 'in_progress', 'done'].forEach(status => {
                    const col = document.getElementById(status);
                    if(col) {
                        const count = col.children.length;
                        const badge = col.previousElementSibling.querySelector('span:last-child');
                        if(badge) badge.innerText = count;
                    }
                });
            }
        });
    </script>
</x-app-layout>