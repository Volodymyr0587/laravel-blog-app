<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image_path',
        'body',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeFilterByCategory(Builder $query, $category_id): Builder
    {
        if ($category_id) {
            return $query->whereHas('categories', function ($q) use ($category_id) {
                $q->where('categories.id', $category_id);
            });
        }

        return $query;
    }

    // public function scopeRelatedPosts(Builder $query, $category_id)
    // {
    //     return $query->whereHas('categories', function ($q) use ($category_id) {
    //         $q->whereIn('categories.id', $category_id);
    //     })
    //         ->where('id', '!=', $this->id) // Exclude the current post
    //         ->distinct();
    // }

    public function scopeRelatedPosts(Builder $query, $categoryIds, $postId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        })
            ->where('id', '!=', $postId) // Exclude the current post by passing its ID
            ->distinct();
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                // Створюємо базовий slug без ID
                $post->slug = Str::slug($post->title);
            }
        });

        static::created(function ($post) {
            // Додаємо ID до slug і зберігаємо знову
            $post->slug = Str::slug($post->title) . '-' . $post->id;
            $post->save();
        });

        static::deleting(function ($post) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
        });
    }
}
