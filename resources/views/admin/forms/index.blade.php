@extends('layouts.admin')

@section('title', 'Submitted Forms')

{{-- Import Forms CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/formsadmin.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Submitted Forms</h1>
        <p class="page-subtitle">
            View and manage all forms submitted from the website.
        </p>
    </div>
</div>

<div class="card table-card">

    <header class="card-header">
        <h3 class="card-title">All Submissions</h3>
        <p class="card-subtitle">Review details of each submission.</p>
    </header>

    @if($submissions->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Form</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                        <tr>
                            {{-- <td>{{ $submission->id }}</td> --}}
                            <td>{{ $submission->form?->name ?? 'Contact / Other' }}</td>
                            <td>{{ $submission->full_name }}</td>
                            <td>{{ $submission->email }}</td>
                            <td>
                                @php
                                    $status = strtolower($submission->status);
                                @endphp

                                @if($status === 'resolved' || $status === 'completed')
                                    <span class="badge badge-green">{{ ucfirst($submission->status) }}</span>
                                @elseif($status === 'in_progress')
                                    <span class="badge badge-blue">In Progress</span>
                                @elseif($status === 'pending')
                                    <span class="badge badge-yellow">Pending</span>
                                @else
                                    <span class="badge badge-gray">{{ ucfirst($submission->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.form-submissions.show', $submission->id) }}"
                                   class="btn-table btn-view">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $submissions->links() }}
        </div>
    @else
        <p class="table-empty">No forms submitted yet.</p>
    @endif

</div>

@endsection
