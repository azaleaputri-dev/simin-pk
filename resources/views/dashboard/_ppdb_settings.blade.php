<div class="surface-card mb-4 reveal-on-load">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-3">
        <div>
            <div class="section-label mb-2">Pengaturan PPDB</div>
            <h3 class="h5 mb-1">Buka/tutup pendaftaran dan atur periode PPDB</h3>
            <p class="text-muted mb-0">PPDB bisa dibuka selama periode pendaftaran dan ditutup setelah selesai.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge {{ $activeAcademicYear?->ppdbStatusBadge()['class'] ?? 'text-bg-secondary' }} fs-6 px-3 py-2">
                <i class="bi {{ $activeAcademicYear?->isPpdbOpen() ? 'bi-unlock-fill' : 'bi-lock-fill' }} me-1"></i>
                {{ $activeAcademicYear?->ppdbStatusBadge()['label'] ?? 'Tidak Aktif' }}
            </span>
        </div>
    </div>

    @if($activeAcademicYear)
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <form action="{{ route('admin.ppdb.toggle') }}" method="POST">
                    @csrf
                    @if($activeAcademicYear->isPpdbOpen())
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-lock-fill me-1"></i> Tutup PPDB
                        </button>
                    @else
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-unlock-fill me-1"></i> Buka PPDB
                        </button>
                    @endif
                </form>
            </div>
            <div class="col-md-8">
                <form action="{{ route('admin.ppdb.period') }}" method="POST" class="row g-2">
                    @csrf
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="ppdb_start_date" class="form-control"
                            value="{{ $activeAcademicYear->ppdb_start_date?->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Tanggal Selesai</label>
                        <input type="date" name="ppdb_end_date" class="form-control"
                            value="{{ $activeAcademicYear->ppdb_end_date?->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-calendar-check me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($activeAcademicYear->ppdb_start_date && $activeAcademicYear->ppdb_end_date)
            <div class="mt-3 small text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Periode: {{ $activeAcademicYear->ppdb_start_date->format('d M Y') }}
                &mdash; {{ $activeAcademicYear->ppdb_end_date->format('d M Y') }}
                @if(!$activeAcademicYear->isPpdbWithinPeriod())
                    <span class="text-warning fw-semibold">(diluar periode yang ditentukan)</span>
                @endif
            </div>
        @endif
    @else
        <div class="alert alert-warning mb-0">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Belum ada tahun ajaran aktif. <a href="{{ route('academic-years.index') }}" class="alert-link">Atur tahun ajaran</a> terlebih dahulu.
        </div>
    @endif
</div>
