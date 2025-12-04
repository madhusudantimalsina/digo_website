@extends('layouts.admin')

@section('title', 'Create Album')

@section('content')
    <h2>Create New Gallery Album</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Album Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Description (optional)</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Cover Image (optional)</label>
            <input type="file" name="cover_image" class="form-control">
        </div>

        <button class="btn btn-primary">Create Album</button>
    </form>
@endsection
