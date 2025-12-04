<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <meta charset="UTF-8">
    <title>@yield('title') | Digo Coop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    {{-- ================= NAVBAR ================= --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">

            <a class="navbar-brand" href="{{ route('home') }}">
                <strong>Digo Coop</strong>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('notices.*') ? 'active' : '' }}" 
                           href="{{ route('notices.index') }}">Notices</a>
                    </li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" 
       href="{{ route('gallery.index') }}">
        Gallery
    </a>
</li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('financial.index') ? 'active' : '' }}" 
                           href="{{ route('financial.index') }}">Financial Reports</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('page.show') ? 'active' : '' }}" 
                           href="/page/about">About</a>
                    </li>
                  <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('page.show') ? 'active' : '' }}" 
                           href="{{ route('contact') }}">Contact</a>
                    </li>



                </ul>
            </div>
        </div>
    </nav>

    {{-- ================= PAGE CONTENT ================= --}}
    <div class="container">
        @yield('content')
    </div>

    <footer class="bg-light text-center p-3 mt-5">
        <small>&copy; {{ date('Y') }} Digo Cooperative. All Rights Reserved.</small>
    </footer>
    

</body>
</html>
