@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @php($portalPageEyebrow = 'Portal Orang Tua')
    @php($portalPageTitle = 'Riwayat Pembayaran')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    <div class="dashboard-stack">
        @forelse($payments as $payment)
            @php($statusClass = $payment->isPending() ? 'text-bg-warning' : ($payment->status === Payment::STATUS_APPROVED ? 'text-bg-success' : 'text-bg-danger'))
            <div class="list-surface-item">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                    <div>
                        <div class="fw-semibold">{{ $payment->payment_number }}</div>
                        <div class="small text-muted">{{ $payment->invoice?->invoice_number ?? '-' }} | {{ $payment->payment_date?->format('d M Y') }}</div>
                        <div class="small text-muted">{{ $payment->sender_name }} | {{ $payment->payment_method }}</div>
                    </div>
                    <div class="text-lg-end">
                        <div class="fw-bold">Rp{{ number_format($payment->amount, 0, ',', '.') }}</div>
                        <span class="badge {{ $statusClass }}">{{ $payment->status }}</span>
                        @if($payment->status === Payment::STATUS_APPROVED)
                            <div><a href="{{ route('parent.portal.payments.receipt', $payment) }}" class="btn btn-sm btn-outline-primary mt-2" target="_blank"><i class="bi bi-printer me-1"></i>Cetak Nota</a></div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="surface-card card-tone-sand text-center py-5">
                <i class="bi bi-cash-stack fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">Belum ada riwayat pembayaran.</p>
            </div>
        @endforelse
    </div>
</div>
@include('parent._portal_scripts')
@endsection
