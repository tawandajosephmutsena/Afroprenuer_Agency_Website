<div class="space-y-4" x-data="{ 
    draggedTask: null,
    isDragging: false,
    dropTarget: null
}">
    @foreach ($getTaskTree() as $task)
        <div class="task-item border rounded-lg p-4 bg-white dark:bg-gray-800"
             draggable="true"
             data-task-id="{{ $task->id }}"
             @dragstart="
                draggedTask = $event.target.dataset.taskId;
                isDragging = true;
                $event.dataTransfer.setData('text/plain', draggedTask);
             "
             @dragend="isDragging = false"
             @dragover.prevent="dropTarget = $event.target.closest('.task-item').dataset.taskId"
             @drop.prevent="
                $wire.handleTaskMove(draggedTask, dropTarget, {{ $loop->index }});
                dropTarget = null;
                isDragging = false;
             "
        > 
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    @if ($task->subtasks->count() > 0)
                        <button wire:click="toggleExpand({{ $task->id }})" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4 transform {{ $expanded[$task->id] ?? false ? 'rotate-90' : '' }}" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @endif
                    <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-2 py-1 text-sm rounded-full
                        @switch($task->priority)
                            @case('urgent') bg-red-100 text-red-800 @break
                            @case('high') bg-orange-100 text-orange-800 @break
                            @case('medium') bg-blue-100 text-blue-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch
                    ">
                        {{ ucfirst($task->priority) }}
                    </span>
                    <span class="px-2 py-1 text-sm rounded-full 
                        @switch($task->status)
                            @case('done') bg-green-100 text-green-800 @break
                            @case('in_progress') bg-yellow-100 text-yellow-800 @break
                            @case('todo') bg-gray-100 text-gray-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch
                    ">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">{{ $task->description }}</p>
            
            @if ($task->due_date)
                <div class="mt-2 text-sm text-gray-500">
                    Due: {{ $task->due_date->format('M d, Y') }}
                </div>
            @endif

            @if ($task->subtasks->isNotEmpty() && ($expanded[$task->id] ?? false))
                <div class="mt-4 pl-4 border-l-2 border-gray-200">
                    <livewire:nested-tasks :tasks="$task->subtasks" :key="'subtasks-'.$task->id" />
                </div>
            @endif
        </div>
    @endforeach
</div>