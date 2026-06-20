<div class="col-12" id="ringkasan-akun">
    <div class="surface-card card-tone-sand">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <div class="section-label mb-2">Akun Portal</div>
                <h3 class="h5 mb-1">Selamat datang, {{ $guardian?->name ?? 'Orang Tua' }}</h3>
                <p class="text-muted mb-0">
                    {{ $latestPpdb
                        ? 'Pendaftaran PPDB sudah terhubung. Pantau status, berkas, tagihan, dan informasi anak dari portal ini.'
                        : 'Akun sudah aktif. Lengkapi formulir PPDB untuk memulai pendaftaran calon siswa.' }}
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap parent-account-actions">
                <a href="{{ route('parent.portal.profile') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person-gear me-1"></i>Kelola Profil
                </a>
                <a href="{{ route('ppdb.register') }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i>{{ $latestPpdb ? 'Buka Form PPDB' : 'Isi Form PPDB' }}
                </a>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="list-surface-item h-100 mb-0">
                    <div class="parent-account-icon"><i class="bi bi-person-fill"></i></div>
                    <div>
                        <div class="small text-muted">Nama Akun</div>
                        <div class="fw-semibold text-break">{{ $guardian?->name ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="list-surface-item h-100 mb-0">
                    <div class="parent-account-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div class="min-w-0">
                        <div class="small text-muted">Email</div>
                        <div class="fw-semibold text-break">{{ $guardian?->email ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="list-surface-item h-100 mb-0">
                    <div class="parent-account-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <div class="small text-muted">No. HP</div>
                        <div class="fw-semibold">{{ $guardian?->phone ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
