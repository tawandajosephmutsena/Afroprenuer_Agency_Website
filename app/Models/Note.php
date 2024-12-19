<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'notable_type',
        'notable_id',
        'task_id',
        'tags',
    ];





    public function task()
    {
        return $this->belongsTo(Task::class);
}

    public function notable(): MorphTo
    {
        return $this->morphTo();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
            ->withTimestamps();
    }

     // Helper method to sync tags by names
     public function syncTagsByNames(array $tagNames): void
     {
         $tags = collect($tagNames)->map(function ($tagName) {
             return Tag::firstOrCreate(['name' => trim($tagName)]);
         });

         $this->tags()->sync($tags->pluck('id'));
     }

    public function project()
{
    return $this->belongsTo(Project::class);
}

public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}


}