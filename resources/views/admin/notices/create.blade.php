@extends('layouts.admin')

@section('title', 'Create Notice')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/notice.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Create Notice</h1>
        <p class="page-subtitle">Add a new notice to display on the website.</p>
    </div>

    <a href="{{ route('admin.notices.index') }}" class="btn-secondary">
        ← Back to Notices
    </a>
</div>

@if ($errors->any())
<div class="alert-error">
    <strong>Please fix the following issues:</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card form-card">

    <form action="{{ route('admin.notices.store') }}" method="POST" enctype="multipart/form-data" class="form-wrapper">
        @csrf

        {{-- TITLE --}}
        <div class="form-section">
            <label class="form-label">Title <span class="required">*</span></label>
            <input type="text" name="title" class="form-input" value="{{ old('title') }}" required>
        </div>

        {{-- BODY --}}
        <div class="form-section">
            <label class="form-label">Notice Text (optional)</label>
            <textarea name="body" rows="5" class="form-textarea" placeholder="Write the notice content here...">{{ old('body') }}</textarea>
        </div>

        {{-- ATTACHMENT --}}
        <div class="form-section">
            <label class="form-label">Upload Notice File</label>
            <p class="form-help">PDF, images, or docs. Maximum size: 5MB.</p>
            <input type="file" name="attachment" class="form-file">
        </div>

        <hr class="form-divider">

        {{-- GRID ROW --}}
        <div class="form-grid">

            {{-- URGENT --}}
            <div class="form-section">
                <label class="form-label">Priority</label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="is_urgent" value="1" {{ old('is_urgent') ? 'checked' : '' }}>
                    <span>Mark as urgent notice</span>
                </label>
            </div>

            {{-- EXPIRY --}}
            <div class="form-section">
                <label class="form-label">Expiry Date (optional)</label>
                <input type="date" name="expires_at" class="form-input" value="{{ old('expires_at') }}">
                <p class="form-help">Leave empty if the notice never expires.</p>
            </div>

        </div>

        {{-- STATUS --}}
        <div class="form-section">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Not visible)</option>
                <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published (Visible)</option>
            </select>
        </div>

        {{-- BUTTONS --}}
        <div class="form-actions">
            <a href="{{ route('admin.notices.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Save Notice</button>
        </div>

    </form>

</div>

@endsection
