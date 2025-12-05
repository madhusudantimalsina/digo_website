@extends('layouts.admin')

@section('title', 'Album: '.$album->name)

{{-- Import gallery admin CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/galleryalbumadmin.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Album: {{ $album->name }}</h1>
        <p class="page-subtitle">
            {{ $album->description ?: 'Manage images inside this album.' }}
        </p>
    </div>

    <a href="{{ route('admin.albums.index') }}" class="btn-secondary">
        ← Back to Albums
    </a>
</div>

{{-- Upload Form Card --}}
<div class="card upload-card compact-card">

    <h3 class="section-title">Add Images to this Album</h3>
    <p class="section-subtitle">Upload one or more photos with optional title & description.</p>

    @if($errors->any())
        <div class="alert-danger-custom">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.images.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="form-wrapper small-form">
        @csrf

        {{-- Hidden album id --}}
        <input type="hidden" name="gallery_album_id" value="{{ $album->id }}">

        <div class="form-group">
            <label class="form-label">Image Title (optional)</label>
            <input type="text"
                   name="title"
                   class="form-input compact-input"
                   placeholder="e.g. Event 2025">
        </div>

        <div class="form-group">
            <label class="form-label">Description (optional)</label>
            <textarea name="description"
                      class="form-textarea compact-textarea"
                      rows="3"
                      placeholder="Short description..."></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Select Images *</label>
            {{-- MULTIPLE FILES --}}
            <input type="file"
                   name="images[]"
                   class="form-input-file compact-file"
                   multiple
                   required>
            <p class="note-text">
                You can select multiple JPG/PNG files at once (max 5 MB each).
            </p>
        </div>

        <div class="form-actions">
            <button class="btn-primary">Upload Images</button>
        </div>
    </form>
</div>

{{-- Existing Images --}}
<div class="card gallery-card">
    <h3 class="section-title">Images in this Album</h3>

    @if($album->images->count())
        <div class="album-images-grid">
            @foreach($album->images as $image)
                <div class="image-card">
                    <div class="image-card-thumb">
                        <img src="{{ asset('storage/'.$image->image_path) }}"
                             alt="{{ $image->title ?? 'Album image' }}"
                             class="image-card-img">
                    </div>

                    <div class="image-card-body">
                        @if($image->title)
                            <h4 class="image-card-title">{{ $image->title }}</h4>
                        @endif

                        @if($image->description)
                            <p class="image-card-text">{{ $image->description }}</p>
                        @endif

                        <div class="image-card-actions">
                            <a href="{{ asset('storage/'.$image->image_path) }}"
                               target="_blank"
                               class="btn-light">
                                View
                            </a>

                            <form action="{{ route('admin.images.destroy', $image->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this image?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn-danger-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <p class="table-empty">No images in this album yet.</p>
    @endif
</div>

@endsection
