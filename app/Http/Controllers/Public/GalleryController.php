<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;

class GalleryController extends Controller
{
    // GET /gallery – list all albums
    public function index()
    {
        $albums = GalleryAlbum::withCount('images')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.gallery.index', compact('albums'));
    }

    // GET /gallery/{album} – show all images of a given album
    public function show(GalleryAlbum $album)
    {
        $album->load('images');

        return view('public.gallery.show', compact('album'));
    }
}
