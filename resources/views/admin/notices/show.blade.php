@extends('layouts.admin')

@section('title', 'View Notice')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/notice.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Notice Details</h1>
        <p class="page-subtitle">View full information about this notice.</p>
    </div>

    <div class="page-header-actions">
        <a href="{{ route('admin.notices.index') }}" class="btn-secondary">
            ← Back to Notices
        </a>

        <a href="{{ route('admin.notices.edit', $notice) }}" class="btn-primary">
            Edit Notice
        </a>
    </div>
</div>

<div class="card notice-detail-card">
    <header class="notice-detail-header">
        <h2 class="notice-detail-title">{{ $notice->title }}</h2>

        <div class="notice-meta-row">
            {{-- Urgency --}}
            @if($notice->is_urgent)
                <span class="badge badge-red">Urgent</span>
            @else
                <span class="badge badge-gray">Normal</span>
            @endif

            {{-- Status --}}
            <span class="badge badge-blue">{{ ucfirst($notice->status) }}</span>
        </div>

        <div class="notice-meta-grid">
            <div class="notice-meta-item">
                <span class="notice-meta-label">Published on</span>
                <span class="notice-meta-value">
                    {{ $notice->created_at ? $notice->created_at->format('Y-m-d') : '-' }}
                </span>
            </div>

            <div class="notice-meta-item">
                <span class="notice-meta-label">Expires on</span>
                <span class="notice-meta-value">
                    {{ $notice->expires_at ? $notice->expires_at->format('Y-m-d') : '-' }}
                </span>
            </div>

            <div class="notice-meta-item">
                <span class="notice-meta-label">Attachment</span>
                <span class="notice-meta-value">
                    @if ($notice->attachment_path)
                        {{ $notice->attachment_original_name }}
                    @else
                        -
                    @endif
                </span>
            </div>
        </div>
    </header>

    <section class="notice-body">
        <h3 class="notice-body-title">Notice Content</h3>

        @php
            // try to use whichever field you have for text
            $body = $notice->content ?? $notice->body ?? $notice->description ?? null;
        @endphp

        @if($body)
            <p class="notice-body-text">{!! nl2br(e($body)) !!}</p>
        @else
            <p class="notice-body-empty">No detailed content was provided for this notice.</p>
        @endif
    </section>
</div>

@endsection
