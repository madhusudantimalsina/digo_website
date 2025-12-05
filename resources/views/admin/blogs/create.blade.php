@extends('layouts.admin')

@section('title', 'Add Blog Post')

{{-- Page-specific CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/adminblog.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Add Blog Post</h1>
        <p class="page-subtitle">
            Create a new blog article with content, images, and publishing options.
        </p>
    </div>

    <a href="{{ route('admin.blogs.index') }}" class="btn-secondary">
        ← Back to Blogs
    </a>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert-error">
        <strong>There were some problems with your input:</strong>
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card form-card">
    <h2 class="section-title">Blog Information</h2>
    <p class="section-subtitle">
        Fill in the details below to publish a new blog post.  
        You can save it as draft, publish immediately, or schedule for a future date.
    </p>

    <form action="{{ route('admin.blogs.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="blog-form">
        @csrf

        {{-- Title --}}
        <div class="form-group">
            <label class="form-label">
                Title <span class="required">*</span>
            </label>
            <input
                type="text"
                name="title"
                class="form-input"
                value="{{ old('title') }}"
                placeholder="Enter blog title…"
                required
            >
        </div>

        {{-- Short Description --}}
        <div class="form-group">
            <label class="form-label">Short Description (Excerpt)</label>
            <textarea
                name="excerpt"
                rows="3"
                class="form-textarea"
                placeholder="A short summary of the blog post…"
            >{{ old('excerpt') }}</textarea>
        </div>

        {{-- Content --}}
        <div class="form-group">
            <label class="form-label">
                Content <span class="required">*</span>
            </label>
            <textarea
                name="body"
                rows="8"
                class="form-textarea"
                placeholder="Write the main blog content here…"
                required
            >{{ old('body') }}</textarea>
        </div>

        {{-- Cover + Publish date in one row --}}
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Cover Image (optional)</label>
                <input type="file" name="cover_image" class="form-input-file">
                <p class="note-text">Recommended size: 1200×600px, JPG or PNG.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Published Date (for scheduling)</label>
                <input
                    type="date"
                    name="published_at"
                    class="form-input"
                    value="{{ old('published_at') }}"
                >
                <p class="note-text">
                    • If left empty and <b>Visible to public</b> is checked → publish immediately.<br>
                    • If set to a <b>future date</b> and <b>Visible to public</b> is checked → post will
                    automatically appear on that date.<br>
                    • If <b>Visible to public</b> is not checked → stays as draft.
                </p>
            </div>
        </div>

        {{-- Visibility --}}
        <div class="form-group checkbox-group">
            <label>
                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    {{ old('is_published', 1) ? 'checked' : '' }}
                >
                <span>Visible to public</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save Blog Post</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</div>

@endsection
