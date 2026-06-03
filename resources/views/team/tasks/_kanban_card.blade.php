<div data-task-id="{{ $task->id }}" class="bg-white dark:bg-[#2a2a2a] border border-gray-200 dark:border-gray-700 shadow-[0_1px_2px_rgba(0,0,0,0.04)] rounded-md p-4 mb-3 cursor-grab active:cursor-grabbing hover:border-[#0056b3] dark:hover:border-blue-500 transition-colors group relative">
    <div class="flex justify-between items-start mb-2">
        <span class="text-[10px] font-mono bg-gray-50 dark:bg-[#1a1a1a] border border-gray-100 dark:border-gray-600 text-gray-500 dark:text-gray-400 px-1.5 py-0.5 rounded shadow-sm">{{ $task->code }}</span>
        <a href="{{ route('teams.tasks.show', [$team->id, $task->id]) }}" class="text-gray-400 dark:text-gray-500 hover:text-[#0056b3] dark:hover:text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity" title="Lihat Detail">
            <span class="iconify" data-icon="lucide:external-link" data-width="14"></span>
        </a>
    </div>
    <h4 class="font-semibold text-[#37352f] dark:text-gray-200 text-sm mb-3 pr-4">{{ $task->title }}</h4>
    <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-50 dark:border-gray-700/50">
        <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider
            {{ $task->priority === 'high' ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50' : ($task->priority === 'medium' ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 border border-yellow-100 dark:border-yellow-800/50' : 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 border border-green-100 dark:border-green-800/50') }}">
            {{ $task->priority }}
        </span>
        <span class="flex items-center gap-1 text-[11px] text-gray-500 dark:text-gray-400 font-medium">
            <span class="iconify" data-icon="lucide:user" data-width="12"></span>
            {{ $task->assignee->name ?? 'Unassigned' }}
        </span>
    </div>
</div>