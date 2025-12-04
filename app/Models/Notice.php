<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'title',
        'body',
        'attachment_path',
        'attachment_original_name',
        'attachment_mime',
        'is_urgent',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'expires_at' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now()->toDateString());
            });
    }
    public function fileType()
{
    if (!$this->attachment_mime) return 'file';

    if (str_contains($this->attachment_mime, 'image')) return 'image';
    if ($this->attachment_mime === 'application/pdf') return 'pdf';
    if (str_contains($this->attachment_mime, 'word')) return 'doc';
    if ($this->attachment_mime === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') return 'doc';
    if (str_contains($this->attachment_mime, 'zip')) return 'zip';

    return 'file';
}

}
