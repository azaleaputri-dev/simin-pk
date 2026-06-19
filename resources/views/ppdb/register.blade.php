<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar PPDB | SIMIN-PK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #18353b;
            --brand: #1e6c7d;
            --brand-dark: #12343b;
            --accent: #e2a64b;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(226, 166, 75, 0.18), transparent 24%),
                linear-gradient(180deg, #fffaf2 0%, #f5ede0 100%);
            color: var(--ink);
        }

        .public-nav {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(24, 53, 59, 0.06);
            border-radius: 1rem;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(24, 53, 59, 0.08);
            border-radius: 1.5rem;
            box-shadow: 0 24px 50px rgba(18, 52, 59, 0.08);
        }

        .section-label {
            color: var(--brand);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
        }

        .btn-primary {
            background: var(--brand);
            border-color: var(--brand);
        }

        .flow-card {
            border: 1px solid rgba(24, 53, 59, 0.08);
            border-radius: 1.25rem;
            padding: 1.1rem;
            height: 100%;
        }
        .flow-card:nth-child(1) {
            background: linear-gradient(180deg, rgba(255,255,255,0.98) 0%, rgba(31, 122, 140, 0.07) 100%);
        }
        .flow-card:nth-child(2) {
            background: linear-gradient(180deg, rgba(255,255,255,0.98) 0%, rgba(226, 166, 75, 0.07) 100%);
        }
        .flow-card:nth-child(3) {
            background: linear-gradient(180deg, rgba(255,255,255,0.98) 0%, rgba(246, 242, 234, 0.9) 100%);
        }

        .flow-step-badge {
            width: 2.15rem;
            height: 2.15rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 700;
            color: #fff;
        }
        .flow-card:nth-child(1) .flow-step-badge {
            background: linear-gradient(135deg, #12343b 0%, #1e6c7d 100%);
        }
        .flow-card:nth-child(2) .flow-step-badge {
            background: linear-gradient(135deg, #b8860b 0%, #e2a64b 100%);
        }
        .flow-card:nth-child(3) .flow-step-badge {
            background: linear-gradient(135deg, #6b5d4b 0%, #a09080 100%);
        }

        .benefit-list {
            display: grid;
            gap: 0.8rem;
        }

        .benefit-item {
            border-radius: 1rem;
            background: rgba(24, 53, 59, 0.05);
            border: 1px solid rgba(24, 53, 59, 0.06);
            padding: 0.9rem 1rem;
        }
        .benefit-item:first-child {
            background: rgba(31, 122, 140, 0.06);
            border-color: rgba(31, 122, 140, 0.12);
        }
        .benefit-item:last-child {
            background: rgba(226, 166, 75, 0.06);
            border-color: rgba(226, 166, 75, 0.12);
        }

        .form-section-header {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 1rem;
        }
        .form-section-header.siswa {
            background: rgba(31, 122, 140, 0.1);
            color: #1e6c7d;
        }
        .form-section-header.orangtua {
            background: rgba(226, 166, 75, 0.12);
            color: #b8860b;
        }
        .form-section-header.ppdb {
            background: rgba(180, 165, 140, 0.15);
            color: #6b5d4b;
        }
    </style>
</head>
<body>
    @php($dashboardRoute = auth()->check() ? (auth()->user()->isGuardianUser() ? route('parent.portal') : route('admin.dashboard')) : null)
    @php($dashboardLabel = auth()->check() ? (auth()->user()->isGuardianUser() ? 'Dashboard User' : 'Dashboard Admin') : null)
    <div class="container py-4 py-lg-5">
        <nav class="navbar navbar-expand-lg navbar-light public-nav px-3 px-lg-4 mb-4">
            <div class="container-fluid px-0">
                <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">SIMIN-PK</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="publicNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 mt-3 mt-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('ppdb.register') }}">Daftar PPDB</a></li>
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
                            <li class="nav-item"><a class="btn btn-primary" href="{{ route('register') }}">Register Akun</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="form-card p-4 p-lg-5">
                    <div class="section-label mb-2">Pendaftaran Peserta Didik Baru</div>
                    <h1 class="h2 mb-3">{{ auth()->check() ? 'Formulir PPDB Online' : 'Register Akun Terlebih Dahulu' }}</h1>
                    <p class="text-muted mb-4">
                        {{ auth()->check()
                            ? 'Isi data calon siswa dan data orang tua dengan lengkap. Setelah dikirim, tim admin sekolah akan meninjau pendaftaran Anda.'
                            : 'Sebelum mengisi formulir PPDB, buat akun orang tua/user dulu agar pendaftaran tersimpan di dashboard Anda.' }}
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ implode(' ', $errors->all()) }}
                        </div>
                    @endif

                    @auth
                        <form action="{{ route('ppdb.submit') }}" method="POST">
                            @php($ppdb = $draftPpdb ?? null)
                            @php($submitLabel = 'Kirim Pendaftaran')
                            @php($showAdminFields = false)
                            @php($backUrl = auth()->check() && auth()->user()->isGuardianUser() ? route('parent.portal') : route('home'))
                            @php($backLabel = auth()->check() && auth()->user()->isGuardianUser() ? 'Kembali ke Dashboard User' : 'Kembali ke Beranda')
                            @include('ppdb.form')
                        </form>
                    @else
                        <div class="border rounded-4 p-4 bg-white">
                            <div class="row g-4 align-items-center">
                                <div class="col-lg-7">
                                    <div class="section-label mb-2">Alur Pendaftaran</div>
                                    <h3 class="h4 mb-2">Daftar akun dulu, lalu lanjut isi PPDB dari dashboard user.</h3>
                                    <p class="text-muted mb-0">Akun dipakai untuk menyimpan progres pendaftaran, upload berkas, memantau status seleksi, dan melihat catatan admin sekolah tanpa mulai ulang dari awal.</p>
                                </div>
                                <div class="col-lg-5 text-lg-end d-flex gap-2 justify-content-lg-end flex-wrap">
                                    <a href="{{ route('register') }}" class="btn btn-primary">Register Akun</a>
                                    <a href="{{ route('login') }}" class="btn btn-outline-dark">Sudah Punya Akun</a>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <div class="flow-card">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="flow-step-badge">1</span>
                                            <div class="fw-semibold">Buat akun</div>
                                        </div>
                                        <p class="text-muted small mb-0">Isi nama, email, nomor HP, dan password untuk mengaktifkan akun orang tua atau user.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flow-card">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="flow-step-badge">2</span>
                                            <div class="fw-semibold">Masuk ke portal</div>
                                        </div>
                                        <p class="text-muted small mb-0">Setelah register berhasil, akun akan diarahkan ke dashboard user untuk mengelola pendaftaran.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="flow-card">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="flow-step-badge">3</span>
                                            <div class="fw-semibold">Isi PPDB</div>
                                        </div>
                                        <p class="text-muted small mb-0">Lengkapi formulir calon siswa, upload dokumen, lalu pantau proses verifikasi sampai hasil akhir.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="benefit-list mt-4">
                                <div class="benefit-item">
                                    <div class="fw-semibold mb-1">Progress tidak hilang</div>
                                    <div class="small text-muted">Data akun dan dokumen tetap terhubung ke dashboard user, jadi lebih mudah dilanjutkan kapan saja.</div>
                                </div>
                                <div class="benefit-item">
                                    <div class="fw-semibold mb-1">Pantau status dari satu tempat</div>
                                    <div class="small text-muted">Status PPDB, catatan admin, dan berkas yang masih kurang bisa dicek langsung dari portal akun.</div>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
