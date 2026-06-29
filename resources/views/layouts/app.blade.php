<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BIUperpus')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <style>
        body { background: #f6f8fb; }
        .book-cover { aspect-ratio: 3 / 4; object-fit: cover; width: 100%; }
        .stat-card { border: 0; border-radius: 8px; }
        .btn-primary, .btn-success {
            --bs-btn-bg: #168a5b;
            --bs-btn-border-color: #168a5b;
            --bs-btn-hover-bg: #106f49;
            --bs-btn-hover-border-color: #106f49;
            --bs-btn-active-bg: #0d5d3e;
            --bs-btn-active-border-color: #0d5d3e;
        }
        .btn-outline-primary, .btn-outline-secondary {
            --bs-btn-color: #168a5b;
            --bs-btn-border-color: #168a5b;
            --bs-btn-hover-bg: #168a5b;
            --bs-btn-hover-border-color: #168a5b;
            --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: #106f49;
            --bs-btn-active-border-color: #106f49;
        }
        .btn-danger {
            --bs-btn-bg: #dc3545;
            --bs-btn-border-color: #dc3545;
            --bs-btn-hover-bg: #bb2d3b;
            --bs-btn-hover-border-color: #bb2d3b;
        }
        .btn-outline-danger {
            --bs-btn-color: #dc3545;
            --bs-btn-border-color: #dc3545;
            --bs-btn-hover-bg: #dc3545;
            --bs-btn-hover-border-color: #dc3545;
            --bs-btn-hover-color: #fff;
        }
        .hero {
            min-height: 78vh;
            background-image: linear-gradient(rgba(20, 24, 32, .48), rgba(20, 24, 32, .48)), url('{{ asset('assets/img/bg-1.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        .site-header {
            min-height: 72px;
            background: rgba(10, 24, 34, .92);
            border-bottom: 1px solid rgba(255,255,255,.12);
            display: flex;
            align-items: center;
        }
        .site-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }
        .site-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #fff !important;
            text-decoration: none;
            font-weight: 800;
            letter-spacing: .03em;
        }
        .site-brand img {
            width: 38px;
            height: 34px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,.28));
        }
        .site-menu {
            display: flex;
            align-items: center;
            gap: 26px;
            font-size: .76rem;
            font-weight: 800;
            letter-spacing: .03em;
        }
        .site-menu form {
            margin: 0;
        }
        .site-menu a, .site-menu button {
            color: rgba(255,255,255,.86) !important;
            text-decoration: none;
            background: transparent;
            border: 0;
            padding: 24px 0 20px;
            border-bottom: 3px solid transparent;
            font: inherit;
        }
        .site-menu a:hover, .site-menu a.active, .site-menu button:hover {
            color: #fff !important;
            border-color: #168a5b;
        }
        .site-footer {
            background: #062947;
            color: rgba(255,255,255,.76);
            text-align: center;
            padding: 22px 16px;
        }
        .site-footer small {
            color: rgba(255,255,255,.76) !important;
        }
        @media (max-width: 991.98px) {
            .site-header .container {
                align-items: flex-start;
                flex-direction: column;
                padding-top: 16px;
                padding-bottom: 16px;
            }
            .site-menu {
                flex-wrap: wrap;
                gap: 12px 18px;
            }
            .site-menu a, .site-menu button {
                padding: 0 0 6px;
            }
        }
    </style>
</head>
<body>
    @if (! $__env->hasSection('hide_shell') && ! $__env->hasSection('hide_header'))
        <header class="site-header">
            <div class="container">
                <a class="site-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo kampus">
                    <span>BIUperpus</span>
                </a>
                <nav class="site-menu">
                    <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">HOME</a>
                    <a href="{{ route('home') }}#features">FEATURE</a>
                    <a href="{{ route('books.index') }}">BOOKS</a>
                    <a href="{{ route('dashboard') }}">DASHBOARD</a>
                    @auth
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">LOGOUT</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">LOGIN</a>
                    @endauth
                </nav>
            </div>
        </header>
    @endif

    <main>
        @if (session('status'))
            <div class="container mt-3">
                <div class="alert alert-success">{{ session('status') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="container mt-3">
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    @if (! $__env->hasSection('hide_shell') && ! $__env->hasSection('hide_footer'))
        <footer class="site-footer">
            <small>&copy; {{ date('Y') }} BIUperpus.</small>
        </footer>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
