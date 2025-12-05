@extends('layouts.admin')

@section('title', 'Financial Reports')

{{-- Import financial CSS --}}
@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/financial.css') }}">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Financial Reports</h1>
        <p class="page-subtitle">
            Upload, manage, and publish financial documents.
        </p>
    </div>

    <a href="{{ route('admin.financial-reports.create') }}" class="btn-primary">
        + Add New Report
    </a>
</div>

{{-- Inline success alert --}}
@if(session('success'))
    <div class="alert-inline alert-inline-success">
        {{ session('success') }}
    </div>
@endif

<div class="card table-card">
    <header class="card-header">
        <h3 class="card-title">All Financial Reports</h3>
        <p class="card-subtitle">Review, edit, or remove uploaded reports.</p>
    </header>

    @if($reports->count())
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Published Date</th>
                        <th>File</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->title }}</td>

                        <td>{{ $report->published_date ?? '-' }}</td>

                        <td>
                            @if($report->file_original_name)
                                <span class="file-name">{{ $report->file_original_name }}</span>
                            @else
                                <span class="text-muted">No File</span>
                            @endif
                        </td>

                        <td>
                            @if($report->is_active)
                                <span class="badge-green">Active</span>
                            @else
                                <span class="badge-gray">Hidden</span>
                            @endif
                        </td>

                        <td class="actions-column">

                            <div class="action-buttons">

                                {{-- OPEN FILE --}}
                                @if($report->file_url)
                                    <a href="{{ $report->file_url }}"
                                       target="_blank"
                                       class="btn-table btn-view">
                                        Open
                                    </a>
                                @endif

                                {{-- EDIT --}}
                                <a href="{{ route('admin.financial-reports.edit', $report->id) }}"
                                   class="btn-table btn-edit">
                                    Edit
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('admin.financial-reports.destroy', $report->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this report?');"
                                      class="delete-form-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-table btn-delete">
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $reports->links() }}
        </div>

    @else
        <div class="table-empty">No financial reports found.</div>
    @endif
</div>

@endsection
