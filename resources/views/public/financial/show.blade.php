@extends('layouts.public')

@section('title', $report->title)

@section('content')
    <h1>{{ $report->title }}</h1>

    <p><small>Published: {{ $report->published_date }}</small></p>

    @if($report->description)
        <p>{{ $report->description }}</p>
    @endif

    <p>
        <a href="{{ $report->file_url }}" target="_blank">
            View Document
        </a>
        |
        <a href="{{ $report->file_url }}" download>
            Download
        </a>
    </p>

    <p><a href="{{ route('financial.index') }}">← Back to Financial Reports</a></p>
@endsection
