@extends('layouts.public')

@section('title', 'Notices')

@section('content')

<h1 class="mb-4">Notices</h1>

@if($notices->count() > 0)

    <div class="list-group">

        @foreach($notices as $notice)
            <a href="{{ route('notices.show', $notice->id) }}" 
               class="list-group-item list-group-item-action">

                <div class="d-flex justify-content-between align-items-center">
                    
                    <div>
                        @if($notice->is_urgent)
                            <span class="badge bg-danger me-2">URGENT</span>
                        @endif

                        {{ $notice->title }}
                    </div>

                    {{-- FILE ICON --}}
                    @if($notice->attachment_path)
                        @php $type = $notice->fileType(); @endphp

                        @if($type == 'image')
                            <img src="{{ asset('storage/'.$notice->attachment_path) }}"
                                 style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                        @elseif($type == 'pdf')
                            <i class="bi bi-file-earmark-pdf text-danger fs-3"></i>
                        @elseif($type == 'doc')
                            <i class="bi bi-file-earmark-word text-primary fs-3"></i>
                        @elseif($type == 'zip')
                            <i class="bi bi-file-earmark-zip fs-3"></i>
                        @else
                            <i class="bi bi-file-earmark fs-3"></i>
                        @endif
                    @endif

                </div>

                @if ($notice->expires_at)
                    <small class="text-muted">Valid until: {{ $notice->expires_at->format('Y-m-d') }}</small>
                @endif

            </a>
        @endforeach

    </div>

    <div class="mt-3">
        {{ $notices->links() }}
    </div>

@else
    <p>No notices found.</p>
@endif

@endsection
