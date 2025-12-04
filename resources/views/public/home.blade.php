@extends('layouts.public')

@section('title', 'Home')

@section('content')

<h1 class="text-center mb-4">Welcome to Digo Cooperative</h1>

<h3>Latest Notices</h3>

@if($latestNotices->count() > 0)
    <ul class="list-group">

        @foreach($latestNotices as $notice)
            <li class="list-group-item d-flex justify-content-between align-items-center">

                <a href="{{ route('notices.show', $notice->id) }}">
                    @if($notice->is_urgent)
                        <span class="badge bg-danger me-2">URGENT</span>
                    @endif
                    {{ $notice->title }}
                </a>

                @if($notice->attachment_path)
                    @php $type = $notice->fileType(); @endphp

                    @if($type == 'image')
                        <img src="{{ asset('storage/'.$notice->attachment_path) }}"
                             style="width:35px; height:35px; object-fit:cover; border-radius:4px;">
                    @elseif($type == 'pdf')
                        <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                    @elseif($type == 'doc')
                        <i class="bi bi-file-earmark-word text-primary fs-4"></i>
                    @elseif($type == 'zip')
                        <i class="bi bi-file-earmark-zip fs-4"></i>
                    @else
                        <i class="bi bi-file-earmark fs-4"></i>
                    @endif
                @endif

            </li>
        @endforeach

    </ul>

    <a href="{{ route('notices.index') }}" class="btn btn-outline-primary mt-3">View All Notices →</a>

@else
    <p>No notices available.</p>
@endif

@endsection
