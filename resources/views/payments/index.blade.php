@extends('layouts.app')

@php
    $statusAppearance = fn($s) => match ($s) {
        'APPROVED' => ['label' => 'Disetujui', 'class' => 'text-bg-success'],
        'PENDING' => ['label' => 'Pending', 'class' => 'text-bg-warning'],
        'REJECTED' => ['label' => 'Ditolak', 'class' => 'text-bg-danger'],
        default => ['label' => $s, 'class' => 'text-bg-light'],
    };
    $methodLabel = fn($m) => match ($m) {
        'TRANSFER_BANK' => 'Transfer Bank',
        'TUNAI' => 'Tunai',
        default => $m,
    };
@endphp

@section('content')
<div class="page-card p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="section-label">Keuangan</div>
            <h1 class="h3 mb-1">Pembayaran</h1>
            <p class="text-muted mb-0">Monitoring pembayaran masuk dan verifikasi.</p>
        </div>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">Input Pembayaran</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>No. Pembayaran</th>
                    <th>Invoice</th>
                    <th>Siswa</th>
                    <th class="text-end">Nominal</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    @php($appearance = $statusAppearance($payment->status))
                    <tr class="{{ $payment->status === 'PENDING' ? 'table-warning' : '' }}">
                        <td class="fw-semibold">{{ $payment->payment_number }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $payment->invoice) }}" class="text-decoration-none">
                                {{ $payment->invoice?->invoice_number }}
                            </a>
                        </td>
                        <td>{{ $payment->invoice?->student?->nama_lengkap ?? '-' }}</td>
                        <td class="text-end fw-semibold">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge text-bg-light">{{ $methodLabel($payment->payment_method) }}</span>
                        </td>
                        <td><span class="badge {{ $appearance['class'] }}">{{ $appearance['label'] }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('payments.receipt', $payment) }}" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-file-earmark-arrow-down me-1"></i>PDF
                            </a>
                            <a href="{{ route('payments.receipt.print', $payment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-printer me-1"></i>Print
                            </a>
                            @if($payment->status === 'PENDING')
                                <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-success">Verifikasi</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">Belum ada pembayaran. <a href="{{ route('payments.create') }}">Input pembayaran baru</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
