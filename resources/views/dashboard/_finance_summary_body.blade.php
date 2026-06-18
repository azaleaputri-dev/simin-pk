<div class="row g-3 mb-4">
    @foreach($summaryCards as $card)
        <div class="col-6">
            @include('components.dashboard._stat_card', ['label' => $card['label'], 'value' => $card['value']])
        </div>
    @endforeach
</div>

<div class="section-label mb-2">Pendaftar Terbaru</div>
<div class="filter-toolbar mb-3" data-filter-group="applicants">
    <button type="button" class="filter-chip is-active" data-filter-value="all">Semua</button>
    <button type="button" class="filter-chip" data-filter-value="draft">Draft</button>
    <button type="button" class="filter-chip" data-filter-value="diterima">Diterima</button>
    <button type="button" class="filter-chip" data-filter-value="ditolak">Ditolak</button>
    <button type="button" class="filter-chip" data-filter-value="cancelled">Batal</button>
</div>
<div class="dashboard-stack" data-filter-container="applicants">
    @forelse($recentApplicants as $applicant)
        @php($statusTag = \Illuminate\Support\Str::slug((string) $applicant->status_pendaftaran))
        <div class="list-surface-item" data-filter-item data-filter-tag="{{ $statusTag }}">
            <div class="d-flex justify-content-between gap-3">
                <div>
                    <div class="fw-semibold">{{ $applicant->nama_lengkap }}</div>
                    <div class="text-muted small">{{ $applicant->asal_sekolah }}</div>
                </div>
                <span class="badge text-bg-light">{{ $applicant->status_pendaftaran }}</span>
            </div>
            <div class="small text-muted mt-2">Orang tua: {{ $applicant->nama_orang_tua ?: '-' }}</div>
        </div>
    @empty
        <p class="text-muted mb-0">Belum ada data PPDB.</p>
    @endforelse
</div>
