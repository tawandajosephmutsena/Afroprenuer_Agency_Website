<?php

namespace App\Filament\Components;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component as LivewireComponent;

class NestedTasks extends LivewireComponent
{
    public Collection $tasks;
    public $expanded = [];
    public $draggedTaskId = null;

    protected $listeners = [
        'taskUpdated' => '$refresh',
        'taskMoved' => 'handleTaskMove'
    ];

    public function mount($tasks = null)
    {
        // Ensure tasks is always a Collection, fallback to empty Collection if null.
        $this->tasks = $tasks ? collect($tasks) : new Collection();

        // Initialize all tasks as expanded
        foreach ($this->tasks as $task) {
            $this->expanded[$task->id] = true;
        }
    }

    public function toggleExpand($taskId)
    {
        $this->expanded[$taskId] = !($this->expanded[$taskId] ?? false);
    }

    public function getTaskTree($parentId = null): Collection
    {
        // Ensure we're working with a collection, and parent_id is handled correctly.
        return $this->tasks
            ->filter(fn($task) => $task->parent_id === $parentId)
            ->sortBy('order');
    }

    public function handleTaskMove($taskId, $newParentId, $newOrder)
    {
        // Ensure task is loaded correctly and prevent issues with collections.
        $task = Task::find($taskId);
        if (!$task) return;

        // Update task's parent and order.
        $task->update([
            'parent_id' => $newParentId ?: null,
            'order' => $newOrder
        ]);

        // Reorder the sibling tasks based on the new order.
        $siblings = Task::where('parent_id', $newParentId)
            ->where('id', '!=', $taskId)
            ->orderBy('order')
            ->get();

        $order = 0;
        foreach ($siblings as $sibling) {
            if ($order == $newOrder) $order++;
            $sibling->update(['order' => $order]);
            $order++;
        }

        // Emit taskMoved event to refresh the view or other components.
        $this->emit('taskMoved');
    }

    public function render(): View
    {
        return view('filament.components.nested-tasks', [
            'tasks' => $this->getTaskTree() // Ensure the task tree is passed correctly.
        ]);
    }
}