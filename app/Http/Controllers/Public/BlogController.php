<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Public blog listing.
     * Shows only posts that are published AND whose published_at
     * is not in the future (i.e. scheduling respected).
     */
    public function index()
    {
        $blogs = Blog::publicVisible()
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('public.blog.index', compact('blogs'));
    }

    /**
     * Public single blog view.
     * 404 if the post is not published yet (future date or draft).
     */
    public function show(string $slug)
    {
        $blog = Blog::publicVisible()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.blog.show', compact('blog'));
    }
}
