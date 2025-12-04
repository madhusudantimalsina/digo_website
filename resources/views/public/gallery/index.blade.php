@extends('layouts.public')

@section('title', 'Gallery')

@section('content')
    <h1 class="mb-4">Gallery Albums</h1>

    @if($albums->count())
        <div class="row">
            @foreach($albums as $album)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if($album->cover_image)
                            <img src="{{ asset('storage/'.$album->cover_image) }}"
                                 class="card-img-top"
                                 style="height:150px;object-fit:cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                 style="height:150px;">
                                <span>No Cover</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $album->name }}</h5>
                            <p class="card-text">
                                {{ Str::limit($album->description, 60) }}
                            </p>
                            <p class="text-muted mb-2">{{ $album->images_count }} images</p>
                            <a href="{{ route('gallery.show', $album->id) }}" class="btn btn-primary mt-auto">
                                View Album
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No albums available yet.</p>
    @endif
@endsection
