@extends('layouts.admin')

@section('title', 'Form Details #'.$submission->id)

{{-- Import CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/formdetails.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Form Details</h1>
        <p class="page-subtitle">Submission ID: {{ $submission->id }}</p>
    </div>

    <a href="{{ route('admin.form-submissions.index') }}" class="btn-secondary">
        ← Back to All Forms
    </a>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card details-card">

    <h3 class="section-title">Submitted Information</h3>

    <table class="details-table">
        <tr>
            <th>Form</th>
            <td>{{ $submission->form?->name ?? 'Contact / Other' }}</td>
        </tr>

        <tr>
            <th>Full Name</th>
            <td>{{ $submission->full_name }}</td>
        </tr>

        <tr>
            <th>Email</th>
            <td>{{ $submission->email }}</td>
        </tr>

        <tr>
            <th>Message</th>
            <td class="message-cell">{{ $submission->message }}</td>
        </tr>

        <tr>
            <th>Status</th>
            <td>
                <span class="badge 
                    @if($submission->status == 'new') badge-yellow 
                    @elseif($submission->status == 'seen') badge-blue
                    @elseif($submission->status == 'processed') badge-green
                    @else badge-gray @endif">
                    {{ ucfirst($submission->status) }}
                </span>
            </td>
        </tr>

        <tr>
            <th>Submitted At</th>
            <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
        </tr>
    </table>

</div>

{{-- UPDATE STATUS --}}
<div class="card update-card">
    <h3 class="section-title">Update Status</h3>

    <form action="{{ route('admin.form-submissions.status', $submission->id) }}" method="POST" class="status-form">
        @csrf

        <div class="form-group">
            <label class="form-label">Select Status</label>
            <select name="status" class="form-select">
                <option value="new" {{ $submission->status == 'new' ? 'selected' : '' }}>New</option>
                <option value="seen" {{ $submission->status == 'seen' ? 'selected' : '' }}>Seen</option>
                <option value="processed" {{ $submission->status == 'processed' ? 'selected' : '' }}>Processed</option>
            </select>
        </div>

        <button type="submit" class="btn-primary">Save Status</button>
    </form>
</div>

@endsection
