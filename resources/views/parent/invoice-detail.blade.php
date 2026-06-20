@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @php($portalPageEyebrow = 'Portal Orang Tua')
    @php($portalPageTitle = 'Detail Tagihan')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    <div class="surface-card card-tone-teal-light mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
            <div>
                <div class="section-label mb-2">{{ $invoice->invoice_number }}</div>
                <h3 class="h5 mb-1">{{ $invoice->student?->nama_lengkap ?? '-' }}</h3>
                <p class="text-muted mb-0">Jatuh tempo: {{ $invoice->due_date?->format('d M Y') ?? '-' }}</p>
            </div>
            <div class="text-lg-end">
                <div class="fs-3 fw-bold {{ $invoice->isPaid() ? 'text-success' : ($invoice->due_date?->isPast() ? 'text-danger' : 'text-warning') }}">
                    Rp{{ number_format($invoice->remaining_amount, 0, ',', '.') }}
                </div>
                <span class="badge {{ $invoice->isPaid() ? 'text-bg-success' : ($invoice->isCancelled() ? 'text-bg-secondary' : 'text-bg-warning') }} fs-6 px-3">{{ $invoice->status }}</span>
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $item->description ?? $item->feeType?->name ?? '-' }}</td>
                            <td>{{ $item->quantity ?? 1 }}</td>
                            <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="2">Total</td>
                        <td>Rp{{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($invoice->notes)
            <div class="small text-muted mb-4">Catatan: {{ $invoice->notes }}</div>
        @endif

        @if(! $invoice->isPaid() && ! $invoice->isCancelled())
            <div class="border rounded-4 p-4" style="background: rgba(31, 122, 140, 0.06);">
                <div class="section-label mb-2">Bayar Tagihan</div>
                <h4 class="h6 mb-3">Kirim pembayaran transfer bank untuk diverifikasi admin</h4>
                <form action="{{ route('parent.portal.invoices.pay', $invoice) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" name="amount" class="form-control" min="1" max="{{ $invoice->remaining_amount }}" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Transfer</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Pengirim</label>
                        <input type="text" name="sender_name" class="form-control" value="{{ $guardian->name }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Referensi (opsional)</label>
                        <input type="text" name="proof_reference" class="form-control" placeholder="No. referensi transfer">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Kirim Pembayaran</button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    @if($invoice->payments->isNotEmpty())
        <div class="surface-card card-tone-sand">
            <div class="section-label mb-2">Riwayat Pembayaran</div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No. Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_number }}</td>
                                <td>{{ $payment->payment_date?->format('d M Y') }}</td>
                                <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td><span class="badge {{ $payment->isPending() ? 'text-bg-warning' : ($payment->status === Payment::STATUS_APPROVED ? 'text-bg-success' : 'text-bg-danger') }}">{{ $payment->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@include('parent._portal_scripts')
@endsection
