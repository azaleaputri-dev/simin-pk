<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <div class="section-label">Portal Orang Tua / User</div>
        <h1 class="mb-2">Ringkasan Anak dan Tagihan</h1>
        <p class="mb-0 text-muted">Area ini dipisahkan dari admin agar orang tua fokus ke informasi anak, invoice aktif, dan riwayat pembayaran.</p>
    </div>
    <div class="text-lg-end">
        <div class="section-label">Akun Aktif</div>
        <div class="fs-5 fw-semibold">{{ $guardian?->name ?? 'Belum ada data orang tua' }}</div>
        <div class="text-muted small">{{ $guardian?->email ?? '-' }}</div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Anak Terdaftar</small><strong>{{ $stats['children'] }}</strong></div></div>
    <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Invoice Aktif</small><strong>{{ $stats['activeInvoices'] }}</strong></div></div>
    <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Total Tunggakan</small><strong>Rp{{ number_format($stats['outstanding'], 0, ',', '.') }}</strong></div></div>
    <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Pembayaran Approved</small><strong>Rp{{ number_format($stats['approvedPayments'], 0, ',', '.') }}</strong></div></div>
    <div class="col-md-6 col-xl-3"><div class="stat-card"><small>Pendaftaran PPDB</small><strong>{{ $stats['ppdb'] }}</strong></div></div>
</div>
