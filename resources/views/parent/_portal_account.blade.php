<div class="col-12" id="ringkasan-akun">
    <div class="surface-card card-tone-sand">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
            <div>
                <div class="section-label mb-2">Akun Portal</div>
                <h3 class="h5 mb-1">Akun user sudah aktif</h3>
                <p class="text-muted mb-0">
                    {{ $latestPpdb
                        ? 'Akun ini sudah terhubung ke data PPDB. Anda bisa memantau status atau mengirim pendaftaran baru jika diperlukan.'
                        : 'Langkah berikutnya adalah mengisi formulir PPDB dari halaman pendaftaran yang terhubung ke akun ini.' }}
                </p>
            </div>
            <a href="{{ route('ppdb.register') }}" class="btn btn-primary">{{ $latestPpdb ? 'Buat / Update Pendaftaran PPDB' : 'Lanjut Isi PPDB' }}</a>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="list-surface-item h-100 mb-0">
                    <div class="small text-muted">Nama Akun</div>
                    <div class="fw-semibold">{{ $guardian?->name ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="list-surface-item h-100 mb-0">
                    <div class="small text-muted">Email</div>
                    <div class="fw-semibold">{{ $guardian?->email ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="list-surface-item h-100 mb-0">
                    <div class="small text-muted">No. HP</div>
                    <div class="fw-semibold">{{ $guardian?->phone ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
