<x-filament::page>
    <div class="mb-6">
        {{ $this->form }}
    </div>

    <div
        x-data="kanbanBoard()"
        class="flex space-x-4 overflow-x-auto pb-4"
    >
        @php
            $statuses = [
                'backlog' => 'gray',
                'todo' => 'blue',
                'in_progress' => 'yellow',
                'review' => 'purple',
                'done' => 'green'
            ];
        @endphp

        @foreach($statuses as $status => $color)
            <div class="flex-1 min-w-[300px]">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium">
                            <span class="inline-block w-3 h-3 rounded-full bg-{{ $color }}-500 mr-2"></span>
                            {{ Str::title(str_replace('_', ' ', $status)) }}
                            <span class="text-gray-400 text-sm ml-1">
                                ({{ $tasks->get($status, collect())->count() }})
                            </span>
                        </h3>
                    </div>

                    <div
                        x-on:dragover.prevent
                        x-on:drop="dropTask($event, '{{ $status }}')"
                        class="p-3 min-h-[calc(100vh-20rem)] bg-gray-50 dark:bg-gray-900 rounded-b-lg"
                    >
                        @foreach($tasks->get($status, collect()) as $task)
                            <div
                                id="task-{{ $task->id }}"
                                draggable="true"
                                x-on:dragstart="startDragging($event, {{ $task->id }})"
                                class="bg-white dark:bg-gray-800 p-3 mb-2 rounded-lg shadow-sm border-2 border-transparent hover:border-primary-500 cursor-move"
                            >
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-500">#{{ $task->id }}</span>
                                    <span class="px-2 py-1 text-xs rounded-full" style="background-color: {{ $task->priority_color }}">
                                        {{ $task->priority }}
                                    </span>
                                </div>

                                <h4 class="text-sm font-medium mb-2">{{ $task->title }}</h4>

                                @if($task->description)
                                    <p class="text-xs text-gray-500 mb-2">
                                        {{ Str::limit($task->description, 100) }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        @if($task->due_date)
                                            <span class="text-xs text-gray-500">
                                                📅 {{ $task->due_date->format('M d') }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($task->assignee)
                                        <div class="flex items-center">
                                            <img
                                                src="{{ $task->assignee->avatar_url }}"
                                                alt="{{ $task->assignee->name }}"
                                                class="w-6 h-6 rounded-full"
                                            >
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
    <script>
    function kanbanBoard() {
        return {
            draggingTaskId: null,

            startDragging(event, taskId) {
                this.draggingTaskId = taskId;
                event.dataTransfer.effectAllowed = 'move';
            },

            dropTask(event, newStatus) {
                if (!this.draggingTaskId) return;

                // Prevent the same status drops
                const taskElement = document.getElementById(`task-${this.draggingTaskId}`);
                const oldStatus = taskElement.parentElement.dataset.status;

                if (oldStatus === newStatus) return;

                // Emit Livewire event
                Livewire.emit('taskMoved', this.draggingTaskId, newStatus);

                this.draggingTaskId = null;
            }
        }
    }
    </script>
    @endpush
</x-filament::page>
