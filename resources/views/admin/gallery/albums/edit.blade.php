@extends('layouts.admin')

@section('title', 'Edit Album: '.$album->name)

{{-- IMPORT CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/galleryalbumadmin.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Album</h1>
        <p class="page-subtitle">Modify album details, description, or cover image.</p>
    </div>

    <a href="{{ route('admin.albums.index') }}" class="btn-secondary">← Back to Albums</a>
</div>

<div class="card form-card">

    @if($errors->any())
        <div class="alert-danger-custom">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.albums.update', $album->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Album Name --}}
        <div class="form-group">
            <label class="form-label">Album Name *</label>
            <input type="text"
                   name="name"
                   class="form-input"
                   value="{{ old('name', $album->name) }}"
                   required>
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label class="form-label">Description (optional)</label>
            <textarea name="description"
                      rows="3"
                      class="form-textarea">{{ old('description', $album->description) }}</textarea>
        </div>

        {{-- Current Cover --}}
        <div class="form-group">
            <label class="form-label">Current Cover</label>
            
            @if($album->cover_image)
                <img src="{{ asset('storage/'.$album->cover_image) }}"
                     class="cover-preview">
            @else
                <p class="text-muted">No cover image uploaded.</p>
            @endif
        </div>

        {{-- Upload new cover --}}
        <div class="form-group">
            <label class="form-label">Change Cover Image (optional)</label>
            <input type="file" name="cover_image" class="form-input-file">
            <small class="note-text">Leave empty to keep existing cover image.</small>
        </div>

        {{-- Buttons --}}
        <div class="form-actions">
            <button class="btn-primary">Update Album</button>
            <a href="{{ route('admin.albums.index') }}" class="btn-secondary">Cancel</a>
        </div>

    </form>

</div>

@endsection
