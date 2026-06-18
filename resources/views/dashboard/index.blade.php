@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="section-label">Portal Admin</div>
            <h1 class="mb-2">Dashboard Operasional Sekolah</h1>
            <p class="mb-0 text-muted">Area admin untuk mengelola master data, PPDB, siswa, kelas, invoice, dan verifikasi pembayaran.</p>
        </div>
        <div class="text-lg-end">
            <div class="section-label">Mode Akses</div>
            <div class="fs-6 text-muted">Admin Sekolah</div>
            <div class="section-label mt-3">Tahun Ajaran Aktif</div>
            <div class="fs-5 fw-semibold">{{ $activeAcademicYear?->name ?? 'Belum ditentukan' }}</div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Profil Sekolah</small><strong>{{ $stats['profilSekolah'] }}</strong></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Tahun Ajaran</small><strong>{{ $stats['tahunAjaran'] }}</strong></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Kelas</small><strong>{{ $stats['kelas'] }}</strong></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Orang Tua</small><strong>{{ $stats['orangTua'] }}</strong></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Siswa Aktif</small><strong>{{ $stats['siswa'] }}</strong></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Total PPDB</small><strong>{{ $stats['ppdb'] }}</strong></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card"><small>PPDB Pending</small><strong>{{ $stats['ppdbPending'] }}</strong></div></div>
        <div class="col-md-6 col-xl-3"><div class="stat-card"><small>PPDB Diterima</small><strong>{{ $stats['ppdbApproved'] }}</strong></div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="border rounded-4 p-4 bg-white h-100">
                <div class="section-label mb-2">Progress Modul</div>
                <h3 class="h5">Prioritas yang sudah diturunkan dari SRS</h3>
                <div class="table-responsive mt-3">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Modul</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Profil Sekolah</td><td><span class="badge text-bg-success">Siap dipakai</span></td><td>Master identitas sekolah tersedia.</td></tr>
                            <tr><td>Tahun Ajaran</td><td><span class="badge text-bg-success">Siap dipakai</span></td><td>Satu tahun ajaran aktif dijaga di controller.</td></tr>
                            <tr><td>Kelas</td><td><span class="badge text-bg-success">Aktif</span></td><td>Jenjang PAUD/TK dan kuota sesuai SRS.</td></tr>
                            <tr><td>Orang Tua</td><td><span class="badge text-bg-success">Aktif</span></td><td>Email dan nomor HP unik.</td></tr>
                            <tr><td>Data Siswa</td><td><span class="badge text-bg-success">Aktif</span></td><td>Terhubung ke kelas, orang tua, dan tahun ajaran.</td></tr>
                            <tr><td>Approval PPDB</td><td><span class="badge text-bg-warning">Parsial</span></td><td>Status diterima otomatis membuat akun orang tua dan data siswa.</td></tr>
                            <tr><td>Keuangan</td><td><span class="badge text-bg-success">Aktif</span></td><td>Jenis biaya, tarif, invoice, cicilan, dan approval pembayaran sudah tersedia.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="border rounded-4 p-4 bg-white h-100">
                <div class="section-label mb-2">Ringkasan Bendahara</div>
                <div class="row g-3 mb-4">
                    <div class="col-6"><div class="stat-card"><small>Invoice Aktif</small><strong>{{ $stats['invoiceActive'] }}</strong></div></div>
                    <div class="col-6"><div class="stat-card"><small>Pending Verifikasi</small><strong>{{ $stats['paymentPending'] }}</strong></div></div>
                    <div class="col-6"><div class="stat-card"><small>Pendapatan</small><strong>Rp{{ number_format($stats['revenueApproved'], 0, ',', '.') }}</strong></div></div>
                    <div class="col-6"><div class="stat-card"><small>Tunggakan</small><strong>Rp{{ number_format($stats['outstanding'], 0, ',', '.') }}</strong></div></div>
                </div>
                <div class="section-label mb-2">Pendaftar Terbaru</div>
                <h3 class="h5">Snapshot PPDB</h3>
                <div class="mt-3">
                    @forelse($recentApplicants as $applicant)
                        <div class="border rounded-3 p-3 mb-3">
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
            </div>
        </div>
    </div>
</div>
@endsection
