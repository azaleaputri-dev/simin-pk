<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMIN-PK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --ink: #18353b;
            --brand: #1e6c7d;
            --brand-dark: #12343b;
            --accent: #e2a64b;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(226, 166, 75, 0.22), transparent 26%),
                linear-gradient(180deg, #fffaf2 0%, #f5ede0 100%);
            color: var(--ink);
        }

        .hero {
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.14), transparent 25%),
                linear-gradient(135deg, var(--brand-dark) 0%, var(--brand) 58%, #4c9cad 100%);
            color: white;
            border-radius: 2rem;
            box-shadow: 0 30px 65px rgba(18, 52, 59, 0.2);
            overflow: hidden;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(24, 53, 59, 0.08);
            border-radius: 1.4rem;
            box-shadow: 0 18px 40px rgba(18, 52, 59, 0.08);
            height: 100%;
        }

        .feature-icon {
            width: 3rem;
            height: 3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            background: rgba(30, 108, 125, 0.12);
            color: var(--brand);
            font-size: 1.2rem;
        }

        .landing-nav {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(24, 53, 59, 0.06);
            border-radius: 1rem;
            padding: 0.8rem 1rem;
        }

        .hero-note {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1.25rem;
        }

        .step-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(24, 53, 59, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 18px 40px rgba(18, 52, 59, 0.08);
            height: 100%;
        }

        .step-badge {
            width: 2.4rem;
            height: 2.4rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            color: #fff;
            font-weight: 700;
            background: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand) 100%);
        }
    </style>
</head>
<body>
    @php($dashboardRoute = auth()->check() ? (auth()->user()->isGuardianUser() ? route('parent.portal') : route('admin.dashboard')) : null)
    @php($dashboardLabel = auth()->check() ? (auth()->user()->isGuardianUser() ? 'Dashboard User' : 'Dashboard Admin') : null)
    <div class="container py-4 py-lg-5">
        <nav class="navbar navbar-expand-lg navbar-light landing-nav mb-4">
            <div class="container-fluid px-0">
                <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">SIMIN-PK</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="landingNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 mt-3 mt-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('ppdb.register') }}">PPDB</a></li>
                        @auth
                            <li class="nav-item"><a class="btn btn-outline-dark" href="{{ $dashboardRoute }}">{{ $dashboardLabel }}</a></li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-dark">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item"><a class="btn btn-outline-dark" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="btn btn-dark" href="{{ route('register') }}">Register Akun</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <section class="hero p-4 p-lg-5 mb-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <div class="small text-uppercase fw-semibold mb-3 opacity-75">Sistem Informasi Sekolah</div>
                    <h1 class="display-4 fw-bold mb-3">Daftar akun dulu, lalu kelola PPDB dan tagihan sekolah dari satu portal.</h1>
                    <p class="lead mb-4">SIMIN-PK membantu sekolah dan orang tua menjalankan alur yang lebih rapi: akun user dibuat lebih dulu, lalu pendaftaran PPDB, upload berkas, status seleksi, dan pembayaran bisa dipantau dari dashboard yang sama.</p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ $dashboardRoute }}" class="btn btn-light btn-lg">{{ $dashboardLabel }}</a>
                            <a href="{{ route('ppdb.register') }}" class="btn btn-outline-light btn-lg">Lanjut ke PPDB</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg">Register Akun</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-note p-4">
                        <div class="small text-uppercase fw-semibold mb-2">Alur Cepat</div>
                        <div class="mb-2">1. Register akun orang tua atau user</div>
                        <div class="mb-2">2. Masuk ke portal untuk isi PPDB</div>
                        <div>3. Pantau berkas, status, dan tagihan dari dashboard</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="step-card p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="step-badge">1</span>
                        <h2 class="h5 mb-0">Register Akun</h2>
                    </div>
                    <p class="text-muted mb-0">User membuat akun lebih dulu agar data pendaftaran, dokumen, dan progres tersimpan aman di sistem.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="step-badge">2</span>
                        <h2 class="h5 mb-0">Isi PPDB di Portal</h2>
                    </div>
                    <p class="text-muted mb-0">Formulir calon siswa diisi dari dashboard user, bukan langsung dari luar, jadi alurnya lebih tertata.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="step-badge">3</span>
                        <h2 class="h5 mb-0">Pantau Hasilnya</h2>
                    </div>
                    <p class="text-muted mb-0">Status verifikasi, catatan admin, kelengkapan berkas, sampai invoice sekolah bisa dicek dari satu tempat.</p>
                </div>
            </div>
        </section>

        <section class="row g-4">
            <div class="col-md-6 col-xl-4">
                <div class="info-card p-4">
                    <div class="feature-icon mb-3"><i class="bi bi-building"></i></div>
                    <h2 class="h5">Administrasi Sekolah</h2>
                    <p class="text-muted mb-0">Kelola profil sekolah, tahun ajaran, kelas, dan data master utama dalam satu tempat.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="info-card p-4">
                    <div class="feature-icon mb-3"><i class="bi bi-person-plus"></i></div>
                    <h2 class="h5">PPDB Online</h2>
                    <p class="text-muted mb-0">Calon siswa didaftarkan lewat portal user setelah akun aktif, lalu diproses sampai menjadi siswa aktif.</p>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="info-card p-4">
                    <div class="feature-icon mb-3"><i class="bi bi-receipt-cutoff"></i></div>
                    <h2 class="h5">Keuangan Sekolah</h2>
                    <p class="text-muted mb-0">Jenis biaya, tarif, invoice, dan pembayaran sekolah dapat dicatat dan diverifikasi lebih mudah.</p>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
