@include('components.dashboard._hero', [
    'eyebrow' => $portalPageEyebrow ?? 'Portal Orang Tua / User',
    'title' => $portalPageTitle ?? 'Dashboard Orang Tua',
    'meta' => [
        ['label' => 'Akun Aktif', 'value' => $guardian?->name ?? 'Belum ada data orang tua'],
        ['label' => 'Email', 'value' => $guardian?->email ?? '-', 'muted' => true],
    ],
])

@if($portalPageShowStats ?? request()->routeIs('parent.portal'))
    <div class="row g-3 mb-4 parent-stat-grid">
        <div class="col-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Anak Terdaftar', 'value' => $stats['children'], 'countValue' => $stats['children'], 'icon' => 'bi-people-fill', 'tone' => 'teal'])</div>
        <div class="col-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Invoice Aktif', 'value' => $stats['activeInvoices'], 'countValue' => $stats['activeInvoices'], 'icon' => 'bi-receipt-cutoff', 'tone' => 'gold'])</div>
        <div class="col-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Total Tunggakan', 'value' => 'Rp' . number_format($stats['outstanding'], 0, ',', '.'), 'countValue' => (int) $stats['outstanding'], 'countPrefix' => 'Rp', 'icon' => 'bi-wallet2', 'tone' => 'coral'])</div>
        <div class="col-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Pembayaran Disetujui', 'value' => 'Rp' . number_format($stats['approvedPayments'], 0, ',', '.'), 'countValue' => (int) $stats['approvedPayments'], 'countPrefix' => 'Rp', 'icon' => 'bi-patch-check-fill', 'tone' => 'sand'])</div>
    </div>
@endif
