<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Task;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('client')->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function loadTasks(): void
    {
        $query = Task::with('assignee');

        if ($this->selectedProject) {
            $query->where('project_id', $this->selectedProject);
        }

        // Ensure tasks are loaded correctly into an associative array grouped by status.
        $this->tasks = $query->get()->groupBy('status')->map(function ($tasks) {
            return $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'priority' => $task->priority,
                    'priority_color' => $task->priority_color,
                    'due_date' => $task->due_date,
                    'assignee' => $task->assignee ? [
                        'name' => $task->assignee->name,
                        'avatar_url' => $task->assignee->avatar_url,
                    ] : null,
                ];
            })->toArray();
        })->toArray(); // Ensure this is an associative array.
    }
}