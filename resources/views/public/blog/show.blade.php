@extends('layouts.public')

@section('title', $blog->title)

@section('content')
    <h1>{{ $blog->title }}</h1>

    <p><small>Published: {{ $blog->published_date }}</small></p>

    @if($blog->cover_url)
        <div style="margin:15px 0;">
            <img src="{{ $blog->cover_url }}" style="max-width:100%; height:auto;">
        </div>
    @endif

    @if($blog->excerpt)
        <p><strong>{{ $blog->excerpt }}</strong></p>
    @endif

    <div style="margin-top:15px;">
        {!! nl2br(e($blog->body)) !!}
    </div>

    <p style="margin-top:20px;">
        <a href="{{ route('blog.index') }}">← Back to Blog</a>
    </p>
@endsection
