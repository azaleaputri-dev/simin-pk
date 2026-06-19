@extends('layouts.app')

@php
    $statusAppearance = match ($invoice->status) {
        'PAID' => ['label' => 'Lunas', 'class' => 'text-bg-success', 'icon' => 'bi-check-circle-fill'],
        'PARTIAL' => ['label' => 'Angsuran', 'class' => 'text-bg-warning', 'icon' => 'bi-hourglass-split'],
        'UNPAID' => ['label' => 'Belum Dibayar', 'class' => 'text-bg-secondary', 'icon' => 'bi-x-circle-fill'],
        'CANCELLED' => ['label' => 'Dibatalkan', 'class' => 'text-bg-danger', 'icon' => 'bi-x-octagon-fill'],
        default => ['label' => $invoice->status, 'class' => 'text-bg-light', 'icon' => 'bi-question-circle-fill'],
    };
    $remainingPercent = $invoice->total_amount > 0 ? (int) round(($invoice->remaining_amount / $invoice->total_amount) * 100) : 0;
    $paidPercent = 100 - $remainingPercent;
@endphp

@section('content')
<div class="page-card p-4 p-lg-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="section-label">Keuangan</div>
                <span class="badge {{ $statusAppearance['class'] }} fs-6">
                    <i class="bi {{ $statusAppearance['icon'] }} me-1"></i>
                    {{ $statusAppearance['label'] }}
                </span>
            </div>
            <h1 class="h3 mb-1">{{ $invoice->invoice_number }}</h1>
            <p class="text-muted mb-0">{{ $invoice->student?->nama_lengkap }} &mdash; {{ $invoice->academicYear?->name ?? '-' }}</p>
        </div>
        <div class="d-flex gap-2 flex-shrink-0">
            @if(!$invoice->isPaid())
                <a href="{{ route('payments.create') }}" class="btn btn-primary"><i class="bi bi-cash-coin me-1"></i>Input Pembayaran</a>
            @endif
            @if(!$invoice->isPaid())
                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline-secondary">Edit</a>
            @endif
            <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-3">Informasi Invoice</div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Tanggal Invoice</span>
                    <span class="fw-semibold">{{ $invoice->invoice_date?->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Jatuh Tempo</span>
                    <span class="fw-semibold {{ $invoice->due_date?->isPast() && !$invoice->isPaid() ? 'text-danger' : '' }}">{{ $invoice->due_date?->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Orang Tua</span>
                    <span class="fw-semibold">{{ $invoice->guardian?->name ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Tahun Ajaran</span>
                    <span class="fw-semibold">{{ $invoice->academicYear?->name ?? '-' }}</span>
                </div>
                @if($invoice->notes)
                    <hr class="my-2">
                    <div class="small text-muted">Catatan: {{ $invoice->notes }}</div>
                @endif
            </div>
        </div>

        <div class="col-lg-8">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-3">Ringkasan Pembayaran</div>
                <div class="row g-3 mb-3">
                    <div class="col-4">
                        <div class="text-center">
                            <div class="fs-4 fw-bold">Rp{{ number_format($invoice->total_amount, 0, ',', '.') }}</div>
                            <div class="small text-muted">Total Tagihan</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <div class="fs-4 fw-bold text-success">Rp{{ number_format($invoice->approved_payment_total, 0, ',', '.') }}</div>
                            <div class="small text-muted">Telah Dibayar</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <div class="fs-4 fw-bold {{ $invoice->remaining_amount > 0 ? 'text-danger' : 'text-success' }}">
                                Rp{{ number_format($invoice->remaining_amount, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">{{ $invoice->remaining_amount > 0 ? 'Sisa Tagihan' : 'Lunas' }}</div>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Progress Pembayaran</span>
                        <span class="fw-semibold">{{ $paidPercent }}%</span>
                    </div>
                    <div class="mini-progress" style="height: 1.5rem;">
                        <div class="mini-progress-bar tone-{{ $invoice->isPaid() ? 'success' : ($paidPercent > 0 ? 'info' : 'danger') }}" data-progress-width="{{ $paidPercent }}" style="background: {{ $invoice->isPaid() ? 'linear-gradient(90deg, #198754 0%, #43b581 100%)' : ($paidPercent > 0 ? 'linear-gradient(90deg, #1f7a8c 0%, #49a3b3 100%)' : 'linear-gradient(90deg, #dc3545 0%, #ef6b76 100%)') }};"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-3">Item Tagihan</div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Jenis Biaya</th><th>Keterangan</th><th class="text-end">Nominal</th></tr></thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->feeType?->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-end fw-semibold">Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-label mb-0">Riwayat Pembayaran</div>
                    @if(!$invoice->isPaid())
                        <a href="{{ route('payments.create') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle me-1"></i>Tambah</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>No. Pembayaran</th><th>Tanggal</th><th class="text-end">Nominal</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($invoice->payments as $payment)
                                @php($payStatus = match ($payment->status) { 'APPROVED' => 'text-bg-success', 'PENDING' => 'text-bg-warning', 'REJECTED' => 'text-bg-danger', default => 'text-bg-light' })
                                <tr>
                                    <td><a href="{{ route('payments.show', $payment) }}" class="text-decoration-none fw-semibold">{{ $payment->payment_number }}</a></td>
                                    <td>{{ $payment->payment_date?->format('d M Y') }}</td>
                                    <td class="text-end">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td><span class="badge {{ $payStatus }}">{{ $payment->status }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada pembayaran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
