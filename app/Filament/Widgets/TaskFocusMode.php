<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Task;
use Livewire\Component;

class TaskFocusMode extends Widget
{
    protected static string $view = 'filament.widgets.task-focus-mode';

    protected static ?int $sort = 2;

    public $activeTask = null;
    public $breakdownSteps = [];
    public $currentStep = 0;
    public $focusModeActive = false;
    public $breakTimer = null;

    protected $listeners = ['taskSelected'];

    public function mount(): void
    {
        $this->breakTimer = auth()->user()->accessibilityPreferences->break_interval ?? 25;
    }

    public function taskSelected($taskId): void
    {
        $this->activeTask = Task::find($taskId);
        $this->breakdownSteps = $this->breakdownTaskIntoSteps();
        $this->currentStep = 0;
        $this->focusModeActive = false;
    }

    public function toggleFocusMode(): void
    {
        $this->focusModeActive = !$this->focusModeActive;

        if ($this->focusModeActive) {
            $this->startBreakTimer();
        } else {
            $this->stopBreakTimer();
        }
    }

    private function startBreakTimer(): void
    {
        $this->dispatch('start-break-timer', [
            'duration' => $this->breakTimer * 60,
        ]);
    }

    private function stopBreakTimer(): void
    {
        $this->dispatch('stop-break-timer');
    }
}
