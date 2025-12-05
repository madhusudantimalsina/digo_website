@extends('layouts.admin')

@section('title', 'Blogs')

{{-- Import CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/adminblog.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Blog Posts</h1>
        <p class="page-subtitle">Manage all Published, Draft, and Scheduled blog posts.</p>
    </div>

    <a href="{{ route('admin.blogs.create') }}" class="btn-primary">
        + Add New Blog
    </a>
</div>

{{-- Toast Success Popup --}}
@if(session('success'))
    <div id="blog-toast-success" class="toast toast-success">
        <span class="toast-icon">✓</span>
        <span class="toast-message">{{ session('success') }}</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('blog-toast-success');
            if (!toast) return;

            setTimeout(() => toast.classList.add('show'), 80);
            setTimeout(() => toast.classList.remove('show'), 3080);
        });
    </script>
@endif

<div class="card table-card">

    <header class="card-header">
        <h3 class="card-title">All Blog Posts</h3>
        <p class="card-subtitle">Edit, publish, schedule, or remove blog entries.</p>
    </header>

    @if($blogs->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Published Date</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($blogs as $blog)
                    @php
                        $pubDate = $blog->published_at ? $blog->published_at->format('Y-m-d') : null;
                        $isFuture = $blog->published_at && $blog->published_at->isFuture();
                        
                        if(!$blog->is_published){
                            $status = 'Draft';
                            $badge = 'badge-gray';
                        } elseif($isFuture){
                            $status = 'Scheduled';
                            $badge = 'badge-blue';
                        } else {
                            $status = 'Published';
                            $badge = 'badge-green';
                        }
                    @endphp

                    <tr>
                        {{-- TITLE --}}
                        <td>{{ $blog->title }}</td>

                        {{-- PUBLISHED DATE --}}
                        <td>
                            @if($pubDate)
                                @if($isFuture)
                                    <span class="future-label">Scheduled for {{ $pubDate }}</span>
                                @else
                                    {{ $pubDate }}
                                @endif
                            @else
                                —
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <span class="badge {{ $badge }}">{{ $status }}</span>
                        </td>

                        {{-- ACTIONS --}}
                        <td class="actions-column">
                            <div class="action-buttons">

                                {{-- EDIT --}}
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                   class="btn-table btn-edit">
                                    Edit
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                      method="POST"
                                      class="delete-form"
                                      onsubmit="return confirm('Delete this blog post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-table btn-delete">
                                        Delete
                                    </button>
                                </form>

                                {{-- VIEW (ADMIN SHOW PAGE) --}}
                                <a href="{{ route('admin.blogs.show', $blog->id) }}"
                                   class="btn-table btn-view">
                                    View
                                </a>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $blogs->links() }}
        </div>

    @else
        <p class="table-empty">No blog posts found.</p>
    @endif

</div>

@endsection
