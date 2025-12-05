<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/digologo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/digologo.png') }}">

    <title>@yield('title', 'Digo Coop')</title>

    <!-- Bootstrap CSS (optional but recommended since you're using navbar classes) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
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
                        <a class="nav-link {{ request()->routeIs('financial.*') ? 'active' : '' }}" 
                           href="{{ route('financial.index') }}">Financial Reports</a>
                    </li>

                    {{-- ⭐ BLOG LINK ADDED HERE --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                           href="{{ route('blog.index') }}">
                            Blog
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('page.show') ? 'active' : '' }}" 
                           href="/page/about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" 
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

    <!-- Bootstrap JS Bundle (for navbar toggle etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
