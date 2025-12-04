@extends('layouts.admin')

@section('title', 'Submitted Forms')

@section('content')
    <h2>Submitted Forms</h2>

    @if($submissions->count())
        <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; width:100%;">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Form</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                    <tr>
                        <!-- <td>{{ $submission->id }}</td> -->
                        <td>{{ $submission->form?->name ?? 'Contact / Other' }}</td>
                        <td>{{ $submission->full_name }}</td>
                        <td>{{ $submission->email }}</td>
                        <td>{{ ucfirst($submission->status) }}</td>
                        <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.form-submissions.show', $submission->id) }}">
                                Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:10px;">
            {{ $submissions->links() }}
        </div>
    @else
        <p>No forms submitted yet.</p>
    @endif
@endsection
