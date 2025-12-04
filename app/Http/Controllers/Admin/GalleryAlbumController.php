<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryAlbumController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('images')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.gallery.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.albums.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096', // 4 MB
        ]);

        $album = new GalleryAlbum();
        $album->name        = $data['name'];
        $album->description = $data['description'] ?? null;

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('gallery/albums', 'public');
            $album->cover_image = $path;
        }

        $album->save();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Gallery album created successfully.');
    }

    public function show(GalleryAlbum $album)
    {
        $album->load('images');

        return view('admin.gallery.albums.show', compact('album'));
    }

    public function edit(GalleryAlbum $album)
    {
        return view('admin.gallery.albums.edit', compact('album'));
    }

    public function update(Request $request, GalleryAlbum $album)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
        ]);

        $album->name        = $data['name'];
        $album->description = $data['description'] ?? null;

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }

            $path = $request->file('cover_image')->store('gallery/albums', 'public');
            $album->cover_image = $path;
        }

        $album->save();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Gallery album updated successfully.');
    }

    public function destroy(GalleryAlbum $album)
    {
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $album->delete();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Gallery album deleted successfully.');
    }
}
