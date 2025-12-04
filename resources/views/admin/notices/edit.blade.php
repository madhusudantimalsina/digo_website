@extends('layouts.admin')

@section('title', 'Edit Notice')

@section('content')
    <h2>Edit Notice</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.notices.update', $notice) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Title</label><br>
            <input type="text" name="title" value="{{ old('title', $notice->title) }}" required>
        </div>

        <div>
            <label>Notice Text (optional)</label><br>
            <textarea name="body" rows="5">{{ old('body', $notice->body) }}</textarea>
        </div>

        <div>
            <label>Current Attachment</label><br>
            @if ($notice->attachment_path)
                <a href="{{ asset('storage/'.$notice->attachment_path) }}" target="_blank">
                    {{ $notice->attachment_original_name }}
                </a>
            @else
                <span>No file uploaded.</span>
            @endif
        </div>

        <div>
            <label>Replace Attachment (leave empty to keep current)</label><br>
            <input type="file" name="attachment">
        </div>

        <div>
            <label>
                <input type="checkbox" name="is_urgent" value="1" {{ old('is_urgent', $notice->is_urgent) ? 'checked' : '' }}>
                Mark as urgent
            </label>
        </div>

        <div>
            <label>Expiry Date (optional)</label><br>
            <input type="date" name="expires_at" value="{{ old('expires_at', optional($notice->expires_at)->format('Y-m-d')) }}">
        </div>

        <div>
            <label>Status</label><br>
            <select name="status">
                <option value="draft" {{ old('status', $notice->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $notice->status) === 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <button type="submit">Update Notice</button>
    </form>
@endsection
