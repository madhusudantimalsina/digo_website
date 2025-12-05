<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Digo Coop Admin - @yield('title')</title>

    {{-- ============= Favicon ============= --}}
    <link rel="icon" type="image/png" href="{{ asset('images/digologo.png') }}">

    {{-- Import External CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('extra-css')

</head>
<body>

<div class="admin-layout">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="sidebar">

        {{-- Sidebar Logo Section --}}
        <div class="sidebar-header">

            {{-- LOGO IMAGE --}}
            <img src="{{ asset('images/digologo.png') }}" 
                 alt="Digo Coop Logo"
                 class="sidebar-logo-img">

            <div>
                <p class="sidebar-title">Digo Coop</p>
                <p class="sidebar-subtitle">Admin Panel</p>
            </div>
        </div>

        <div class="nav-section-title"></div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            </li>
        </ul>

        <div class="nav-section-title">Services we provide</div>

        <ul class="nav-links">

            <li>
                <a href="{{ route('admin.notices.index') }}"
                   class="{{ request()->routeIs('admin.notices.*') ? 'active' : '' }}">
                    Notices
                </a>
            </li>

            <li>
                <a href="{{ route('admin.financial-reports.index') }}"
                   class="{{ request()->routeIs('admin.financial-reports.*') ? 'active' : '' }}">
                    Financial
                </a>
            </li>

            <li>
                <a href="{{ route('admin.albums.index') }}"
                   class="{{ request()->routeIs('admin.albums.*') ? 'active' : '' }}">
                    Gallery
                </a>
            </li>

            <li>
                <a href="{{ route('admin.form-submissions.index') }}"
                   class="{{ request()->routeIs('admin.form-submissions.*') ? 'active' : '' }}">
                    Forms
                </a>
            </li>

            <li>
                <a href="{{ route('admin.blogs.index') }}"
                   class="{{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    Blog
                </a>
            </li>

        </ul>

        {{-- Logout --}}
        <div class="logout-wrapper">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

    </aside>



    {{-- ================= CONTENT AREA ================= --}}
    <div class="content-wrapper">

        <header class="topbar">
            <div>
                <div class="topbar-title">@yield('title')</div>
                <div class="topbar-breadcrumb">
                    Dashboard / @yield('title')
                </div>
            </div>

            <div>
                <span class="badge">Admin</span>
            </div>
        </header>

        <main class="main-content">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="flash-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
