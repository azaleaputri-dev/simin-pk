@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><div class="section-label">Keuangan</div><h1 class="h3 mb-0">Pembayaran</h1></div>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">Input Pembayaran</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>No. Pembayaran</th><th>Invoice</th><th>Siswa</th><th>Nominal</th><th>Metode</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_number }}</td>
                        <td>{{ $payment->invoice?->invoice_number }}</td>
                        <td>{{ $payment->invoice?->student?->nama_lengkap }}</td>
                        <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>{{ $payment->status }}</td>
                        <td class="text-end"><a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
