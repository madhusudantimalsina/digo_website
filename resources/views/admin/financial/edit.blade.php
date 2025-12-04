@extends('layouts.admin')

@section('title', 'Edit Financial Report')

@section('content')
    <h2>Edit Financial Report</h2>

    @if($errors->any())
        <div style="background:#f8d7da; color:#721c24; padding:8px; margin-bottom:10px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.financial-reports.update', $report->id) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title *</label><br>
            <input type="text" name="title" value="{{ old('title', $report->title) }}" style="width:100%;" required>
        </div>

        <div class="mb-3">
            <label>Description</label><br>
            <textarea name="description" rows="4" style="width:100%;">{{ old('description', $report->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Current File</label><br>
            <a href="{{ $report->file_url }}" target="_blank">{{ $report->file_original_name }}</a>
        </div>

        <div class="mb-3">
            <label>Change File (optional)</label><br>
            <input type="file" name="file">
        </div>

        <div class="mb-3">
            <label>Published Date</label><br>
            <input type="date" name="published_at"
                   value="{{ old('published_at', optional($report->published_at)->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $report->is_active) ? 'checked' : '' }}>
                Visible to public
            </label>
        </div>

        <button type="submit">Update</button>
        <a href="{{ route('admin.financial-reports.index') }}">Cancel</a>
    </form>
@endsection
