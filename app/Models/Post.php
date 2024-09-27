<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
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
    }
}
