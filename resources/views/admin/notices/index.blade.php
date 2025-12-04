@extends('layouts.admin')

@section('title', 'Notices')

@section('content')
    <h2>Notices</h2>

    <a href="{{ route('admin.notices.create') }}">+ New Notice</a>

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Urgent</th>
                <th>Status</th>
                <th>Expires</th>
                <th>Attachment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($notices as $notice)
            <tr>
                <td>{{ $notice->id }}</td>
                <td>{{ $notice->title }}</td>
                <td>{{ $notice->is_urgent ? 'Yes' : 'No' }}</td>
                <td>{{ ucfirst($notice->status) }}</td>
                <td>{{ $notice->expires_at ? $notice->expires_at->format('Y-m-d') : '-' }}</td>
                <td>
                    @if ($notice->attachment_path)
                        {{ $notice->attachment_original_name }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.notices.edit', $notice) }}">Edit</a>
                    <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this notice?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No notices found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $notices->links() }}
@endsection
