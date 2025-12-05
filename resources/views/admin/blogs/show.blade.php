@extends('layouts.admin')

@section('title', 'Blog Details: '.$blog->title)

{{-- Use admin blog stylesheet --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/adminblog.css') }}">
@endsection

@section('content')

@php
    $pubDate = $blog->published_at ? $blog->published_at->format('Y-m-d') : null;
    $isFuture = $blog->published_at && $blog->published_at->isFuture();

    if(!$blog->is_published) {
        $status = 'Draft';
        $badge = 'badge-gray';
    } elseif($isFuture) {
        $status = 'Scheduled';
        $badge = 'badge-blue';
    } else {
        $status = 'Published';
        $badge = 'badge-green';
    }
@endphp

<div class="blog-detail-layout">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Blog Details</h1>
            <p class="page-subtitle">
                View complete blog information, metadata, and publication status.
            </p>
        </div>

        <div class="header-actions">
            <a href="{{ route('admin.blogs.index') }}" class="btn-secondary">
                ← Back to Blogs
            </a>

            {{-- View on Website (ONLY if now published and not future scheduled) --}}
            @if($blog->is_published && !$isFuture)
                <a href="{{ route('blog.show', $blog->slug) }}"
                   target="_blank"
                   class="btn-primary">
                    View on Website
                </a>
            @endif
        </div>
    </div>

    {{-- MAIN CARD --}}
    <div class="card blog-detail-card">

        {{-- TITLE + EXCERPT --}}
        <header class="card-header">
            <h3 class="card-title">{{ $blog->title }}</h3>

            <p class="card-subtitle">
                {{ $blog->excerpt ?: 'No short description provided.' }}
            </p>
        </header>

        {{-- BLOG META INFORMATION --}}
        <div class="blog-meta-row">

            <div class="meta-item">
                <span class="meta-label">Status:</span>
                <span class="badge {{ $badge }}">{{ $status }}</span>
            </div>

            <div class="meta-item">
                <span class="meta-label">Published On:</span>
                <span class="meta-value">
                    @if($isFuture)
                        Scheduled for {{ $pubDate }}
                    @else
                        {{ $pubDate ?: '-' }}
                    @endif
                </span>
            </div>

            <div class="meta-item">
                <span class="meta-label">Created At:</span>
                <span class="meta-value">
                    {{ $blog->created_at?->format('Y-m-d H:i') }}
                </span>
            </div>

            <div class="meta-item">
                <span class="meta-label">Last Updated:</span>
                <span class="meta-value">
                    {{ $blog->updated_at?->format('Y-m-d H:i') }}
                </span>
            </div>
        </div>

        {{-- COVER IMAGE --}}
        @if($blog->cover_url)
            <div class="blog-cover-wrapper">
                <span class="meta-label">Cover Image:</span>

                <div class="blog-cover-inner">
                    <img src="{{ $blog->cover_url }}"
                         alt="Cover image for {{ $blog->title }}"
                         class="blog-cover-image">
                </div>
            </div>
        @endif

        {{-- FULL BLOG CONTENT --}}
        <div class="blog-body-wrapper">
            <h4 class="blog-body-title">Full Content</h4>

            <div class="blog-body-content">
                {!! nl2br(e($blog->body)) !!}
            </div>
        </div>

    </div>

</div>
@endsection
