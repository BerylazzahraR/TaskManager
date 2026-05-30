<div data-task-id="{{ $task->id }}" class="bg-white p-3 rounded shadow-sm border border-gray-200 cursor-grab active:cursor-grabbing hover:shadow-md transition-shadow">
    <div class="flex justify-between items-start mb-2">
        <span class="text-[10px] font-mono bg-gray-100 text-gray-600 px-1 rounded">{{ $task->code }}</span>
        <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase 
            {{ $task->priority === 'high' ? 'bg-red-100 text-red-700' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
            {{ $task->priority }}
        </span>
    </div>
    <h4 class="font-bold text-gray-800 text-sm mb-2 leading-tight">{{ $task->title }}</h4>
    <div class="flex justify-between items-center text-xs mt-3 border-t pt-2 border-gray-50">
        <span class="text-gray-500 font-semibold">{{ $task->assignee->name ?? 'Unassigned' }}</span>
        <a href="{{ route('teams.tasks.edit', [$team->id, $task->id]) }}" class="text-blue-500 hover:underline">Detail</a>
    </div>
</div>