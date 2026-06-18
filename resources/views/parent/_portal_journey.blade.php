<div class="col-12">
    <div class="surface-card">
        <div class="section-label mb-2">Progress PPDB</div>
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
            <div>
                <h3 class="h5 mb-1">Tahapan pendaftaran dari akun ini</h3>
                <p class="text-muted mb-0">Pantau status dari aktivasi akun sampai keputusan akhir PPDB langsung dari portal user.</p>
            </div>
            <span class="badge text-bg-light px-3 py-2">{{ $portalJourney['status_label'] }}</span>
        </div>
        <div class="row g-3">
            @foreach($portalJourney['steps'] as $index => $step)
                @php($isComplete = in_array($step['key'], $portalJourney['completed'], true))
                @php($isActive = $portalJourney['current'] === $step['key'])
                <div class="col-md-6 col-xl-3">
                    <div class="journey-step {{ $isActive ? 'is-active' : '' }} {{ $isComplete ? 'is-complete' : '' }}">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="journey-badge">{{ $index + 1 }}</span>
                            <div class="fw-semibold">{{ $step['label'] }}</div>
                        </div>
                        <div class="small text-muted">{{ $step['description'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@if($latestPpdb)
    <div class="col-12">
        <div class="highlight-panel">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-start gap-3">
                <div>
                    <div class="section-label mb-2">Sorotan Admin</div>
                    <div class="fw-semibold mb-1">Status terbaru: {{ $latestPpdb->statusAppearance()['label'] }}</div>
                    <div class="small text-muted">
                        {{ $latestPpdb->catatan ?: 'Belum ada catatan khusus dari admin. Pantau terus status PPDB dan lengkapi berkas bila masih kurang.' }}
                    </div>
                </div>
                <div class="text-lg-end small text-muted">
                    @if($latestPpdb->tanggal_tes)
                        <div>Jadwal tes: {{ $latestPpdb->tanggal_tes->format('d M Y') }}</div>
                    @endif
                    @if($latestPpdb->tanggal_pengumuman)
                        <div>Pengumuman: {{ $latestPpdb->tanggal_pengumuman->format('d M Y') }}</div>
                    @endif
                    @if(! $latestPpdb->tanggal_tes && ! $latestPpdb->tanggal_pengumuman)
                        <div>Belum ada jadwal lanjutan dari admin.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="action-panel">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <div class="section-label mb-2">Tindakan Cepat</div>
                    @if(! $documentSummary['is_complete'])
                        <div class="fw-semibold mb-1">Lengkapi berkas yang masih kurang</div>
                        <div class="small text-muted">Masih ada {{ $documentSummary['total'] - $documentSummary['completed'] }} dokumen yang belum lengkap. Upload dulu agar pendaftaran siap ditinjau admin.</div>
                        <div class="d-flex gap-2 flex-wrap mt-2">
                            @foreach($documentSummary['missing_items'] as $missingItem)
                                <a href="#doc-{{ $missingItem['key'] }}" class="badge text-bg-secondary text-decoration-none">{{ $missingItem['label'] }}</a>
                            @endforeach
                        </div>
                    @elseif($latestPpdb->status_pendaftaran === 'draft')
                        <div class="fw-semibold mb-1">Berkas lengkap, pendaftaran siap ditinjau</div>
                        <div class="small text-muted">Semua dokumen utama sudah ada. Tinggal tunggu proses verifikasi dan catatan lanjutan dari admin sekolah.</div>
                    @elseif(in_array($latestPpdb->status_pendaftaran, ['diajak_tes', 'lulus_tes'], true))
                        <div class="fw-semibold mb-1">Pantau jadwal dan hasil lanjutan</div>
                        <div class="small text-muted">Pendaftaran Anda sedang di tahap lanjutan. Cek terus sorotan admin untuk jadwal tes atau pengumuman berikutnya.</div>
                    @else
                        <div class="fw-semibold mb-1">Status sudah final</div>
                        <div class="small text-muted">Pendaftaran ini sudah memiliki keputusan akhir. Simpan dokumen dan pantau informasi lanjutan dari sekolah bila diperlukan.</div>
                    @endif
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    @if(! $documentSummary['is_complete'] || $latestPpdb->canManagePortalDocuments())
                        <a href="#berkas-ppdb" class="btn btn-primary">Cek Berkas</a>
                    @endif
                    <a href="{{ route('ppdb.register') }}" class="btn btn-outline-primary">Form PPDB</a>
                </div>
            </div>
        </div>
    </div>
@endif
