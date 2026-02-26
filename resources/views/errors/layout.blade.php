<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Terra Nova Property Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css?v=1') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <style>
        .error-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: relative;
            overflow: hidden;
        }
        .error-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="snow" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23snow)"/></svg>');
            animation: snowfall 20s linear infinite;
            pointer-events: none;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            opacity: .15;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            user-select: none;
        }
        .error-card {
            background: rgba(255,255,255,.95);
            border-radius: 1.5rem;
            padding: 3rem 2.5rem;
            max-width: 540px;
            width: 100%;
            text-align: center;
            box-shadow: 0 1rem 3rem rgba(0,0,0,.2);
            position: relative;
            z-index: 1;
        }
        .error-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .error-card h1 {
            font-weight: 700;
            color: var(--text-dark);
        }
        .error-card p {
            color: var(--text-light);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #000015 !important;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <img src="{{ asset('assets/terranova.png?v=1') }}" alt="Terra Nova" style="height: 48px;">
            </a>
            <div class="ms-auto">
                <a href="/" class="btn btn-outline-light btn-sm"><i class="bi bi-house me-1"></i>Home</a>
                <a href="tel:+14315577346" class="btn btn-primary btn-sm ms-2"><i class="bi bi-telephone me-1"></i>431‑557‑7346</a>
            </div>
        </div>
    </nav>

    <section class="error-section">
        <span class="error-code">@yield('code')</span>
        <div class="error-card">
            <div class="error-icon">@yield('icon')</div>
            <h1 class="mb-2">@yield('title')</h1>
            <p class="lead mb-4">@yield('message')</p>
            @yield('extra')
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="/" class="btn btn-primary"><i class="bi bi-house me-2"></i>Back to Home</a>
                <a href="tel:+14315577346" class="btn btn-outline-secondary"><i class="bi bi-telephone me-2"></i>Call Us</a>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
