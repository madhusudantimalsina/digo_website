@extends('layouts.admin')

@section('title', 'Form Details #'.$submission->id)

@section('content')
    <h2>Form Details (ID: {{ $submission->id }})</h2>

    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <table cellpadding="6" cellspacing="0">
        <tr>
            <th align="left">Form:</th>
            <td>{{ $submission->form?->name ?? 'Contact / Other' }}</td>
        </tr>
        <tr>
            <th align="left">Full Name:</th>
            <td>{{ $submission->full_name }}</td>
        </tr>
        <tr>
            <th align="left">Email:</th>
            <td>{{ $submission->email }}</td>
        </tr>
        <tr>
            <th align="left">Message:</th>
            <td>{{ $submission->message }}</td>
        </tr>
        <tr>
            <th align="left">Status:</th>
            <td>{{ ucfirst($submission->status) }}</td>
        </tr>
        <tr>
            <th align="left">Submitted At:</th>
            <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
        </tr>
    </table>

    <h4 style="margin-top:20px;">Update Status</h4>

    <form action="{{ route('admin.form-submissions.status', $submission->id) }}" method="POST">
        @csrf

        <select name="status">
            <option value="new" {{ $submission->status == 'new' ? 'selected' : '' }}>New</option>
            <option value="seen" {{ $submission->status == 'seen' ? 'selected' : '' }}>Seen</option>
            <option value="processed" {{ $submission->status == 'processed' ? 'selected' : '' }}>Processed</option>
        </select>

        <button type="submit">Save</button>
    </form>

    <p style="margin-top:20px;">
        <a href="{{ route('admin.form-submissions.index') }}">← Back to all forms</a>
    </p>
@endsection
