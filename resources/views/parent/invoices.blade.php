@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @php($portalPageEyebrow = 'Portal Orang Tua')
    @php($portalPageTitle = 'Tagihan Saya')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    <div class="dashboard-stack">
        @forelse($invoices as $invoice)
            @php($statusClass = $invoice->isPaid() ? 'text-bg-success' : ($invoice->isCancelled() ? 'text-bg-secondary' : ($invoice->due_date?->isPast() ? 'text-bg-danger' : 'text-bg-warning')))
            <a href="{{ route('parent.portal.invoices.detail', $invoice) }}" class="list-surface-item text-decoration-none d-block">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                    <div>
                        <div class="fw-semibold">{{ $invoice->invoice_number }}</div>
                        <div class="small text-muted">{{ $invoice->student?->nama_lengkap ?? '-' }} | {{ $invoice->invoice_date?->format('d M Y') }}</div>
                    </div>
                    <div class="text-lg-end">
                        <div class="fw-bold fs-5 text-dark">Rp{{ number_format($invoice->remaining_amount, 0, ',', '.') }}</div>
                        <span class="badge {{ $statusClass }}">{{ $invoice->status }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="surface-card card-tone-sand text-center py-5">
                <i class="bi bi-receipt-cutoff fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">Belum ada tagihan untuk akun ini.</p>
            </div>
        @endforelse
    </div>
</div>
@include('parent._portal_scripts')
@endsection
