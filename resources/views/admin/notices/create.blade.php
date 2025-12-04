@extends('layouts.admin')

@section('title', 'Create Notice')

@section('content')
    <h2>Create Notice</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.notices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Title</label><br>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>

        <div>
            <label>Notice Text (optional)</label><br>
            <textarea name="body" rows="5">{{ old('body') }}</textarea>
        </div>

        <div>
            <label>Upload Notice File (PDF / Image / Doc / etc.)</label><br>
            <input type="file" name="attachment">
        </div>

        <div>
            <label>
                <input type="checkbox" name="is_urgent" value="1" {{ old('is_urgent') ? 'checked' : '' }}>
                Mark as urgent
            </label>
        </div>

        <div>
            <label>Expiry Date (optional)</label><br>
            <input type="date" name="expires_at" value="{{ old('expires_at') }}">
        </div>

        <div>
            <label>Status</label><br>
            <select name="status">
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <button type="submit">Save Notice</button>
    </form>
@endsection
