<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Akun | SIMIN-PK</title>
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

        .register-card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(24, 53, 59, 0.08);
            border-radius: 1.5rem;
            box-shadow: 0 24px 50px rgba(18, 52, 59, 0.08);
        }

        .register-hero {
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

        .password-checklist {
            display: grid;
            gap: 0.35rem;
            margin-top: 0.85rem;
            padding: 0.85rem 1rem;
            border-radius: 1rem;
            background: rgba(24, 53, 59, 0.05);
            border: 1px solid rgba(24, 53, 59, 0.08);
        }

        .password-check-item {
            font-size: 0.9rem;
            color: rgba(24, 53, 59, 0.72);
        }

        .password-check-item.is-valid {
            color: #198754;
            font-weight: 600;
        }

        .password-match-message {
            font-size: 0.9rem;
            margin-top: 0.65rem;
            color: rgba(24, 53, 59, 0.72);
        }

        .password-match-message.is-valid {
            color: #198754;
            font-weight: 600;
        }

        .password-match-message.is-invalid {
            color: #dc3545;
            font-weight: 600;
        }
    </style>
</head>
<body class="d-flex align-items-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="register-card p-3 p-lg-4">
                    <div class="row g-4 align-items-stretch">
                        <div class="col-lg-6">
                            <div class="register-hero p-4 p-lg-5 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="section-label mb-3">Langkah 1</div>
                                    <h1 class="display-6 fw-bold mb-3">Buat akun orang tua/user lebih dulu.</h1>
                                    <p class="mb-0 opacity-75">Setelah akun aktif, Anda akan masuk ke portal user untuk lanjut mengisi formulir PPDB dari dalam sistem.</p>
                                </div>
                                <div class="mt-4 d-flex gap-2 flex-wrap">
                                    <a href="{{ route('home') }}" class="btn btn-outline-light">Kembali ke Beranda</a>
                                    <a href="{{ route('login') }}" class="btn btn-light">Sudah punya akun</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-3 p-lg-4">
                                <h2 class="h3 mb-2">Register Akun</h2>
                                <p class="text-muted mb-4">Isi data akun dasar dulu. Form PPDB siswa diisi setelah akun berhasil dibuat.</p>

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        {{ implode(' ', $errors->all()) }}
                                    </div>
                                @endif

                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No. HP</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="registerPassword" class="form-control" required>
                                            <button type="button" class="btn btn-outline-secondary password-toggle" data-password-target="registerPassword">Lihat</button>
                                        </div>
                                        <div class="password-checklist" id="passwordChecklist">
                                            <div class="password-check-item" data-password-rule="length">Minimal 8 karakter</div>
                                            <div class="password-check-item" data-password-rule="upper">Ada huruf besar</div>
                                            <div class="password-check-item" data-password-rule="lower">Ada huruf kecil</div>
                                            <div class="password-check-item" data-password-rule="number">Ada angka</div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="registerPasswordConfirmation" class="form-control" required>
                                            <button type="button" class="btn btn-outline-secondary password-toggle" data-password-target="registerPasswordConfirmation">Lihat</button>
                                        </div>
                                        <div class="password-match-message" id="passwordMatchMessage">Konfirmasi password harus sama dengan password di atas.</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Buat Akun</button>
                                </form>
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

        var passwordInput = document.getElementById('registerPassword');
        var passwordConfirmationInput = document.getElementById('registerPasswordConfirmation');
        var passwordMatchMessage = document.getElementById('passwordMatchMessage');

        function updatePasswordRules() {
            if (!passwordInput) {
                return;
            }

            var value = passwordInput.value;
            var checks = {
                length: value.length >= 8,
                upper: /[A-Z]/.test(value),
                lower: /[a-z]/.test(value),
                number: /\d/.test(value),
            };

            document.querySelectorAll('[data-password-rule]').forEach(function (item) {
                var rule = item.getAttribute('data-password-rule');
                item.classList.toggle('is-valid', Boolean(checks[rule]));
            });
        }

        function updatePasswordMatch() {
            if (!passwordInput || !passwordConfirmationInput || !passwordMatchMessage) {
                return;
            }

            var password = passwordInput.value;
            var confirmation = passwordConfirmationInput.value;

            passwordMatchMessage.classList.remove('is-valid', 'is-invalid');

            if (!confirmation.length) {
                passwordMatchMessage.textContent = 'Konfirmasi password harus sama dengan password di atas.';
                return;
            }

            if (password === confirmation) {
                passwordMatchMessage.textContent = 'Konfirmasi password sudah cocok.';
                passwordMatchMessage.classList.add('is-valid');
                return;
            }

            passwordMatchMessage.textContent = 'Konfirmasi password belum sama.';
            passwordMatchMessage.classList.add('is-invalid');
        }

        if (passwordInput && passwordConfirmationInput) {
            passwordInput.addEventListener('input', function () {
                updatePasswordRules();
                updatePasswordMatch();
            });

            passwordConfirmationInput.addEventListener('input', updatePasswordMatch);

            updatePasswordRules();
            updatePasswordMatch();
        }
    </script>
</body>
</html>
