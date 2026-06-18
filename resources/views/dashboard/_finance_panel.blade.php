@php
    $financeMetrics = [
        ['label' => 'Invoice Aktif', 'value' => $stats['invoiceActive'], 'max' => max($stats['invoiceActive'] + $stats['paymentPending'], 1), 'tone' => 'info', 'prefix' => ''],
        ['label' => 'Pending Verifikasi', 'value' => $stats['paymentPending'], 'max' => max($stats['invoiceActive'] + $stats['paymentPending'], 1), 'tone' => 'warning', 'prefix' => ''],
        ['label' => 'Pendapatan', 'value' => (int) $stats['revenueApproved'], 'max' => max((int) $stats['revenueApproved'] + (int) $stats['outstanding'], 1), 'tone' => 'success', 'prefix' => 'Rp'],
        ['label' => 'Tunggakan', 'value' => (int) $stats['outstanding'], 'max' => max((int) $stats['revenueApproved'] + (int) $stats['outstanding'], 1), 'tone' => 'danger', 'prefix' => 'Rp'],
    ];
@endphp

<div class="surface-card reveal-on-load">
    <div class="section-label mb-2">Panel Keuangan</div>
    <h3 class="h5 mb-1">Perbandingan arus tagihan dan pembayaran</h3>
    <p class="text-muted mb-0">Angka inti diringkas dalam mini bar agar lebih cepat dipindai.</p>

    <div class="mt-4">
        @foreach($financeMetrics as $metric)
            @php($percentage = (int) round(($metric['value'] / $metric['max']) * 100))
            <div class="metric-row">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="fw-semibold">{{ $metric['label'] }}</div>
                        <div class="small text-muted">
                            {{ $metric['prefix'] }}{{ number_format($metric['value'], 0, ',', '.') }}
                        </div>
                    </div>
                    <span class="badge text-bg-light">{{ $percentage }}%</span>
                </div>
                <div class="mini-progress">
                    <div class="mini-progress-bar tone-{{ $metric['tone'] }}" data-progress-width="{{ $percentage }}"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
