@extends('layouts.admin')

@section('title', 'Notices')

{{-- Import Notice CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/notice.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Notices</h1>
        <p class="page-subtitle">Manage all notices displayed on the website.</p>
    </div>

    <a href="{{ route('admin.notices.create') }}" class="btn-primary">
        + New Notice
    </a>
</div>

{{-- ✅ FLASH POPUP (Success / Error) --}}
@if (session('success') || session('error'))
    <div id="flash-toast"
         class="flash-toast {{ session('success') ? 'flash-toast-success' : 'flash-toast-error' }}">
        <div class="flash-toast-content">
            <span class="flash-toast-icon">
                @if(session('success'))
                    ✓
                @else
                    !
                @endif
            </span>
            <div class="flash-toast-text">
                <strong>
                    {{ session('success') ? 'Success' : 'Notice' }}
                </strong>
                <p>
                    {{ session('success') ?? session('error') }}
                </p>
            </div>
        </div>

        <button type="button" id="flash-toast-close" class="flash-toast-close">
            ✕
        </button>
    </div>

    {{-- Small JS to show/hide toast --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('flash-toast');
            const closeBtn = document.getElementById('flash-toast-close');

            if (!toast) return;

            // show with animation
            requestAnimationFrame(() => {
                toast.classList.add('show');
            });

            // auto-hide after 4 seconds
            const hideTimeout = setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);

            // close button
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    toast.classList.remove('show');
                    clearTimeout(hideTimeout);
                });
            }
        });
    </script>
@endif

<div class="card table-card">
    <header class="card-header">
        <h3 class="card-title">All Notices</h3>
        <p class="card-subtitle">Review, view, edit, or remove notices.</p>
    </header>

    <div class="table-wrapper">

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Urgent</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Expires</th>
                    <th>Attachment</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($notices as $notice)
                <tr>
                    <td>{{ $notice->title }}</td>

                    <td>
                        @if($notice->is_urgent)
                            <span class="badge badge-red">Urgent</span>
                        @else
                            <span class="badge badge-gray">Normal</span>
                        @endif
                    </td>

                    <td>
                        <span class="badge badge-blue">
                            {{ ucfirst($notice->status) }}
                        </span>
                    </td>

                    <td>
                        {{ $notice->created_at ? $notice->created_at->format('Y-m-d') : '-' }}
                    </td>

                    <td>
                        {{ $notice->expires_at ? $notice->expires_at->format('Y-m-d') : '-' }}
                    </td>

                    <td>
                        @if ($notice->attachment_path)
                            <span class="file-name">{{ $notice->attachment_original_name }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td class="text-right actions-column">

                        {{-- VIEW BUTTON --}}
                        <a href="{{ route('admin.notices.show', $notice) }}" class="btn-table btn-view">
                            View
                        </a>

                        {{-- EDIT BUTTON --}}
                        <a href="{{ route('admin.notices.edit', $notice) }}" class="btn-table btn-edit">
                            Edit
                        </a>

                        {{-- DELETE BUTTON --}}
                        <form action="{{ route('admin.notices.destroy', $notice) }}"
                              method="POST"
                              class="delete-form"
                              onsubmit="return confirm('Delete this notice?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-table btn-delete">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="table-empty">No notices found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</div>

<div class="pagination-wrapper">
    {{ $notices->links() }}
</div>

@endsection
