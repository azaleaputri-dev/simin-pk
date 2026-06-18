<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $schoolProfile?->nama_sekolah ?? 'SIMIN-PK' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
</head>
<body>
    @php($dashboardRoute = auth()->check() ? (auth()->user()->isGuardianUser() ? route('parent.portal') : route('admin.dashboard')) : null)
    @php($dashboardLabel = auth()->check() ? (auth()->user()->isGuardianUser() ? 'Portal Orang Tua' : 'Dashboard Admin') : null)
    @php($schoolName = $schoolProfile?->nama_sekolah ?? 'SIMIN-PK')
    @php($schoolDescription = $schoolProfile?->deskripsi ?: 'Lembaga pendidikan yang menghadirkan layanan informasi sekolah, penerimaan peserta didik baru, dan komunikasi administrasi secara lebih tertata, cepat, dan profesional.')
    @php($schoolAddress = collect([$schoolProfile?->alamat, $schoolProfile?->kecamatan, $schoolProfile?->kabupaten, $schoolProfile?->provinsi])->filter()->implode(', '))

    <header class="site-header">
        <div class="container-fluid px-0">
            <div class="container">
            <nav class="navbar navbar-expand-lg py-3">
                <a class="navbar-brand site-brand" href="{{ route('home') }}">
                    <span class="site-brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
                    <span>
                        {{ $schoolName }}
                        <small>{{ $activeAcademicYear?->name ? 'Tahun ajaran ' . $activeAcademicYear->name : 'Sistem informasi sekolah' }}</small>
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="landingNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3 mt-3 mt-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
                        <li class="nav-item"><a class="nav-link" href="#keunggulan">Keunggulan</a></li>
                        <li class="nav-item"><a class="nav-link" href="#ppdb">PPDB</a></li>
                        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                        @auth
                            <li class="nav-item"><a class="btn btn-outline-primary rounded-pill px-4" href="{{ $dashboardRoute }}">{{ $dashboardLabel }}</a></li>
                        @else
                            <li class="nav-item"><a class="btn btn-outline-primary rounded-pill px-4" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="btn btn-warning rounded-pill px-4" href="{{ route('register') }}">Register Akun</a></li>
                        @endauth
                    </ul>
                </div>
            </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="hero-banner-section">
            <div class="container-fluid px-0">
                <div class="hero-banner-card">
                    <div class="container">
                        <div class="row align-items-center g-4">
                            <div class="col-lg-7">
                            <span class="hero-kicker">Website Resmi</span>
                            <h1 class="hero-heading">{{ $schoolName }}</h1>
                            <p class="hero-copy">{{ $schoolDescription }}</p>

                                <div class="hero-meta">
                                    @if($schoolProfile?->akreditasi)
                                        <span class="hero-chip"><i class="bi bi-patch-check-fill"></i> Akreditasi {{ $schoolProfile->akreditasi }}</span>
                                    @endif
                                    @if($schoolProfile?->status)
                                        <span class="hero-chip"><i class="bi bi-building-check"></i> {{ ucfirst($schoolProfile->status) }}</span>
                                    @endif
                                    @if($activeAcademicYear?->name)
                                        <span class="hero-chip"><i class="bi bi-calendar-range"></i> {{ $activeAcademicYear->name }}</span>
                                    @endif
                                </div>

                                <div class="hero-actions">
                                    <a href="{{ route('ppdb.register') }}" class="btn btn-warning btn-lg rounded-pill px-4">
                                        <i class="bi bi-pencil-square"></i>
                                        Pendaftaran PPDB
                                    </a>
                                    @auth
                                        <a href="{{ $dashboardRoute }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                                            <i class="bi bi-grid-1x2-fill"></i>
                                            {{ $dashboardLabel }}
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                            Masuk
                                        </a>
                                    @endauth
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="hero-banner-side">
                                    <div class="hero-side-card">
                                        <div class="hero-side-label">Informasi Sekolah</div>
                                        <ul class="hero-side-list">
                                            <li><i class="bi bi-geo-alt-fill"></i> {{ $schoolAddress ?: 'Informasi alamat sekolah akan segera diperbarui.' }}</li>
                                            <li><i class="bi bi-telephone-fill"></i> {{ $schoolProfile?->telepon ?: 'Kontak telepon sekolah akan segera diperbarui.' }}</li>
                                            <li><i class="bi bi-envelope-fill"></i> {{ $schoolProfile?->email ?: 'Alamat email sekolah akan segera diperbarui.' }}</li>
                                            <li><i class="bi bi-person-badge-fill"></i> Kepala Sekolah: {{ $schoolProfile?->kepala_sekolah ?: '-' }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="section-block" id="profil">
            <div class="container">
                <div class="row g-4 mb-5">
                    <div class="col-lg-7">
                        <div class="welcome-panel h-100">
                            <span class="section-kicker">Sambutan</span>
                            <h2 class="section-title">Selamat datang di layanan informasi resmi {{ $schoolName }}</h2>
                            <p class="section-text mb-0">
                                Kami berkomitmen menghadirkan pelayanan pendidikan yang terbuka, tertata, dan mudah diakses. Melalui website ini, masyarakat dapat memperoleh informasi sekolah, mengikuti proses penerimaan peserta didik baru, serta memantau kebutuhan administrasi dengan lebih nyaman.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="value-panel h-100">
                            <div class="value-panel-title">Nilai Layanan</div>
                            <div class="value-list">
                                <div><i class="bi bi-shield-check"></i><span>Transparan dalam informasi dan proses layanan</span></div>
                                <div><i class="bi bi-people-fill"></i><span>Ramah bagi orang tua, siswa, dan masyarakat</span></div>
                                <div><i class="bi bi-award-fill"></i><span>Profesional dalam pengelolaan administrasi sekolah</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="section-intro">
                            <span class="section-kicker">Profil Sekolah</span>
                            <h2 class="section-title">Membangun lingkungan pendidikan yang tertata dan terpercaya</h2>
                            <p class="section-text">{{ $schoolDescription }}</p>
                            <div class="profile-info-grid">
                                <div class="profile-info-item">
                                    <span>Tahun Berdiri</span>
                                    <strong>{{ $schoolProfile?->tahun_berdiri ?: '-' }}</strong>
                                </div>
                                <div class="profile-info-item">
                                    <span>Alamat</span>
                                    <strong>{{ $schoolAddress ?: '-' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="profile-highlight-card">
                            <div class="highlight-badge"><i class="bi bi-book-half"></i> Layanan Terintegrasi</div>
                            <h3>Informasi akademik dan administrasi tersaji dalam satu layanan sekolah</h3>
                            <p>Melalui website ini, sekolah menghadirkan informasi profil, layanan pendaftaran peserta didik baru, serta akses administrasi yang lebih tertata bagi pihak sekolah maupun orang tua.</p>
                            <div class="highlight-points">
                                <div><i class="bi bi-check-circle-fill"></i> Informasi sekolah tersusun lebih rapi dan mudah diakses</div>
                                <div><i class="bi bi-check-circle-fill"></i> Proses pendaftaran dilakukan melalui akun resmi orang tua</div>
                                <div><i class="bi bi-check-circle-fill"></i> Dokumen dan administrasi terdokumentasi dengan lebih baik</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-block section-soft" id="keunggulan">
            <div class="container">
                <div class="text-center section-head mb-5">
                    <span class="section-kicker">Keunggulan</span>
                    <h2 class="section-title">Layanan digital sekolah yang mendukung proses pendidikan dan administrasi</h2>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-xl-4">
                        <div class="feature-card h-100">
                            <div class="feature-icon"><i class="bi bi-buildings-fill"></i></div>
                            <h3>Informasi Sekolah</h3>
                            <p>Profil sekolah, data akademik, dan informasi pendukung tersaji lebih terstruktur untuk kebutuhan publik maupun internal.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="feature-card h-100">
                            <div class="feature-icon"><i class="bi bi-person-plus-fill"></i></div>
                            <h3>Penerimaan Peserta Didik Baru</h3>
                            <p>Proses pendaftaran calon peserta didik dilakukan secara lebih terarah melalui akun resmi orang tua atau wali.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="feature-card h-100">
                            <div class="feature-icon"><i class="bi bi-wallet2"></i></div>
                            <h3>Administrasi Pembayaran</h3>
                            <p>Pengelolaan tagihan dan konfirmasi pembayaran sekolah dilakukan melalui sistem yang lebih tertib dan terdokumentasi.</p>
                        </div>
                    </div>
                </div>

                @if($facilities->isNotEmpty())
                    <div class="facilities-box mt-4">
                        <div class="facilities-title">Fasilitas Sekolah</div>
                        <div class="facilities-list">
                            @foreach($facilities as $facility)
                                <span class="facility-chip"><i class="bi bi-star-fill"></i> {{ $facility }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="section-block" id="ppdb">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <span class="section-kicker">Alur PPDB</span>
                        <h2 class="section-title">Tahapan pendaftaran yang jelas dan terstruktur</h2>
                        <p class="section-text">Setiap proses dirancang agar calon orang tua atau wali murid memperoleh alur pendaftaran yang mudah dipahami sejak awal hingga tahap akhir.</p>
                    </div>
                    <div class="col-lg-7">
                        <div class="timeline-card">
                            <div class="timeline-item">
                                <div class="timeline-number">1</div>
                                <div>
                                    <h3>Membuat akun orang tua atau wali</h3>
                                    <p>Akun digunakan sebagai akses resmi untuk memulai proses pendaftaran peserta didik baru.</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-number">2</div>
                                <div>
                                    <h3>Melengkapi formulir dan dokumen</h3>
                                    <p>Data calon peserta didik beserta dokumen pendukung dilengkapi melalui portal yang telah tersedia.</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-number">3</div>
                                <div>
                                    <h3>Memantau hasil dan informasi lanjutan</h3>
                                    <p>Status verifikasi, pengumuman hasil, dan informasi administrasi dapat dipantau secara berkala.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-block contact-section" id="kontak">
            <div class="container">
                <div class="contact-banner">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-8">
                            <span class="section-kicker text-warning">Hubungi Sekolah</span>
                            <h2 class="section-title text-white mb-2">Siap memulai proses pendaftaran?</h2>
                            <p class="contact-text mb-0">Silakan membuat akun orang tua atau wali murid untuk melanjutkan proses pendaftaran peserta didik baru secara online.</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-actions">
                                <a href="{{ route('register') }}" class="btn btn-warning btn-lg rounded-pill w-100">
                                    <i class="bi bi-person-plus-fill"></i>
                                    Buat Akun Pendaftaran
                                </a>
                            </div>
                            <div class="contact-list mt-3">
                                @if($schoolProfile?->telepon)
                                    <div><i class="bi bi-telephone-fill"></i> {{ $schoolProfile->telepon }}</div>
                                @endif
                                @if($schoolProfile?->email)
                                    <div><i class="bi bi-envelope-fill"></i> {{ $schoolProfile->email }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <div class="footer-brand">
                        <span class="site-brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
                        <div>
                            <div class="footer-school-name">{{ $schoolName }}</div>
                            <div class="footer-school-text">Website resmi layanan informasi sekolah, pendaftaran peserta didik baru, dan administrasi pendidikan.</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="footer-title">Navigasi</div>
                    <div class="footer-links">
                        <a href="#profil">Profil</a>
                        <a href="#keunggulan">Keunggulan</a>
                        <a href="#ppdb">PPDB</a>
                        <a href="#kontak">Kontak</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="footer-title">Informasi Kontak</div>
                    <div class="footer-contact">
                        <div><i class="bi bi-geo-alt-fill"></i><span>{{ $schoolAddress ?: 'Informasi alamat sekolah akan segera diperbarui.' }}</span></div>
                        <div><i class="bi bi-telephone-fill"></i><span>{{ $schoolProfile?->telepon ?: 'Kontak telepon sekolah akan segera diperbarui.' }}</span></div>
                        <div><i class="bi bi-envelope-fill"></i><span>{{ $schoolProfile?->email ?: 'Alamat email sekolah akan segera diperbarui.' }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
