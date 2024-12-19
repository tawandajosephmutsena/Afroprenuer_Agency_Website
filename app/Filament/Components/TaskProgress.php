<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Field;

class TaskProgress extends Field
{
    protected string $view = 'filament.components.task-progress';

    public function getValue(): ?float
    {
        return parent::getValue() ?? 0;
    }
}