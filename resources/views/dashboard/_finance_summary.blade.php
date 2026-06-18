@php
    $summaryCards = [
        ['label' => 'Invoice Aktif', 'value' => $stats['invoiceActive']],
        ['label' => 'Pending Verifikasi', 'value' => $stats['paymentPending']],
        ['label' => 'Pendapatan', 'value' => 'Rp' . number_format($stats['revenueApproved'], 0, ',', '.')],
        ['label' => 'Tunggakan', 'value' => 'Rp' . number_format($stats['outstanding'], 0, ',', '.')],
    ];
@endphp

@include('components.dashboard._section_card', [
    'eyebrow' => 'Ringkasan Bendahara',
    'title' => 'Kontrol keuangan dan snapshot PPDB',
    'slot' => view('dashboard._finance_summary_body', ['summaryCards' => $summaryCards, 'recentApplicants' => $recentApplicants])->render(),
])
