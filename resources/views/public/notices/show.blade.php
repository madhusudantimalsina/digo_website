@extends('layouts.public')

@section('title', $notice->title)

@section('content')

<h1>
    @if($notice->is_urgent)
        <span style="color:red;">[URGENT]</span>
    @endif
    {{ $notice->title }}
</h1>

@if ($notice->expires_at)
    <p><strong>Valid until:</strong> {{ $notice->expires_at->format('Y-m-d') }}</p>
@endif

@if ($notice->body)
    <div class="mb-3">
        {!! nl2br(e($notice->body)) !!}
    </div>
@endif

{{-- FILE DISPLAY --}}
@if ($notice->attachment_path)

    @php $type = $notice->fileType(); @endphp

    <p><strong>Attachment:</strong></p>

    @if($type == 'image')
        <img src="{{ asset('storage/'.$notice->attachment_path) }}"
             class="img-fluid mb-3"
             style="max-width:250px; border-radius:6px;">
    @elseif($type == 'pdf')
        <i class="bi bi-file-earmark-pdf text-danger fs-1"></i>
    @elseif($type == 'doc')
        <i class="bi bi-file-earmark-word text-primary fs-1"></i>
    @elseif($type == 'zip')
        <i class="bi bi-file-earmark-zip fs-1"></i>
    @else
        <i class="bi bi-file-earmark fs-1"></i>
    @endif

    <p>
        <a href="{{ asset('storage/'.$notice->attachment_path) }}"
           target="_blank"
           class="btn btn-outline-primary mt-2">
            Download File
        </a>
    </p>

@endif

<p><a href="{{ route('notices.index') }}">← Back to notices</a></p>

@endsection
