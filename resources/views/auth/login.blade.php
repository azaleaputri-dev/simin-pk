<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akun | SIMIN-PK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body>
    <header class="auth-topbar">
        <div class="container-fluid px-0">
            <nav class="navbar auth-topnav">
                <a class="auth-brand" href="{{ route('home') }}">
                    <span class="auth-brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
                    <span>
                        SIMIN-PK
                        <small>Layanan informasi sekolah</small>
                    </span>
                </a>
            </nav>
        </div>
    </header>

    <main class="auth-page">
        <section class="auth-hero auth-hero-login">
            <div class="container-fluid px-0">
                <div class="row g-0 auth-shell">
                    <div class="col-lg-6">
                        <div class="auth-hero-panel">
                            <div class="auth-hero-inner">
                                <span class="auth-kicker">Akses Layanan</span>
                                <h1 class="auth-title">Masuk ke layanan sekolah secara aman dan terintegrasi.</h1>
                                <p class="auth-description">
                                    Halaman ini digunakan untuk mengakses layanan sekolah, baik untuk kebutuhan administrasi sekolah maupun portal orang tua dan wali murid.
                                </p>

                                <div class="auth-feature-list">
                                    <div><i class="bi bi-check-circle-fill"></i><span>Akses layanan sekolah dalam satu akun</span></div>
                                    <div><i class="bi bi-check-circle-fill"></i><span>Pendaftaran dan informasi administrasi tersimpan lebih rapi</span></div>
                                    <div><i class="bi bi-check-circle-fill"></i><span>Proses login lebih aman dan mudah digunakan</span></div>
                                </div>

                                <div class="auth-hero-actions">
                                    <a href="{{ route('home') }}" class="btn btn-outline-light rounded-pill px-4">Kembali ke Beranda</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="auth-form-panel">
                            <div class="auth-form-inner">
                                <div class="auth-form-header">
                                    <div class="section-label mb-2">Login</div>
                                    <h2 class="mb-2">Masuk ke akun Anda</h2>
                                    <p class="text-muted mb-0">Silakan gunakan email dan password yang telah terdaftar.</p>
                                </div>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        {{ implode(' ', $errors->all()) }}
                                    </div>
                                @endif

                                <form action="{{ route('login.attempt') }}" method="POST" class="auth-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="loginPassword" class="form-control @error('password') is-invalid @enderror" required>
                                            <button type="button" class="btn btn-outline-secondary password-toggle" data-password-target="loginPassword">Lihat</button>
                                        </div>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                                        <label class="form-check-label" for="remember">Tetap masuk di perangkat ini</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary auth-submit w-100">Masuk</button>
                                </form>

                                <div class="position-relative my-4">
                                    <hr>
                                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau</span>
                                </div>

                                @include('auth._google_identity', ['googleButtonText' => 'signin_with'])

                                <div class="auth-footer-note text-center">
                                    <span class="text-muted">Belum memiliki akun?</span>
                                    <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Buat akun pendaftaran</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.querySelectorAll('[data-password-target]').forEach(function (button) {
            button.addEventListener('click', function () {
                var input = document.getElementById(button.getAttribute('data-password-target'));

                if (!input) {
                    return;
                }

                var isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                button.textContent = isPassword ? 'Sembunyi' : 'Lihat';
            });
        });
    </script>
</body>
</html>
