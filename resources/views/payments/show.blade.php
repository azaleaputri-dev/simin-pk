@extends('layouts.app')

@php
    $statusAppearance = match ($payment->status) {
        'APPROVED' => ['label' => 'Disetujui', 'class' => 'text-bg-success', 'icon' => 'bi-check-circle-fill'],
        'PENDING' => ['label' => 'Menunggu Verifikasi', 'class' => 'text-bg-warning', 'icon' => 'bi-clock-fill'],
        'REJECTED' => ['label' => 'Ditolak', 'class' => 'text-bg-danger', 'icon' => 'bi-x-circle-fill'],
        default => ['label' => $payment->status, 'class' => 'text-bg-light', 'icon' => 'bi-question-circle-fill'],
    };
    $methodLabel = match ($payment->payment_method) {
        'TRANSFER_BANK' => 'Transfer Bank',
        'TUNAI' => 'Tunai',
        default => $payment->payment_method,
    };
    $proofName = $payment->proof_reference ? basename($payment->proof_reference) : null;
    $proofExtension = $proofName ? strtolower(pathinfo($proofName, PATHINFO_EXTENSION)) : null;
    $proofIsImage = in_array($proofExtension, ['jpg', 'jpeg', 'png', 'webp'], true);
@endphp

@section('content')
<div class="page-card p-4 p-lg-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="section-label">Verifikasi Pembayaran</div>
                <span class="badge {{ $statusAppearance['class'] }} fs-6">
                    <i class="bi {{ $statusAppearance['icon'] }} me-1"></i>
                    {{ $statusAppearance['label'] }}
                </span>
            </div>
            <h1 class="h3 mb-1">{{ $payment->payment_number }}</h1>
            <p class="text-muted mb-0">Invoice: <a href="{{ route('invoices.show', $payment->invoice) }}" class="text-decoration-none">{{ $payment->invoice?->invoice_number }}</a></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Kembali ke Daftar</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-3">Detail Pembayaran</div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Siswa</span>
                    <span class="fw-semibold">{{ $payment->invoice?->student?->nama_lengkap ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Tanggal Bayar</span>
                    <span class="fw-semibold">{{ $payment->payment_date?->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Nominal</span>
                    <span class="fw-bold fs-5">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Metode</span>
                    <span class="badge text-bg-light fs-6 fw-normal">{{ $methodLabel }}</span>
                </div>
                @if($payment->sender_name)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Pengirim</span>
                        <span class="fw-semibold">{{ $payment->sender_name }}</span>
                    </div>
                @endif
                @if($payment->proof_reference)
                    <div class="mt-3">
                        <div class="text-muted small mb-2">Bukti Pembayaran</div>
                        @if($proofIsImage)
                            <a href="{{ route('payments.proof', $payment) }}" target="_blank">
                                <img src="{{ route('payments.proof', $payment) }}" alt="Bukti pembayaran" class="payment-proof-preview">
                            </a>
                        @else
                            <div class="file-preview-card">
                                <i class="bi bi-file-earmark-pdf fs-3 text-danger"></i>
                                <span class="small text-truncate">{{ $proofName }}</span>
                            </div>
                        @endif
                        <a href="{{ route('payments.proof', $payment) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-eye me-1"></i>Lihat Bukti
                        </a>
                    </div>
                @endif
                @if($payment->notes)
                    <hr class="my-2">
                    <div class="small text-muted">Catatan: {{ $payment->notes }}</div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-3">Status Invoice Terkait</div>
                @php($invPayPercent = $payment->invoice && $payment->invoice->total_amount > 0 ? (int) round(($payment->invoice->approved_payment_total / $payment->invoice->total_amount) * 100) : 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Status Invoice</span>
                    <span class="badge {{ match($payment->invoice?->status) { 'PAID' => 'text-bg-success', 'PARTIAL' => 'text-bg-warning', 'UNPAID' => 'text-bg-secondary', 'CANCELLED' => 'text-bg-danger', default => 'text-bg-light' } }}">
                        {{ $payment->invoice?->status ?? '-' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Invoice</span>
                    <span class="fw-semibold">Rp{{ number_format($payment->invoice?->total_amount ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Telah Dibayar</span>
                    <span class="fw-semibold text-success">Rp{{ number_format($payment->invoice?->approved_payment_total ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted small">Sisa Tagihan</span>
                    <span class="fw-semibold {{ ($payment->invoice?->remaining_amount ?? 0) > 0 ? 'text-danger' : 'text-success' }}">
                        Rp{{ number_format($payment->invoice?->remaining_amount ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                <div class="mini-progress" style="height: 0.85rem;">
                    <div class="mini-progress-bar tone-info" data-progress-width="{{ $invPayPercent }}"></div>
                </div>
                <div class="text-end small text-muted mt-1">{{ $invPayPercent }}% lunas</div>
            </div>
        </div>
    </div>

    @if($payment->status === 'PENDING')
        <div class="border rounded-4 p-4" style="background: rgba(255, 243, 205, 0.3); border-color: rgba(226, 166, 75, 0.3) !important;">
            <div class="section-label mb-3">Aksi Verifikasi</div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="border rounded-4 p-4 h-100 bg-white">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="fs-4 text-success"><i class="bi bi-check-circle-fill"></i></span>
                            <div>
                                <div class="fw-semibold">Setujui Pembayaran</div>
                                <div class="small text-muted">Konfirmasi jika data sudah sesuai.</div>
                            </div>
                        </div>
                        <form action="{{ route('payments.approve', $payment) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Catatan (opsional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Tambahkan catatan jika perlu..."></textarea>
                            </div>
                            <button class="btn btn-success w-100"><i class="bi bi-check-lg me-1"></i>Setujui Pembayaran</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded-4 p-4 h-100 bg-white">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="fs-4 text-danger"><i class="bi bi-x-circle-fill"></i></span>
                            <div>
                                <div class="fw-semibold">Tolak Pembayaran</div>
                                <div class="small text-muted">Berikan alasan penolakan yang jelas.</div>
                            </div>
                        </div>
                        <form action="{{ route('payments.reject', $payment) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Wajib diisi..." required></textarea>
                            </div>
                            <button class="btn btn-danger w-100"><i class="bi bi-x-lg me-1"></i>Tolak Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
