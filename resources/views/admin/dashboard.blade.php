@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Overview</h1>
        <p class="page-subtitle">
            Quick snapshot of what’s happening in Digo Coop today.
        </p>
    </div>
</div>

<div class="dashboard-grid">

    {{-- WELCOME & SUMMARY PANEL --}}
    <section class="card welcome-card">
        <div class="welcome-left">
            <span class="welcome-badge">Welcome back</span>
            <h2 class="welcome-title">Digo Coop Admin Panel</h2>
            <p class="welcome-text">
                Monitor forms, notices, gallery and financial reports in one place.
                Use the left sidebar to manage each module.
            </p>

            <div class="welcome-stats-row">
                <div class="welcome-stat-item">
                    <p class="welcome-stat-label">Forms</p>
                    <p class="welcome-stat-number">{{ $totalForms }}</p>
                </div>
                <div class="welcome-stat-item">
                    <p class="welcome-stat-label">Active Notices</p>
                    <p class="welcome-stat-number">{{ $activeNotices }}</p>
                </div>
                <div class="welcome-stat-item">
                    <p class="welcome-stat-label">Gallery Images</p>
                    <p class="welcome-stat-number">{{ $galleryCount }}</p>
                </div>
            </div>
        </div>

        <div class="welcome-right">
            <div class="welcome-illustration-circle">
                <div class="welcome-illustration-inner">
                    <span class="welcome-icon">📊</span>
                </div>
            </div>
        </div>
    </section>

    {{-- KPI CARDS ROW --}}
    <section class="stats-grid">

        <article class="kpi-card">
            <div class="kpi-icon kpi-icon-blue">📝</div>
            <div class="kpi-content">
                <p class="kpi-label">Total Form Submissions</p>
                <p class="kpi-value">{{ $totalForms }}</p>
                <p class="kpi-helper">All forms received from the website.</p>
            </div>
        </article>

        <article class="kpi-card">
            <div class="kpi-icon kpi-icon-amber">⏳</div>
            <div class="kpi-content">
                <p class="kpi-label">Pending Approvals</p>
                <p class="kpi-value">{{ $pendingApprovals }}</p>
                <p class="kpi-helper">Forms awaiting review.</p>
            </div>
        </article>

        <article class="kpi-card">
            <div class="kpi-icon kpi-icon-green">📢</div>
            <div class="kpi-content">
                <p class="kpi-label">Active Notices</p>
                <p class="kpi-value">{{ $activeNotices }}</p>
                <p class="kpi-helper">Notices currently visible on site.</p>
            </div>
        </article>

        <article class="kpi-card">
            <div class="kpi-icon kpi-icon-purple">🖼️</div>
            <div class="kpi-content">
                <p class="kpi-label">Gallery Items</p>
                <p class="kpi-value">{{ $galleryCount }}</p>
                <p class="kpi-helper">Total images in gallery albums.</p>
            </div>
        </article>

    </section>

    {{-- BOTTOM GRID: REPORTS + QUICK LINKS --}}
    <div class="bottom-grid">

        {{-- Recent Financial Reports --}}
        <section class="card report-card">
            <header class="card-header">
                <h3 class="card-title">Recent Financial Reports</h3>
                <p class="card-subtitle">Latest statements published in the system.</p>
            </header>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Year / Month</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($financialUpdates as $report)
                        <tr>
                            <td>{{ $report->title }}</td>
                            <td>{{ $report->year }}{{ $report->month ? '/' . $report->month : '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="table-empty">No financial reports found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Quick Management Links --}}
        <section class="card quick-links-card">
            <header class="card-header">
                <h3 class="card-title">Quick Actions</h3>
                <p class="card-subtitle">Jump directly to frequently used modules.</p>
            </header>

            <ul class="quick-links-list">
                <li>
                    <a href="{{ route('admin.form-submissions.index') }}">
                        Review new form submissions
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.notices.index') }}">
                        Manage & publish notices
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.albums.index') }}">
                        Organize gallery albums
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.financial-reports.index') }}">
                        Upload a new financial report
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.blogs.index') }}">
                        Write or edit blog posts
                    </a>
                </li>
            </ul>
        </section>

    </div>

</div>

@endsection
