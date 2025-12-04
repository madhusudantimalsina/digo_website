<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'gallery_album_id' => 'required|exists:gallery_albums,id',
            'title'            => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'image'            => 'required|image|max:5120', // 5 MB
        ]);

        $album = GalleryAlbum::findOrFail($data['gallery_album_id']);

        $path = $request->file('image')->store('gallery/images', 'public');

        GalleryImage::create([
            'gallery_album_id' => $album->id,
            'title'            => $data['title'] ?? null,
            'description'      => $data['description'] ?? null,
            'image_path'       => $path,
        ]);

        return redirect()->route('admin.albums.show', $album->id)
            ->with('success', 'Image uploaded successfully.');
    }

    public function destroy(GalleryImage $image)
    {
        $albumId = $image->gallery_album_id;

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()->route('admin.albums.show', $albumId)
            ->with('success', 'Image deleted successfully.');
    }
}
