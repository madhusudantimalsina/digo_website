<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'excerpt'      => 'nullable|string',
            'body'         => 'required|string',
            'cover_image'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'published_at' => 'nullable|date',
        ]);

        // handle cover image
        $path = null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('blog_images', 'public');
        }

        // publishing logic
        $isPublished = $request->boolean('is_published');
        $publishedAt = $data['published_at'] ?? null;

        if ($isPublished) {
            // If no date given, publish now
            if (empty($publishedAt)) {
                $publishedAt = now();
            }
            // If future date is chosen → scheduled (we just keep it as is)
        } else {
            // draft – keep whatever date was entered (can be used as a "planned" date)
            // but it won't show publicly until is_published is set to true
        }

        Blog::create([
            'title'        => $data['title'],
            'excerpt'      => $data['excerpt'] ?? null,
            'body'         => $data['body'],
            'cover_image'  => $path,
            'published_at' => $publishedAt,
            'is_published' => $isPublished,
        ]);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully.');
    }

    /**
     * Display a single blog in the admin panel.
     * Route: admin.blogs.show
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'excerpt'      => 'nullable|string',
            'body'         => 'required|string',
            'cover_image'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'published_at' => 'nullable|date',
        ]);

        // Handle new cover image
        if ($request->hasFile('cover_image')) {
            if ($blog->cover_image && Storage::disk('public')->exists($blog->cover_image)) {
                Storage::disk('public')->delete($blog->cover_image);
            }

            $blog->cover_image = $request
                ->file('cover_image')
                ->store('blog_images', 'public');
        }

        // publishing logic
        $isPublished = $request->boolean('is_published');
        $publishedAt = $data['published_at'] ?? null;

        if ($isPublished) {
            if (empty($publishedAt)) {
                // if admin marks it public but leaves date empty → publish now
                $publishedAt = now();
            }
            // if date is set in the future → scheduled, keep as is
        } else {
            // draft
            // keep date (can be used as reference) or null – your choice
            // here we keep what admin entered or existing date
            if ($publishedAt === null) {
                $publishedAt = $blog->published_at; // don't overwrite with null
            }
        }

        $blog->title        = $data['title'];
        $blog->excerpt      = $data['excerpt'] ?? null;
        $blog->body         = $data['body'];
        $blog->published_at = $publishedAt;
        $blog->is_published = $isPublished;

        $blog->save();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->cover_image && Storage::disk('public')->exists($blog->cover_image)) {
            Storage::disk('public')->delete($blog->cover_image);
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog post deleted.');
    }
}
