<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryAlbum extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cover_image',
    ];

    /**
     * One album has many images.
     * Foreign key in gallery_images table = gallery_album_id
     */
    public function images()
    {
        return $this->hasMany(GalleryImage::class, 'gallery_album_id');
    }
}
