<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ["article_id", "user_id", "content", "is_approved"];

    protected $casts = [
        "is_approved" => "boolean",
    ];

       /**
     * Get the parent commentable model (article or note).
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            if (!$comment->user_id && auth()->check()) {
                $comment->user_id = auth()->id();
            }
        });
    }
}