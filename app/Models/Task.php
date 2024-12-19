<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'project_id',
        'assignee_id',
        'completed_at',
        'progress',
        'parent_id',

    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',

    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function parent(): BelongsTo
    {
         return $this->belongsTo(Task::class, 'parent_id');
    }

    public function notes(): HasMany
{
    return $this->hasMany(Note::class);
}


    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'high' => '#ef4444',
            'medium' => '#f59e0b',
            'low' => '#10b981',
            default => '#6b7280',
        };
    }

     // Add this mutator to automatically set completed_at
     public function setStatusAttribute($value)
     {
         $this->attributes['status'] = $value;

         // When status is set to 'done', set completed_at
         if ($value === 'done') {
             $this->attributes['completed_at'] = Carbon::now();
         }
         // When status changes from 'done' to something else, clear completed_at
         elseif ($value !== 'done' && $this->completed_at) {
             $this->attributes['completed_at'] = null;
         }
     }
}