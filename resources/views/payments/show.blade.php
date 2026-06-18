@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="section-label">Verifikasi Pembayaran</div>
            <h1 class="h3 mb-1">{{ $payment->payment_number }}</h1>
            <p class="text-muted mb-0">{{ $payment->invoice?->invoice_number }} / {{ $payment->status }}</p>
        </div>
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <p class="mb-1">Siswa: {{ $payment->invoice?->student?->nama_lengkap }}</p>
                <p class="mb-1">Tanggal: {{ $payment->payment_date?->format('d M Y') }}</p>
                <p class="mb-1">Nominal: Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                <p class="mb-1">Metode: {{ $payment->payment_method }}</p>
                <p class="mb-1">Pengirim: {{ $payment->sender_name ?: '-' }}</p>
                <p class="mb-0">Bukti: {{ $payment->proof_reference ?: '-' }}</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <p class="mb-1">Status Invoice: {{ $payment->invoice?->status }}</p>
                <p class="mb-1">Total Invoice: Rp{{ number_format($payment->invoice?->total_amount ?? 0, 0, ',', '.') }}</p>
                <p class="mb-1">Sisa Tagihan: Rp{{ number_format($payment->invoice?->remaining_amount ?? 0, 0, ',', '.') }}</p>
                <p class="mb-0">Catatan: {{ $payment->notes ?: '-' }}</p>
            </div>
        </div>
        @if($payment->status === 'PENDING')
            <div class="col-lg-6">
                <div class="border rounded-4 p-4 h-100">
                    <div class="section-label mb-2">Approve</div>
                    <form action="{{ route('payments.approve', $payment) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Catatan Approval</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                        <button class="btn btn-success">Setujui Pembayaran</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="border rounded-4 p-4 h-100">
                    <div class="section-label mb-2">Reject</div>
                    <form action="{{ route('payments.reject', $payment) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan</label>
                            <textarea name="notes" class="form-control" rows="3" required></textarea>
                        </div>
                        <button class="btn btn-danger">Tolak Pembayaran</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
