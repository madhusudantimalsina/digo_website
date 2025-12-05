<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // Automatically generate slug if not set
    protected static function boot()
    {
        parent::boot();

        static::saving(function (Blog $blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);

                // ensure unique slug
                $original = $blog->slug;
                $counter  = 1;
                while (static::where('slug', $blog->slug)
                             ->where('id', '!=', $blog->id)
                             ->exists()) {
                    $blog->slug = $original.'-'.$counter++;
                }
            }
        });
    }

    /**
     * Accessor: published_date used in admin list
     */
    public function getPublishedDateAttribute(): ?string
    {
        return $this->published_at
            ? $this->published_at->format('Y-m-d')
            : ($this->created_at?->format('Y-m-d'));
    }

    /**
     * Accessor: full URL for cover
     */
    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_image ? asset('storage/'.$this->cover_image) : null;
    }

    /**
     * Scope: only posts that are currently visible on the public site.
     *  - is_published = true
     *  - published_at is null or <= now()
     */
    public function scopePublicVisible($query)
    {
        return $query->where('is_published', true)
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }
}
