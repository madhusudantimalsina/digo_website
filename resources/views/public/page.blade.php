@extends('layouts.public')

@section('title', $page->title)

@section('content')
    <h1>{{ $page->title }}</h1>

    {{-- Show the page content (basic) --}}
    <div>
        {!! nl2br(e($page->content)) !!}
    </div>
@endsection
