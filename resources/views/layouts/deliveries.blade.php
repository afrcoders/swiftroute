<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Winnipeg Deliveries') | Terra Nova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/deliveries.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top tn-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('deliveries.index') }}">
                <img src="{{ asset('assets/terranova.png?v=1') }}" alt="Terra Nova" class="tn-logo">
                <div class="tn-brand-text">
                    <span class="tn-brand-name">Winnipeg Deliveries</span>
                    <span class="tn-brand-sub">powered by Terra Nova Property Services</span>
                </div>
            </a>
        </div>
    </nav>

    {{-- Progress Steps --}}
    @hasSection('step')
    <div class="tn-progress-bar">
        <div class="container">
            <div class="tn-steps">
                @php $currentStep = View::getSection('step'); @endphp
                @foreach([1 => 'Delivery Details', 2 => 'Loading Options', 3 => 'Your Details', 4 => 'Confirmation'] as $num => $label)
                    <div class="tn-step {{ $num == $currentStep ? 'active' : '' }} {{ $num < $currentStep ? 'completed' : '' }}">
                        <div class="tn-step-circle">
                            @if($num < $currentStep)
                                <i class="bi bi-check-lg"></i>
                            @else
                                {{ $num }}
                            @endif
                        </div>
                        <span class="tn-step-label">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Flash Messages --}}
    <main class="tn-main">
        <div class="container">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="tn-footer">
        <div class="container text-center">
            <p class="mb-1">&copy; {{ date('Y') }} Terra Nova Property Services. All rights reserved.</p>
            <p class="mb-0">
                <a href="http://{{ str_replace('deliveries.', '', config('app.deliveries_domain', 'experienceterranova.test')) }}" class="text-decoration-none">
                    experienceterranova.com
                </a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
