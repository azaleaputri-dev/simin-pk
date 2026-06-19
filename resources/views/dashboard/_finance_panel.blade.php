@php
    $totalRevenue = (int) $stats['revenueApproved'];
    $totalOutstanding = (int) $stats['outstanding'];
    $totalExpected = max($totalRevenue + $totalOutstanding, 1);
    $collectionRate = (int) round(($totalRevenue / $totalExpected) * 100);
@endphp

<div class="surface-card reveal-on-load card-tone-coral-light">
    <div class="finance-panel-heading mb-4">
        <div class="finance-panel-copy">
            <div class="section-label mb-2">Panel Keuangan</div>
            <h3 class="h5 mb-1">Arus kas dan status tagihan</h3>
            <p class="text-muted mb-0">Ringkasan pendapatan, tunggakan, dan aktivitas verifikasi.</p>
        </div>
        <div class="finance-panel-total">
            <div class="finance-panel-total-value">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="small text-muted">Total Pendapatan</div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="finance-mini-card" style="background: rgba(31, 122, 140, 0.06);">
                <div class="finance-mini-value text-info">{{ $stats['invoiceActive'] }}</div>
                <div class="small text-muted">Invoice Aktif</div>
            </div>
        </div>
        <div class="col-6">
            <div class="finance-mini-card" style="background: rgba(226, 166, 75, 0.1);">
                <div class="finance-mini-value text-warning">{{ $stats['paymentPending'] }}</div>
                <div class="small text-muted">Pending Verifikasi</div>
            </div>
        </div>
        <div class="col-6">
            <div class="finance-mini-card" style="background: rgba(25, 135, 84, 0.06);">
                <div class="finance-mini-value finance-mini-currency text-success">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="small text-muted">Pendapatan</div>
            </div>
        </div>
        <div class="col-6">
            <div class="finance-mini-card" style="background: rgba(220, 53, 69, 0.06);">
                <div class="finance-mini-value finance-mini-currency text-danger">Rp{{ number_format($totalOutstanding, 0, ',', '.') }}</div>
                <div class="small text-muted">Tunggakan</div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold small">Tingkat Pelunasan</div>
            <span class="badge {{ $collectionRate >= 75 ? 'text-bg-success' : ($collectionRate >= 50 ? 'text-bg-warning' : 'text-bg-danger') }}">{{ $collectionRate }}%</span>
        </div>
        <div class="mini-progress" style="height: 1.2rem;">
            <div class="mini-progress-bar tone-{{ $collectionRate >= 75 ? 'success' : ($collectionRate >= 50 ? 'warning' : 'danger') }}" data-progress-width="{{ $collectionRate }}"></div>
        </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-receipt me-1"></i>Kelola Invoice</a>
        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-cash-coin me-1"></i>Verifikasi Pembayaran</a>
    </div>
</div>
