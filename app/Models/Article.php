<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Awcodes\Curator\Models\Media;

class Article extends Model
{
    use HasFactory, HasSeo;

    protected $fillable = [
        "title",
        "slug",
        "excerpt",
        "content",
        "user_id",
        "featured_image_id",
        "category_id",
        "seo_title",
        "seo_description",
        "seo_keywords",
        "is_published",
        "published_at",
    ];

    protected $casts = [
        "is_published" => "boolean",
        "published_at" => "datetime",
        "seo_keywords" => "array",
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

   

public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function scopePublished($query)
    {
        return $query
            ->where("is_published", true)
            ->where("published_at", "<=", now());
    }

    public function getReadingTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes . " " . str($minutes == 1 ? "minute" : "minutes")->plural();
    }
}
