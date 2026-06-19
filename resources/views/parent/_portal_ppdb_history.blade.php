<div class="surface-card card-tone-teal-light">
    <div class="section-label mb-2">Riwayat PPDB</div>
    <h3 class="h5">Status Pendaftaran Saya</h3>
    <div class="dashboard-stack mt-3">
        @forelse($ppdbs as $ppdb)
            @php($progress = $ppdb->portalProgress())
            @php($statusAppearance = $ppdb->statusAppearance())
            <div class="list-surface-item">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                    <div>
                        <div class="fw-semibold">{{ $ppdb->nama_lengkap }}</div>
                        <div class="small text-muted">{{ $ppdb->asal_sekolah }} | daftar {{ optional($ppdb->tanggal_daftar)->format('d M Y') ?? '-' }}</div>
                        <div class="small text-muted">{{ ucfirst($ppdb->jalur_pendaftaran) }} | {{ $ppdb->pilihan_jurusan ?: 'Jurusan belum diisi' }}</div>
                    </div>
                    <div class="text-lg-end">
                        <span class="badge {{ $statusAppearance['class'] }}">{{ $statusAppearance['label'] }}</span>
                        @if($ppdb->student)
                            <div class="small text-success mt-2">Sudah jadi siswa dengan NIS {{ $ppdb->student->nis }}</div>
                        @endif
                    </div>
                </div>
                <div class="small text-muted mt-2">Tahap saat ini: {{ collect($progress['steps'])->firstWhere('key', $progress['current'])['label'] ?? '-' }}</div>
                @if($ppdb->catatan)
                    <div class="small text-muted mt-2">Catatan admin: {{ $ppdb->catatan }}</div>
                @endif
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada pendaftaran PPDB yang terhubung ke akun ini.</p>
        @endforelse
    </div>
</div>
