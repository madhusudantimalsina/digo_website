@extends('layouts.admin')

@section('title', 'Financial Reports')

@section('content')
    <h2>Financial Reports</h2>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:8px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <p>
        <a href="{{ route('admin.financial-reports.create') }}">+ Add New Report</a>
    </p>

    @if($reports->count())
        <table border="1" cellspacing="0" cellpadding="6" style="border-collapse:collapse; width:100%;">
            <thead>
            <tr>
                <!-- <th>ID</th> -->
                <th>Title</th>
                <th>Published</th>
                <th>File</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <!-- <td>{{ $report->id }}</td> -->
                    <td>{{ $report->title }}</td>
                    <td>{{ $report->published_date }}</td>
                    <td>{{ $report->file_original_name }}</td>
                    <td>{{ $report->is_active ? 'Active' : 'Hidden' }}</td>
                    <td>
                        <a href="{{ route('admin.financial-reports.edit', $report->id) }}">Edit</a>

                        <form action="{{ route('admin.financial-reports.destroy', $report->id) }}"
                              method="POST"
                              style="display:inline-block;"
                              onsubmit="return confirm('Delete this report?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>

                        <a href="{{ $report->file_url }}" target="_blank">Open</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="margin-top:10px;">
            {{ $reports->links() }}
        </div>
    @else
        <p>No financial reports yet.</p>
    @endif
@endsection
