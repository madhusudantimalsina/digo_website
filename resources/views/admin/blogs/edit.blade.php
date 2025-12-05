@extends('layouts.admin')

@section('title', 'Edit Blog Post')

{{-- Import Blog CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/adminblog.css') }}">
@endsection

@section('content')

@php
    // Determine effective values (respecting old() after validation errors)
    $isPublishedOld = old('is_published', $blog->is_published);
    $publishedAtOld = old('published_at', optional($blog->published_at)->format('Y-m-d'));

    $statusLabel = 'Draft';
    if ($isPublishedOld) {
        if ($publishedAtOld && \Carbon\Carbon::parse($publishedAtOld)->isFuture()) {
            $statusLabel = 'Scheduled';
        } else {
            $statusLabel = 'Published';
        }
    }
@endphp

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Blog Post</h1>
        <p class="page-subtitle">Update blog content, cover image, and publishing status.</p>
    </div>

    <a href="{{ route('admin.blogs.index') }}" class="btn-secondary">
        ← Back to Blogs
    </a>
</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert-danger-custom">
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card form-card">

    <h3 class="section-title">Blog Information</h3>
    <p class="section-subtitle">
        Refine your article details, change the cover image, or update its publish / schedule status.
    </p>

    <form action="{{ route('admin.blogs.update', $blog->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="form-wrapper">
        @csrf
        @method('PUT')

        {{-- TITLE --}}
        <div class="form-group">
            <label class="form-label">Title <span class="required">*</span></label>
            <input type="text"
                   name="title"
                   class="form-input"
                   value="{{ old('title', $blog->title) }}"
                   required>
        </div>

        {{-- EXCERPT --}}
        <div class="form-group">
            <label class="form-label">Short Description (Excerpt)</label>
            <textarea name="excerpt"
                      class="form-textarea small-textarea"
                      placeholder="Brief introduction for your blog...">{{ old('excerpt', $blog->excerpt) }}</textarea>
        </div>

        {{-- CONTENT --}}
        <div class="form-group">
            <label class="form-label">Content <span class="required">*</span></label>
            <textarea name="body"
                      class="form-textarea large-textarea"
                      placeholder="Write the full content for the blog..."
                      required>{{ old('body', $blog->body) }}</textarea>
        </div>

        {{-- CURRENT COVER IMAGE --}}
        <div class="form-group">
            <label class="form-label">Current Cover Image</label>
            @if($blog->cover_url)
                <div class="image-preview">
                    <img src="{{ $blog->cover_url }}" alt="Cover Image">
                </div>
            @else
                <p class="text-muted">No cover image uploaded.</p>
            @endif
        </div>

        {{-- CHANGE COVER --}}
        <div class="form-group">
            <label class="form-label">Change Cover Image (Optional)</label>
            <input type="file" name="cover_image" class="form-input-file">
            <p class="note-text">Recommended: 1200×600px (JPG/PNG).</p>
        </div>

        {{-- META ROW (DATE + VISIBILITY) --}}
        <div class="meta-row">

            {{-- PUBLISHED DATE / SCHEDULE --}}
            <div class="form-group">
                <label class="form-label">Published Date (for scheduling)</label>
                <input type="date"
                       name="published_at"
                       class="form-input"
                       value="{{ $publishedAtOld }}">
                <p class="note-text">
                    • If left empty and <strong>Visible to public</strong> is ON → publish immediately.<br>
                    • If set to a <strong>future date</strong> and <strong>Visible to public</strong> is ON → this post will be
                    <strong>scheduled</strong> and will only appear on that date.<br>
                    • If <strong>Visible to public</strong> is OFF → the post remains as a <strong>draft</strong>, even if a date is set.
                </p>
            </div>

            {{-- VISIBILITY TOGGLE --}}
            <div class="form-group">
                <label class="form-label">Visibility</label>
                <label class="switch-label">
                    <input id="visibilityToggle"
                           type="checkbox"
                           name="is_published"
                           value="1"
                           {{ $isPublishedOld ? 'checked' : '' }}>
                    <span class="switch-pill"></span>
                    <span id="visibilityText" class="switch-text">
                        {{ $statusLabel === 'Draft' ? 'Hidden (Draft)' : ($statusLabel === 'Scheduled' ? 'Scheduled (Visible later)' : 'Published (Visible)') }}
                    </span>
                </label>

                <p class="note-text" style="margin-top:6px;">
                    Current status: <strong>{{ $statusLabel }}</strong>
                </p>
            </div>

        </div>

        {{-- ACTION BUTTONS --}}
        <div class="form-actions">
            <button type="submit" class="btn-primary">Update Blog</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn-secondary">Cancel</a>
        </div>

    </form>
</div>

{{-- Small script to update the visibility text when toggling the switch --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('visibilityToggle');
        const textSpan = document.getElementById('visibilityText');

        if (!checkbox || !textSpan) return;

        function updateText() {
            if (!checkbox.checked) {
                textSpan.textContent = 'Hidden (Draft)';
                return;
            }

            // If a future date is selected, show "Scheduled"
            const dateInput = document.querySelector('input[name="published_at"]');
            if (dateInput && dateInput.value) {
                const selected = new Date(dateInput.value);
                const today = new Date();
                // Compare dates by yyyy-mm-dd
                const selStr = selected.toISOString().slice(0, 10);
                const todayStr = new Date(today.getFullYear(), today.getMonth(), today.getDate())
                    .toISOString()
                    .slice(0, 10);

                if (selStr > todayStr) {
                    textSpan.textContent = 'Scheduled (Visible later)';
                    return;
                }
            }

            textSpan.textContent = 'Published (Visible)';
        }

        checkbox.addEventListener('change', updateText);

        const dateInput = document.querySelector('input[name="published_at"]');
        if (dateInput) {
            dateInput.addEventListener('change', updateText);
        }

        // initial
        updateText();
    });
</script>

@endsection
