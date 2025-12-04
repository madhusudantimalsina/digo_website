<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'gallery_album_id',
        'title',
        'description',
        'image_path',
    ];

    /**
     * Each image belongs to one album.
     * Foreign key = gallery_album_id
     */
    public function album()
    {
        return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id');
    }
}
