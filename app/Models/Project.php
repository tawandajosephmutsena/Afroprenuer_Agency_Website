<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;




class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
        'client_id',
        'progress',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];



    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'notable_id')
            ->where('notable_type', Project::class);
    }

    public function calculateProgress(): float
    {
        // Implement your progress calculation logic
        return 0; // temporary return
    }
}