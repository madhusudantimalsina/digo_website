<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    /**
     * Store one or many images for a given album.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'gallery_album_id' => 'required|exists:gallery_albums,id',

            // images[] is an array of files
            'images'           => 'required|array',
            'images.*'         => 'image|max:5120', // each file max 5MB

            // optional meta, applied to all images or first image conceptually
            'title'            => 'nullable|string|max:255',
            'description'      => 'nullable|string',
        ]);

        $album = GalleryAlbum::findOrFail($data['gallery_album_id']);

        $uploadedCount = 0;

        // Loop through each uploaded file
        foreach ($request->file('images', []) as $file) {
            if (!$file) {
                continue;
            }

            $path = $file->store('gallery/images', 'public');

            GalleryImage::create([
                'gallery_album_id' => $album->id,
                'title'            => $data['title'] ?? null,
                'description'      => $data['description'] ?? null,
                'image_path'       => $path,
            ]);

            $uploadedCount++;
        }

        $message = $uploadedCount > 1
            ? "{$uploadedCount} images uploaded successfully."
            : "Image uploaded successfully.";

        return redirect()
            ->route('admin.albums.show', $album->id)
            ->with('success', $message);
    }

    /**
     * Delete a single image from an album.
     */
    public function destroy(GalleryImage $image)
    {
        $albumId = $image->gallery_album_id;

        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()
            ->route('admin.albums.show', $albumId)
            ->with('success', 'Image deleted successfully.');
    }
}
