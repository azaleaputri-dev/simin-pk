<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIMIN-PK' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --simin-ink: #12343b;
            --simin-sand: #f4efe6;
            --simin-accent: #1f7a8c;
            --simin-accent-soft: #e2f2f5;
            --simin-gold: #d9a441;
        }

        body {
            background:
                radial-gradient(circle at top right, rgba(31, 122, 140, 0.08), transparent 35%),
                linear-gradient(180deg, #f7f5ef 0%, #f2ede3 100%);
            color: var(--simin-ink);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(18, 52, 59, 0.96);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .navbar .nav-link,
        .navbar .dropdown-toggle {
            color: rgba(255, 255, 255, 0.82);
            font-weight: 500;
        }

        .navbar .nav-link:hover,
        .navbar .dropdown-toggle:hover,
        .navbar .nav-link.active,
        .navbar .dropdown-toggle.active {
            color: #fff;
        }

        .navbar .dropdown-menu {
            border: 1px solid rgba(18, 52, 59, 0.08);
            border-radius: 1rem;
            box-shadow: 0 18px 40px rgba(18, 52, 59, 0.15);
            padding: 0.65rem;
        }

        .navbar .dropdown-item {
            border-radius: 0.7rem;
            padding: 0.55rem 0.8rem;
        }

        .navbar .dropdown-item.active,
        .navbar .dropdown-item:active {
            background: var(--simin-accent-soft);
            color: var(--simin-ink);
        }

        .app-shell {
            padding: 2rem 0 3rem;
        }

        .page-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(18, 52, 59, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 20px 45px rgba(18, 52, 59, 0.08);
        }

        .stat-card {
            border-radius: 1rem;
            border: 1px solid rgba(18, 52, 59, 0.08);
            background: white;
            padding: 1.25rem;
            height: 100%;
        }

        .stat-card small {
            color: #59757b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.75rem;
        }

        .stat-card strong {
            display: block;
            font-size: 2rem;
            margin-top: 0.35rem;
        }

        .section-label {
            color: var(--simin-accent);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
        }

        .btn-primary {
            background: var(--simin-accent);
            border-color: var(--simin-accent);
        }

        .btn-outline-primary {
            color: var(--simin-accent);
            border-color: var(--simin-accent);
        }
    </style>
</head>
<body>
    @php($isParentPortal = request()->routeIs('parent.portal'))
    @php($loggedInUser = auth()->user())
    @php($isGuardianUser = $loggedInUser?->isGuardianUser() ?? false)
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ $isGuardianUser ? route('parent.portal') : route('admin.dashboard') }}">SIMIN-PK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                @if($isParentPortal)
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda Publik</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('ppdb.register') }}">Daftar PPDB</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('parent.portal') ? 'active' : '' }}" href="{{ route('parent.portal') }}">Portal Orang Tua</a></li>
                        @auth
                            @unless($isGuardianUser)
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Area Admin</a></li>
                            @endunless
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-light ms-lg-2">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login Admin</a></li>
                        @endauth
                    </ul>
                @elseif(! $isGuardianUser)
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda Publik</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('ppdb.register') }}">Form PPDB</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('profil-sekolahs.*', 'academic-years.*', 'kelas.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                Master Sekolah
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item {{ request()->routeIs('profil-sekolahs.*') ? 'active' : '' }}" href="{{ route('profil-sekolahs.index') }}">Profil Sekolah</a></li>
                                <li><a class="dropdown-item {{ request()->routeIs('academic-years.*') ? 'active' : '' }}" href="{{ route('academic-years.index') }}">Tahun Ajaran</a></li>
                                <li><a class="dropdown-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}" href="{{ route('kelas.index') }}">Kelas</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('ppdb.*', 'parents.*', 'students.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                Akademik
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item {{ request()->routeIs('ppdb.*') ? 'active' : '' }}" href="{{ route('ppdb.index') }}">PPDB</a></li>
                                <li><a class="dropdown-item {{ request()->routeIs('parents.*') ? 'active' : '' }}" href="{{ route('parents.index') }}">Orang Tua</a></li>
                                <li><a class="dropdown-item {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">Siswa</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('fee-types.*', 'tariffs.*', 'invoices.*', 'payments.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                Keuangan
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item {{ request()->routeIs('fee-types.*') ? 'active' : '' }}" href="{{ route('fee-types.index') }}">Jenis Biaya</a></li>
                                <li><a class="dropdown-item {{ request()->routeIs('tariffs.*') ? 'active' : '' }}" href="{{ route('tariffs.index') }}">Tarif</a></li>
                                <li><a class="dropdown-item {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">Invoice</a></li>
                                <li><a class="dropdown-item {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">Pembayaran</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('parent.portal') ? 'active' : '' }}" href="{{ route('parent.portal') }}">Portal Orang Tua</a></li>
                        <li class="nav-item"><span class="nav-link">{{ $loggedInUser?->name ?? 'Admin' }}</span></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light ms-lg-2">Logout</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda Publik</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('parent.portal') ? 'active' : '' }}" href="{{ route('parent.portal') }}">Portal Orang Tua</a></li>
                        <li class="nav-item"><span class="nav-link">{{ $loggedInUser?->name ?? 'User' }}</span></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light ms-lg-2">Logout</button>
                            </form>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <main class="app-shell">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
