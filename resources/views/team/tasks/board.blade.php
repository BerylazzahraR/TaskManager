<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kanban Board: {{ $team->name }}
            </h2>
            <a href="{{ route('teams.show', $team->slug) }}" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                &larr; Kembali ke List View
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            
            <div id="toast" class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300 opacity-0 pointer-events-none z-50">
                ✅ Status task berhasil diperbarui!
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                
                <div class="bg-gray-100 rounded-lg p-4 shadow-sm min-h-[500px] flex flex-col">
                    <h3 class="font-bold text-gray-700 mb-4 border-b-4 border-gray-400 pb-2">📋 TODO ({{ $todoTasks->count() }})</h3>
                    <div id="todo" class="kanban-column flex-1 space-y-3" data-status="todo">
                        @foreach($todoTasks as $task)
                            @include('team.tasks._kanban_card', ['task' => $task])
                        @endforeach
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-4 shadow-sm min-h-[500px] flex flex-col">
                    <h3 class="font-bold text-blue-800 mb-4 border-b-4 border-yellow-400 pb-2">⏳ IN PROGRESS ({{ $inProgressTasks->count() }})</h3>
                    <div id="in_progress" class="kanban-column flex-1 space-y-3" data-status="in_progress">
                        @foreach($inProgressTasks as $task)
                            @include('team.tasks._kanban_card', ['task' => $task])
                        @endforeach
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 shadow-sm min-h-[500px] flex flex-col">
                    <h3 class="font-bold text-green-800 mb-4 border-b-4 border-green-400 pb-2">✅ DONE ({{ $doneTasks->count() }})</h3>
                    <div id="done" class="kanban-column flex-1 space-y-3" data-status="done">
                        @foreach($doneTasks as $task)
                            @include('team.tasks._kanban_card', ['task' => $task])
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const columns = document.querySelectorAll('.kanban-column');
            const csrfToken = '{{ csrf_token() }}';
            const teamId = '{{ $team->id }}';

            columns.forEach(column => {
                new Sortable(column, {
                    group: 'shared', // Mengizinkan drag antar kolom
                    animation: 150,
                    ghostClass: 'opacity-50', // Efek transparan saat di drag
                    
                    // Event saat kartu selesai dilepas (Drop)
                    onEnd: function (evt) {
                        const itemEl = evt.item;  // Element HTML kartu task
                        const newColumn = evt.to; // Kolom tujuan
                        
                        const taskId = itemEl.getAttribute('data-task-id');
                        const newStatus = newColumn.getAttribute('data-status');
                        const oldStatus = evt.from.getAttribute('data-status');

                        // Kalau dipindah ke kolom yang berbeda, tembak API Update
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
                                    // Update styling label secara dinamis
                                    updateCardStyle(itemEl, newStatus);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    },
                });
            });

            // Fungsi memunculkan notifikasi sukses
            function showToast() {
                const toast = document.getElementById('toast');
                toast.classList.remove('opacity-0');
                setTimeout(() => { toast.classList.add('opacity-0'); }, 3000);
            }

            // Fungsi ngubah warna badge status (Opsional)
            function updateCardStyle(card, status) {
                // Hanya visual update jika diperlukan
            }
        });
    </script>
</x-app-layout>