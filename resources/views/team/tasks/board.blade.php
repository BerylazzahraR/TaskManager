<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <a href="{{ route('teams.show', $team->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ $team->name }}</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-slate-800 dark:text-slate-200 transition-colors">Kanban Board</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[98%] mx-auto sm:px-6 lg:px-8">
            
            <!-- Toast Notification -->
            <div id="toast" class="fixed bottom-5 right-5 bg-slate-800 dark:bg-slate-700 text-white px-4 py-3 rounded-xl shadow-lg transition-opacity duration-300 opacity-0 pointer-events-none z-50 flex items-center gap-2 text-sm font-bold border border-slate-700 dark:border-slate-600">
                <span class="iconify text-emerald-400" data-icon="lucide:check-circle" data-width="18"></span> Status task diperbarui!
            </div>

            <!-- Header Kanban -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4 border-b border-slate-200 dark:border-slate-700/50 pb-4 transition-colors">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2 transition-colors">
                        <span class="iconify text-indigo-500" data-icon="lucide:kanban-square"></span>
                        Kanban Board
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 transition-colors">Geser kartu untuk mengubah status tugas di workspace <strong>{{ $team->name }}</strong>.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('teams.show', $team->slug) }}" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs font-bold py-2 px-4 rounded-lg flex items-center gap-2 shadow-sm transition-all">
                        <span class="iconify" data-icon="lucide:list-todo" data-width="16"></span> List View
                    </a>
                </div>
            </div>

            <!-- KANBAN COLUMNS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                
                <!-- KOLOM 1: TODO -->
                <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl p-4 flex flex-col h-[75vh] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4 border-b border-slate-200 dark:border-slate-700/50 pb-3 transition-colors">
                        <h3 class="font-bold text-slate-600 dark:text-slate-300 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span> TODO
                        </h3>
                        <span class="bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $todoTasks->count() }}</span>
                    </div>
                    <div id="todo" class="kanban-column flex-1 overflow-y-auto pr-2 pb-10 space-y-3" data-status="todo">
                        @foreach($todoTasks as $task) @include('team.tasks._kanban_card', ['task' => $task]) @endforeach
                    </div>
                </div>

                <!-- KOLOM 2: IN PROGRESS -->
                <div class="bg-indigo-50/50 dark:bg-indigo-500/5 border border-indigo-100 dark:border-indigo-500/10 rounded-2xl p-4 flex flex-col h-[75vh] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4 border-b border-indigo-100 dark:border-indigo-500/10 pb-3 transition-colors">
                        <h3 class="font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 dark:bg-indigo-400"></span> IN PROGRESS
                        </h3>
                        <span class="bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $inProgressTasks->count() }}</span>
                    </div>
                    <div id="in_progress" class="kanban-column flex-1 overflow-y-auto pr-2 pb-10 space-y-3" data-status="in_progress">
                        @foreach($inProgressTasks as $task) @include('team.tasks._kanban_card', ['task' => $task]) @endforeach
                    </div>
                </div>

                <!-- KOLOM 3: DONE -->
                <div class="bg-emerald-50/50 dark:bg-emerald-500/5 border border-emerald-100 dark:border-emerald-500/10 rounded-2xl p-4 flex flex-col h-[75vh] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4 border-b border-emerald-100 dark:border-emerald-500/10 pb-3 transition-colors">
                        <h3 class="font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400"></span> DONE
                        </h3>
                        <span class="bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full">{{ $doneTasks->count() }}</span>
                    </div>
                    <div id="done" class="kanban-column flex-1 overflow-y-auto pr-2 pb-10 space-y-3" data-status="done">
                        @foreach($doneTasks as $task) @include('team.tasks._kanban_card', ['task' => $task]) @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- LIBRARY ICON & SORTABLE JS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    
    <!-- SCRIPT LOGIKA KANBAN (DRAG & DROP) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const columns = document.querySelectorAll('.kanban-column');
            const csrfToken = '{{ csrf_token() }}';
            const teamId = '{{ $team->id }}';

            columns.forEach(column => {
                new Sortable(column, {
                    group: 'shared',
                    animation: 150,
                    ghostClass: 'opacity-40', // Efek transparan pas ditarik
                    dragClass: 'shadow-2xl',
                    
                    onEnd: function (evt) {
                        const itemEl = evt.item;
                        const newColumn = evt.to;
                        
                        const taskId = itemEl.getAttribute('data-task-id');
                        const newStatus = newColumn.getAttribute('data-status');
                        const oldStatus = evt.from.getAttribute('data-status');

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
                                    updateCounters();
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    },
                });
            });

            function showToast() {
                const toast = document.getElementById('toast');
                toast.classList.remove('opacity-0', 'translate-y-4');
                setTimeout(() => { toast.classList.add('opacity-0', 'translate-y-4'); }, 3000);
            }

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