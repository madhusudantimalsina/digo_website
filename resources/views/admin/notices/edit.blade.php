@extends('layouts.admin')

@section('title', 'Edit Notice')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/notice.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Notice</h1>
        <p class="page-subtitle">Update the details of this notice.</p>
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

<div class="card form-card small-form">

    <form action="{{ route('admin.notices.update', $notice) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="form-wrapper">
        @csrf
        @method('PUT')

        {{-- TITLE --}}
        <div class="form-section">
            <label for="title" class="form-label">
                Title <span class="required">*</span>
            </label>
            <input type="text" 
                   name="title" 
                   id="title"
                   class="form-input"
                   value="{{ old('title', $notice->title) }}"
                   required>
        </div>

        {{-- BODY --}}
        <div class="form-section">
            <label class="form-label">Notice Text (optional)</label>
            <textarea class="form-textarea"
                      name="body"
                      rows="4"
                      placeholder="Write notice content...">{{ old('body', $notice->body) }}</textarea>
        </div>

        {{-- CURRENT FILE --}}
        <div class="form-section">
            <label class="form-label">Current Attachment</label>
            @if ($notice->attachment_path)
                <div class="current-file-box">
                    <span class="current-file-name">{{ $notice->attachment_original_name }}</span>
                    <a href="{{ asset('storage/'.$notice->attachment_path) }}"
                       target="_blank"
                       class="btn-file-view">View file</a>
                </div>
            @else
                <p class="form-help">No file uploaded.</p>
            @endif
        </div>

        {{-- NEW FILE UPLOAD --}}
        <div class="form-section">
            <label class="form-label">Replace Attachment (optional)</label>
            <p class="form-help">Upload new file only if you want to replace the current one.</p>
            <input type="file" name="attachment" class="form-file">
        </div>

        <hr class="form-divider">

        {{-- GRID SECTION --}}
        <div class="form-grid">

            <div class="form-section">
                <label class="form-label">Priority</label>
                <label class="checkbox-inline">
                    <input type="checkbox"
                           name="is_urgent"
                           value="1"
                           {{ old('is_urgent', $notice->is_urgent) ? 'checked' : '' }}>
                    <span>Mark as urgent</span>
                </label>
            </div>

            <div class="form-section">
                <label class="form-label">Expiry Date (optional)</label>
                <input type="date"
                       name="expires_at"
                       class="form-input"
                       value="{{ old('expires_at', optional($notice->expires_at)->format('Y-m-d')) }}">
                <p class="form-help">Leave empty if notice does not expire.</p>
            </div>

        </div>

        {{-- STATUS --}}
        <div class="form-section">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="draft" {{ old('status', $notice->status) === 'draft' ? 'selected' : '' }}>
                    Draft
                </option>
                <option value="published" {{ old('status', $notice->status) === 'published' ? 'selected' : '' }}>
                    Published
                </option>
            </select>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="form-actions">
            <a href="{{ route('admin.notices.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update Notice</button>
        </div>

    </form>
</div>

@endsection
