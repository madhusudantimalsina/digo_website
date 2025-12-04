<!DOCTYPE html>
<html>
<head>
    <title>Digo Coop Admin - @yield('title')</title>
</head>
<body>
    <header>
        <h1>Digo Coop Admin Panel</h1>

        <nav>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> |
            <a href="{{ route('admin.pages.index') }}">Pages</a> |
            <a href="{{ route('admin.notices.index') }}">Notices</a> |
            <a href="{{ route('admin.financial-reports.index') }}">Financial</a> |
            <a href="{{ route('admin.albums.index') }}">Gallery</a> |
            <a href="{{ route('admin.form-submissions.index') }}">Forms</a>


            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>

        <hr>
    </header>

    <main>
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @yield('content')
    </main>
</body>
</html>
