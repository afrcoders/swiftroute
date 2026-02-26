<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | Terra Nova Deliveries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/deliveries.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <style>
        .admin-sidebar { width: 250px; min-height: calc(100vh - 70px); background: #f8f9fa; border-right: 1px solid #e9ecef; position: fixed; top: 70px; left: 0; padding: 1.5rem 0; z-index: 100; }
        .admin-sidebar .nav-link { color: #4a5568; padding: 0.6rem 1.5rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active { background: #e2e8f0; color: #1a202c; }
        .admin-content { margin-left: 250px; padding: 2rem; margin-top: 70px; }
        @media (max-width: 768px) {
            .admin-sidebar { display: none; }
            .admin-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top tn-navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/terranova.png?v=1') }}" alt="Terra Nova" class="tn-logo">
                <span class="fw-semibold">Admin Panel</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-white-50 small">{{ auth()->user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <aside class="admin-sidebar">
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}" href="{{ route('admin.bookings') }}">
                <i class="bi bi-calendar-check"></i> Bookings
            </a>
            <a class="nav-link {{ request()->routeIs('admin.pricing') ? 'active' : '' }}" href="{{ route('admin.pricing') }}">
                <i class="bi bi-currency-dollar"></i> Pricing Rules
            </a>
            <a class="nav-link {{ request()->routeIs('admin.timeslots') ? 'active' : '' }}" href="{{ route('admin.timeslots') }}">
                <i class="bi bi-clock"></i> Time Slots
            </a>
            <a class="nav-link {{ request()->routeIs('admin.loading-options') ? 'active' : '' }}" href="{{ route('admin.loading-options') }}">
                <i class="bi bi-box-seam"></i> Loading Options
            </a>
        </nav>
    </aside>

    <main class="admin-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
