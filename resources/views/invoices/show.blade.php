@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="section-label">Keuangan</div>
            <h1 class="h3 mb-1">{{ $invoice->invoice_number }}</h1>
            <p class="text-muted mb-0">{{ $invoice->student?->nama_lengkap }} / {{ $invoice->status }}</p>
        </div>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">Input Pembayaran</a>
    </div>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-2">Ringkasan</div>
                <p class="mb-1">Tanggal Invoice: {{ $invoice->invoice_date?->format('d M Y') }}</p>
                <p class="mb-1">Jatuh Tempo: {{ $invoice->due_date?->format('d M Y') }}</p>
                <p class="mb-1">Orang Tua: {{ $invoice->guardian?->name ?? '-' }}</p>
                <p class="mb-1">Tahun Ajaran: {{ $invoice->academicYear?->name ?? '-' }}</p>
                <p class="mb-0">Catatan: {{ $invoice->notes ?: '-' }}</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-2">Nominal</div>
                <p class="mb-1">Total: Rp{{ number_format($invoice->total_amount, 0, ',', '.') }}</p>
                <p class="mb-1">Pembayaran Approved: Rp{{ number_format($invoice->approved_payment_total, 0, ',', '.') }}</p>
                <p class="mb-0">Sisa: Rp{{ number_format($invoice->remaining_amount, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="col-12">
            <div class="border rounded-4 p-4">
                <div class="section-label mb-2">Item Invoice</div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Jenis Biaya</th><th>Keterangan</th><th>Nominal</th></tr></thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->feeType?->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="border rounded-4 p-4">
                <div class="section-label mb-2">Riwayat Pembayaran</div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>No. Pembayaran</th><th>Tanggal</th><th>Nominal</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($invoice->payments as $payment)
                                <tr>
                                    <td><a href="{{ route('payments.show', $payment) }}">{{ $payment->payment_number }}</a></td>
                                    <td>{{ $payment->payment_date?->format('d M Y') }}</td>
                                    <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>{{ $payment->status }}</td>
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
