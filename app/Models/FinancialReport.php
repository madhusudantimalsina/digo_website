<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class FinancialReport extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_original_name',
        'file_mime',
        'file_size',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active'    => 'boolean',
    ];

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getPublishedDateAttribute(): ?string
    {
        return $this->published_at
            ? $this->published_at->format('Y-m-d')
            : ($this->created_at?->format('Y-m-d'));
    }
}
