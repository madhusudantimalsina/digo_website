@extends('layouts.admin')

@section('title', 'Edit Album: '.$album->name)

@section('content')
    <h2>Edit Gallery Album</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Album Name *</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $album->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description (optional)</label>
            <textarea name="description"
                      class="form-control"
                      rows="3">{{ old('description', $album->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Cover</label><br>
            @if($album->cover_image)
                <img src="{{ asset('storage/'.$album->cover_image) }}"
                     style="width:100px;height:100px;object-fit:cover;border:1px solid #ccc;">
            @else
                <span>No cover image set.</span>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Change Cover Image (optional)</label>
            <input type="file" name="cover_image" class="form-control">
            <small class="form-text text-muted">Leave empty to keep existing cover image.</small>
        </div>

        <button class="btn btn-primary">Update Album</button>
        <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
