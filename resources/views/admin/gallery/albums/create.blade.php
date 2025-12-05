@extends('layouts.admin')

@section('title', 'Create Album')

{{-- Import gallery admin CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/galleryalbumadmin.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Create New Gallery Album</h1>
        <p class="page-subtitle">
            Add a new album to organize your gallery images.
        </p>
    </div>

    <a href="{{ route('admin.albums.index') }}" class="btn-secondary">
        ← Back to Albums
    </a>
</div>

<div class="card">

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert-danger-custom">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.albums.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="form-wrapper">
        @csrf

        {{-- Album Name --}}
        <div class="form-group">
            <label class="form-label">Album Name <span style="color:#ef4444">*</span></label>
            <input
                type="text"
                name="name"
                class="form-input"
                required
                value="{{ old('name') }}"
                placeholder="e.g. Your event names"
            >
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label class="form-label">Description (optional)</label>
            <textarea
                name="description"
                class="form-textarea"
                rows="3"
                placeholder="Short description of the album...">{{ old('description') }}</textarea>
        </div>

        {{-- Cover Image --}}
        <div class="form-group">
            <label class="form-label">Cover Image (optional)</label>
            <input
                type="file"
                name="cover_image"
                class="form-input-file"
            >
            <p class="note-text">
                This image will be used as the album thumbnail. You can change it later.
            </p>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('admin.albums.index') }}" class="btn-secondary">
                Cancel
            </a>
            <button class="btn-primary">
                Create Album
            </button>
        </div>

    </form>
</div>

@endsection
