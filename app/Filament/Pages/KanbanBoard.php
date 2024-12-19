<?php

namespace App\Filament\Pages;

use App\Models\Task;
use App\Models\Project;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class KanbanBoard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-end-on-rectangle';
    protected static ?string $navigationGroup = "Project Manager";

    protected static ?string $navigationLabel = 'Kanban Board';
    protected static ?string $title = 'Kanban Board';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.kanban-board';

    public $tasks;
    public $selectedProject = null;

    protected $listeners = ['taskMoved' => 'updateTaskStatus'];

    public function mount(): void
    {
        $this->loadTasks();

        // Ensure all status columns exist even if empty
        $statuses = ['backlog', 'todo', 'in_progress', 'review', 'done'];
        foreach ($statuses as $status) {
            if (!isset($this->tasks[$status])) {
                $this->tasks[$status] = collect();
            }
        }
    }

    public function loadTasks(): void
{
    $query = Task::query()
        ->with(['assignee', 'project']); // Eager load relationships

    if ($this->selectedProject) {
        $query->where('project_id', $this->selectedProject);
    }

    $allTasks = $query->get();
    
    // Initialize all status columns
    $this->tasks = collect([
        'backlog' => collect(),
        'todo' => collect(),
        'in_progress' => collect(),
        'review' => collect(),
        'done' => collect(),
    ]);

    // Group tasks by status
    $groupedTasks = $allTasks->groupBy('status');
    
    // Merge grouped tasks into the initialized structure
    foreach ($groupedTasks as $status => $tasks) {
        if (isset($this->tasks[$status])) {
            $this->tasks[$status] = $tasks;
        }
    }
}

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('selectedProject')
                    ->label('Filter by Project')
                    ->options(Project::all()->pluck('name', 'id'))
                    ->placeholder('All Projects')
                    ->live()
                    ->afterStateUpdated(fn () => $this->loadTasks()),
            ]);
    }

    public function updateTaskStatus($taskId, $status)
{
    try {
        $task = Task::find($taskId);
        if ($task) {
            $task->update(['status' => $status]);
            Notification::make()
                ->title('Task updated successfully')
                ->success()
                ->send();
        }
    } catch (\Exception $e) {
        Notification::make()
            ->title('Error updating task')
            ->danger()
            ->send();
    }

    $this->loadTasks();
}
}