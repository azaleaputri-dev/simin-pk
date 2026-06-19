<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Akun | SIMIN-PK</title>
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
        <section class="auth-hero auth-hero-register">
            <div class="container-fluid px-0">
                <div class="row g-0 auth-shell">
                    <div class="col-lg-6">
                        <div class="auth-hero-panel">
                            <div class="auth-hero-inner">
                                <span class="auth-kicker">Pendaftaran Akun</span>
                                <h1 class="auth-title">Buat akun orang tua atau wali untuk memulai proses pendaftaran.</h1>
                                <p class="auth-description">
                                    Akun ini akan digunakan sebagai akses resmi untuk melanjutkan pendaftaran peserta didik baru, melengkapi dokumen, dan memantau informasi lanjutan dari sekolah.
                                </p>

                                <div class="auth-feature-list">
                                    <div><i class="bi bi-check-circle-fill"></i><span>Proses pendaftaran dimulai dari akun resmi orang tua atau wali</span></div>
                                    <div><i class="bi bi-check-circle-fill"></i><span>Dokumen dan data pendaftaran tersimpan dalam satu akses</span></div>
                                    <div><i class="bi bi-check-circle-fill"></i><span>Informasi lanjutan sekolah dapat dipantau secara lebih tertib</span></div>
                                </div>

                                <div class="auth-hero-actions d-flex gap-2 flex-wrap">
                                    <a href="{{ route('home') }}" class="btn btn-outline-light rounded-pill px-4">Kembali ke Beranda</a>
                                    <a href="{{ route('login') }}" class="btn btn-light rounded-pill px-4">Sudah Punya Akun</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="auth-form-panel">
                            <div class="auth-form-inner">
                                <div class="auth-form-header">
                                    <div class="section-label mb-2">Register</div>
                                    <h2 class="mb-2">Buat akun pendaftaran</h2>
                                    <p class="text-muted mb-0">Lengkapi data dasar berikut untuk membuat akun orang tua atau wali murid.</p>
                                </div>

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        {{ implode(' ', $errors->all()) }}
                                    </div>
                                @endif

                                <form action="{{ route('register') }}" method="POST" class="auth-form" data-emsifa-region>
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
                                    <div class="row g-3 mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Jalan / Detail Alamat</label>
                                            <textarea name="address_detail" class="form-control" rows="3">{{ old('address_detail') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Provinsi</label>
                                            <select
                                                name="provinsi"
                                                class="form-select"
                                                data-emsifa-level="province"
                                                data-current="{{ old('provinsi') }}"
                                            >
                                                <option value="">Pilih Provinsi</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kabupaten / Kota</label>
                                            <select
                                                name="kabupaten"
                                                class="form-select"
                                                data-emsifa-level="regency"
                                                data-current="{{ old('kabupaten') }}"
                                                disabled
                                            >
                                                <option value="">Pilih Kabupaten / Kota</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kecamatan</label>
                                            <select
                                                name="kecamatan"
                                                class="form-select"
                                                data-emsifa-level="district"
                                                data-current="{{ old('kecamatan') }}"
                                                disabled
                                            >
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kelurahan</label>
                                            <select
                                                name="kelurahan"
                                                class="form-select"
                                                data-emsifa-level="village"
                                                data-current="{{ old('kelurahan') }}"
                                                disabled
                                            >
                                                <option value="">Pilih Kelurahan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Kode Pos</label>
                                            <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="registerPassword" class="form-control" required>
                                            <button type="button" class="btn btn-outline-secondary password-toggle" data-password-target="registerPassword">Lihat</button>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="registerPasswordConfirmation" class="form-control" required>
                                            <button type="button" class="btn btn-outline-secondary password-toggle" data-password-target="registerPasswordConfirmation">Lihat</button>
                                        </div>
                                        <div class="password-match-message" id="passwordMatchMessage">Konfirmasi password harus sama dengan password di atas.</div>
                                        <div class="password-checklist" id="passwordChecklist">
                                            <div class="password-check-item" data-password-rule="length">Minimal 8 karakter</div>
                                            <div class="password-check-item" data-password-rule="upper">Mengandung huruf besar</div>
                                            <div class="password-check-item" data-password-rule="lower">Mengandung huruf kecil</div>
                                            <div class="password-check-item" data-password-rule="number">Mengandung angka</div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary auth-submit w-100">Buat Akun</button>
                                </form>

                                <div class="position-relative my-4">
                                    <hr>
                                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau</span>
                                </div>

                                <div id="g_id_onload"
                                    data-client_id="{{ config('services.google.client_id') }}"
                                    data-context="signup"
                                    data-ux_mode="popup"
                                    data-callback="handleGoogleCredential"
                                    data-auto_prompt="false">
                                </div>
                                <div class="g_id_signin w-100 d-flex justify-content-center"
                                    data-type="standard"
                                    data-shape="rectangular"
                                    data-theme="outline"
                                    data-text="continue_with"
                                    data-size="large"
                                    data-width="400"
                                    data-logo_alignment="left">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function handleGoogleCredential(response) {
            if (!response.credential) {
                return;
            }

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('auth.google') }}';

            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            var token = document.createElement('input');
            token.type = 'hidden';
            token.name = 'id_token';
            token.value = response.credential;
            form.appendChild(token);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
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
    @include('components.forms._emsifa_region_script')
</body>
</html>
