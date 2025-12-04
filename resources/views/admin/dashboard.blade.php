@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h2>Dashboard</h2>

    <ul>
        <li>Total form submissions: {{ $totalForms }}</li>
        <li>Pending approvals: {{ $pendingApprovals }}</li>
        <li>Active notices: {{ $activeNotices }}</li>
        <li>Total gallery images: {{ $galleryCount }}</li>
    </ul>

    <h3>Recent Financial Reports</h3>
    <ul>
        @foreach($financialUpdates as $report)
            <li>{{ $report->title }} ({{ $report->year }}{{ $report->month ? '/'.$report->month : '' }})</li>
        @endforeach
    </ul>
@endsection
