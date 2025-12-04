@extends('layouts.admin')

@section('title', 'Album: '.$album->name)

@section('content')
    <h2>Album: {{ $album->name }}</h2>

    <p>{{ $album->description }}</p>

    {{-- Upload Form --}}
    <h4 class="mt-4">Add Images to this Album</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.images.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf

        {{-- Hidden album id --}}
        <input type="hidden" name="gallery_album_id" value="{{ $album->id }}">

        <div class="mb-3">
            <label>Image Title (optional)</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Event 2025">
        </div>

        <div class="mb-3">
            <label>Description (optional)</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Select Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <button class="btn btn-success">Upload Image</button>
    </form>

    {{-- Existing Images --}}
    <h4>Images in this Album</h4>

    @if($album->images->count())
        <div class="row">
            @foreach($album->images as $image)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ asset('storage/'.$image->image_path) }}"
                             class="card-img-top"
                             style="height:150px; object-fit:cover;">

                        <div class="card-body">
                            @if($image->title)
                                <h5 class="card-title">{{ $image->title }}</h5>
                            @endif
                            @if($image->description)
                                <p class="card-text">{{ $image->description }}</p>
                            @endif

                            <form action="{{ route('admin.images.destroy', $image->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this image?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No images in this album yet.</p>
    @endif

@endsection
