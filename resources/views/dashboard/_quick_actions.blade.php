<div class="surface-card mb-4 reveal-on-load card-tone-gold">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-3">
        <div>
            <div class="section-label mb-2">Aksi Cepat</div>
            <h3 class="h5 mb-1">Masuk ke modul yang paling sering dipakai</h3>
            <p class="text-muted mb-0">Shortcut ini bantu admin lompat cepat ke area operasional harian.</p>
        </div>
        <span class="badge text-bg-light soft-pulse">Live dashboard</span>
    </div>
    <div class="row g-3">
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('ppdb.index') }}" class="quick-action-card text-decoration-none">
                <span class="quick-action-icon"><i class="bi bi-people-fill"></i></span>
                <div class="fw-semibold">Kelola PPDB</div>
                <div class="small text-muted">Review pendaftar dan status</div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('students.index') }}" class="quick-action-card text-decoration-none">
                <span class="quick-action-icon"><i class="bi bi-mortarboard-fill"></i></span>
                <div class="fw-semibold">Data Siswa</div>
                <div class="small text-muted">Pantau siswa aktif dan kelas</div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('invoices.index') }}" class="quick-action-card text-decoration-none">
                <span class="quick-action-icon"><i class="bi bi-receipt-cutoff"></i></span>
                <div class="fw-semibold">Invoice</div>
                <div class="small text-muted">Cek tagihan dan status</div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('payments.index') }}" class="quick-action-card text-decoration-none">
                <span class="quick-action-icon"><i class="bi bi-cash-stack"></i></span>
                <div class="fw-semibold">Verifikasi Bayar</div>
                <div class="small text-muted">Lihat pembayaran pending</div>
            </a>
        </div>
    </div>
</div>
