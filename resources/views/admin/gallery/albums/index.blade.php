@extends('layouts.admin')

@section('title', 'Gallery Albums')

@section('content')
    <h2>Gallery Albums</h2>

    <a href="{{ route('admin.albums.create') }}" class="btn btn-primary mb-3">
        + Add New Album
    </a>

    @if($albums->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Album</th>
                    <th>Description</th>
                    <th>Images</th>
                    <th>Cover</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($albums as $album)
                    <tr>
                        <td>{{ $album->name }}</td>
                        <td>{{ $album->description }}</td>
                        <td>{{ $album->images_count }}</td>
                        <td>
                            @if($album->cover_image)
                                <img src="{{ asset('storage/'.$album->cover_image) }}"
                                     style="width:60px;height:60px;object-fit:cover;">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.albums.show', $album->id) }}" class="btn btn-sm btn-info">
                                Open
                            </a>
                            <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <form action="{{ route('admin.albums.destroy', $album->id) }}"
                                  method="POST"
                                  style="display:inline-block;"
                                  onsubmit="return confirm('Delete this album? All images will be deleted.');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No albums created yet.</p>
    @endif
@endsection
