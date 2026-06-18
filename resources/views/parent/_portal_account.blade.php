<div class="col-12" id="berkas-ppdb">
    <div class="border rounded-4 p-4 bg-white">
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
                <div class="border rounded-3 p-3 h-100">
                    <div class="small text-muted">Nama Akun</div>
                    <div class="fw-semibold">{{ $guardian?->name ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <div class="small text-muted">Email</div>
                    <div class="fw-semibold">{{ $guardian?->email ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <div class="small text-muted">No. HP</div>
                    <div class="fw-semibold">{{ $guardian?->phone ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
