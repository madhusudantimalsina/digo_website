@extends('layouts.admin')

@section('title', 'Manage Images: '.$album->title)

@section('content')
<div class="container">
    <h1 class="mb-3">Images in "{{ $album->title }}"</h1>

    <a href="{{ route('admin.gallery-albums.index') }}" class="btn btn-secondary mb-3">
        ← Back to Albums
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Upload New Images --}}
    <div class="card mb-4">
        <div class="card-header">
            Upload Images
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.gallery-albums.images.store', $album->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Select Images *</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                    <small class="text-muted">You can select multiple images.</small>
                </div>

                <button class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    {{-- Existing Images --}}
    <div class="row">
        @forelse($images as $image)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/'.$image->image_path) }}" 
                         class="card-img-top" 
                         alt="{{ $image->caption ?? 'Image' }}"
                         style="height:180px; object-fit:cover;">

                    <div class="card-body">
                        @if($image->caption)
                            <p class="card-text">{{ $image->caption }}</p>
                        @endif

                        <form action="{{ route('admin.gallery-images.destroy', $image->id) }}" 
                              method="POST"
                              onsubmit="return confirm('Delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No images uploaded yet.</p>
        @endforelse
    </div>
</div>
@endsection
