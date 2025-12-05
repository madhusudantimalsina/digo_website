@extends('layouts.admin')

@section('title', 'Edit Financial Report')

{{-- Use the same financial styles --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/financial.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Financial Report</h1>
        <p class="page-subtitle">Update the details of this financial document.</p>
    </div>

    <a href="{{ route('admin.financial-reports.index') }}" class="btn-secondary">
        ← Back to Reports
    </a>
</div>

{{-- Validation errors --}}
@if($errors->any())
    <div class="alert-error">
        <strong>Please fix the following issues:</strong>
        <ul>
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card form-card-financial">
    <form action="{{ route('admin.financial-reports.update', $report->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="form-wrapper">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="form-section">
            <label for="title" class="form-label">
                Title <span class="required">*</span>
            </label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-input"
                value="{{ old('title', $report->title) }}"
                required
            >
        </div>

        {{-- Description --}}
        <div class="form-section">
            <label for="description" class="form-label">Description</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="form-textarea"
                placeholder="Short description of this report..."
            >{{ old('description', $report->description) }}</textarea>
        </div>

        {{-- Current file --}}
        <div class="form-section">
            <label class="form-label">Current File</label>

            @if($report->file_url)
                <div class="current-file-box">
                    <span class="current-file-name">
                        {{ $report->file_original_name }}
                    </span>
                    <a href="{{ $report->file_url }}" target="_blank" class="btn-file-view">
                        View file
                    </a>
                </div>
            @else
                <p class="form-help">No file uploaded for this report.</p>
            @endif
        </div>

        {{-- Replace file --}}
        <div class="form-section">
            <label for="file" class="form-label">Change File (optional)</label>
            <p class="form-help">Upload a new file only if you want to replace the current one.</p>
            <input
                type="file"
                id="file"
                name="file"
                class="form-file"
            >
        </div>

        {{-- Grid: Published date + active --}}
        <div class="form-grid-financial">

            <div class="form-section">
                <label for="published_at" class="form-label">Published Date</label>
                <input
                    type="date"
                    id="published_at"
                    name="published_at"
                    class="form-input"
                    value="{{ old('published_at', optional($report->published_at)->format('Y-m-d')) }}"
                >
            </div>

            <div class="form-section">
                <label class="form-label">Visibility</label>
                <label class="form-checkbox-row">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', $report->is_active) ? 'checked' : '' }}
                    >
                    <span>Visible to public</span>
                </label>
            </div>

        </div>

        {{-- Buttons --}}
        <div class="form-actions">
            <a href="{{ route('admin.financial-reports.index') }}" class="btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn-primary">
                Update Report
            </button>
        </div>

    </form>
</div>

@endsection
