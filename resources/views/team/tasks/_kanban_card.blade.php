<div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/70 p-4 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] dark:shadow-none cursor-grab active:cursor-grabbing hover:border-indigo-300 dark:hover:border-indigo-500/50 transition-all group" data-task-id="{{ $task->id }}">
    
    <div class="flex justify-between items-start mb-3">
        <span class="text-[10px] font-mono bg-slate-50 dark:bg-slate-900 text-slate-500 dark:text-slate-400 px-2 py-1 rounded-md border border-slate-100 dark:border-slate-700">{{ $task->code }}</span>
        
        <span class="px-2 py-1 rounded-md text-[9px] font-bold uppercase tracking-wider
            {{ $task->priority === 'high' ? 'bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400' : ($task->priority === 'medium' ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400') }}">
            {{ $task->priority }}
        </span>
    </div>
    
    <h4 class="font-bold text-slate-800 dark:text-slate-100 text-sm mb-4 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-tight">{{ $task->title }}</h4>
    
    <div class="flex items-center justify-between mt-auto pt-3 border-t border-slate-100 dark:border-slate-700/50">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-indigo-50 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-[10px]" title="{{ $task->assignee->name ?? 'Unassigned' }}">
                {{ $task->assignee ? substr($task->assignee->name, 0, 1) : '?' }}
            </div>
            @if($task->comments->count() > 0)
                <span class="flex items-center gap-1 text-[10px] font-bold text-slate-400" title="{{ $task->comments->count() }} Komentar">
                    <span class="iconify" data-icon="lucide:message-square" data-width="12"></span> {{ $task->comments->count() }}
                </span>
            @endif
        </div>
        
        @if($task->deadline_at)
            <div class="flex items-center gap-1 text-[10px] font-bold {{ \Carbon\Carbon::parse($task->deadline_at)->isPast() && $task->status !== 'done' ? 'text-rose-500 dark:text-rose-400' : 'text-slate-400 dark:text-slate-500' }}">
                <span class="iconify" data-icon="lucide:calendar-clock" data-width="12"></span>
                {{ \Carbon\Carbon::parse($task->deadline_at)->format('d M') }}
            </div>
        @endif
    </div>
</div>