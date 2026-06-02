<div data-task-id="{{ $task->id }}" class="bg-white border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.04)] rounded-md p-4 mb-3 cursor-grab active:cursor-grabbing hover:border-[#0056b3] transition-colors group relative">
    <div class="flex justify-between items-start mb-2">
        <span class="text-[10px] font-mono bg-gray-50 border border-gray-100 text-gray-500 px-1.5 py-0.5 rounded shadow-sm">{{ $task->code }}</span>
        <a href="{{ route('teams.tasks.show', [$team->id, $task->id]) }}" class="text-gray-400 hover:text-[#0056b3] opacity-0 group-hover:opacity-100 transition-opacity" title="Lihat Detail">
            <span class="iconify" data-icon="lucide:external-link" data-width="14"></span>
        </a>
    </div>
    <h4 class="font-semibold text-[#37352f] text-sm mb-3 pr-4">{{ $task->title }}</h4>
    <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-50">
        <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider
            {{ $task->priority === 'high' ? 'bg-red-50 text-red-600 border border-red-100' : ($task->priority === 'medium' ? 'bg-yellow-50 text-yellow-600 border border-yellow-100' : 'bg-green-50 text-green-600 border border-green-100') }}">
            {{ $task->priority }}
        </span>
        <span class="flex items-center gap-1 text-[11px] text-gray-500 font-medium">
            <span class="iconify" data-icon="lucide:user" data-width="12"></span>
            {{ $task->assignee->name ?? 'Unassigned' }}
        </span>
    </div>
</div>