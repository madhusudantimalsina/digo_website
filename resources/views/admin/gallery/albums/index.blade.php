@extends('layouts.admin')

@section('title', 'Gallery Albums')

{{-- IMPORT CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/galleryalbumadmin.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Gallery Albums</h1>
        <p class="page-subtitle">Manage albums and images uploaded to the gallery.</p>
    </div>

    <a href="{{ route('admin.albums.create') }}" class="btn-primary">
        + Add New Album
    </a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="card table-card">
    <header class="card-header">
        <h3 class="card-title">All Albums</h3>
        <p class="card-subtitle">View, edit, or delete gallery albums.</p>
    </header>

    @if($albums->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Album</th>
                        <th>Description</th>
                        <th>Images</th>
                        <th>Cover</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($albums as $album)
                        <tr>
                            <td>{{ $album->name }}</td>

                            <td class="text-muted">
                                {{ $album->description ?: '—' }}
                            </td>

                            <td>{{ $album->images_count }}</td>

                            <td>
                                @if($album->cover_image)
                                    <img src="{{ asset('storage/'.$album->cover_image) }}"
                                         class="cover-img">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td class="text-right">
                                <div class="action-buttons">

                                    <a href="{{ route('admin.albums.show', $album->id) }}"
                                       class="btn-table btn-view">Open</a>

                                    <a href="{{ route('admin.albums.edit', $album->id) }}"
                                       class="btn-table btn-edit">Edit the album</a>

                                    <form action="{{ route('admin.albums.destroy', $album->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this album? All images will also be removed.')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn-table btn-delete">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @else
        <p class="table-empty">No albums created yet.</p>
    @endif
</div>

@endsection
