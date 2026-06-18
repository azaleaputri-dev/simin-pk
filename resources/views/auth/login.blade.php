<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akun | SIMIN-PK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #18353b;
            --brand: #1e6c7d;
            --brand-dark: #12343b;
            --accent: #e2a64b;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(226, 166, 75, 0.18), transparent 24%),
                linear-gradient(180deg, #fffaf2 0%, #f5ede0 100%);
            color: var(--ink);
        }

        .login-card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(24, 53, 59, 0.08);
            border-radius: 1.5rem;
            box-shadow: 0 24px 50px rgba(18, 52, 59, 0.08);
        }

        .login-hero {
            background: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand) 58%, #4c9cad 100%);
            color: white;
            border-radius: 1.25rem;
            height: 100%;
        }

        .btn-primary {
            background: var(--brand);
            border-color: var(--brand);
        }

        .section-label {
            color: var(--accent);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
        }

        .password-toggle {
            min-width: 92px;
        }
    </style>
</head>
<body class="d-flex align-items-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="login-card p-3 p-lg-4">
                    <div class="row g-4 align-items-stretch">
                        <div class="col-lg-6">
                            <div class="login-hero p-4 p-lg-5 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="section-label mb-3">Login Terpadu</div>
                                    <h1 class="display-6 fw-bold mb-3">Masuk ke akun admin atau user dari satu pintu.</h1>
                                    <p class="mb-0 opacity-75">Gunakan satu akun login untuk masuk sebagai admin sekolah atau sebagai orang tua/user sesuai data yang terhubung.</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('home') }}" class="btn btn-outline-light">Kembali ke Beranda</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-3 p-lg-4">
                                <h2 class="h3 mb-2">Login</h2>
                                <p class="text-muted mb-4">Masukkan email dan password akun Anda.</p>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        {{ implode(' ', $errors->all()) }}
                                    </div>
                                @endif

                                <form action="{{ route('login.attempt') }}" method="POST">
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
                                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                                </form>
                                <div class="text-center mt-3">
                                    <span class="text-muted">Belum punya akun?</span>
                                    <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Daftar akun dulu</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
