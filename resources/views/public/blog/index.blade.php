@extends('layouts.public')

@section('title', 'Blog')

@section('content')
    <h1>Our Blog</h1>

    @if($blogs->count())
        <div class="row">
            @foreach($blogs as $blog)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($blog->cover_url)
                            <img src="{{ $blog->cover_url }}"
                                 class="card-img-top"
                                 style="height:180px; object-fit:cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('blog.show', $blog->slug) }}">
                                    {{ $blog->title }}
                                </a>
                            </h5>
                            <small>{{ $blog->published_date }}</small>
                            @if($blog->excerpt)
                                <p class="card-text" style="margin-top:8px;">
                                    {{ \Illuminate\Support\Str::limit($blog->excerpt, 120) }}
                                </p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('blog.show', $blog->slug) }}">Read more →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $blogs->links() }}
        </div>
    @else
        <p>No blog posts available yet.</p>
    @endif
@endsection
