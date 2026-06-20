<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembayaran - {{ $payment->payment_number }}</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 13px; max-width: 350px; margin: 0 auto; padding: 20px; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 16px; }
        .mt-3 { margin-top: 16px; }
        .border-bottom { border-bottom: 1px dashed #000; padding-bottom: 12px; }
        table { width: 100%; }
        td { padding: 3px 0; }
        td:last-child { text-align: right; }
        .approved { color: #198754; font-weight: bold; }
        hr { border: none; border-top: 1px dashed #000; }
    </style>
</head>
<body>
    @php($school = $schoolProfile)
    <div class="text-center mb-3">
        <div class="fw-bold fs-5">{{ $school?->nama_sekolah ?? 'SIMIN-PK' }}</div>
        <div class="small">{{ $school?->alamat ?? '-' }}</div>
        <div class="small">{{ $school?->telepon ?? '' }} {{ $school?->email ? '| ' . $school->email : '' }}</div>
    </div>
    <hr>
    <div class="text-center mb-2">
        <div class="fw-bold fs-5">NOTA PEMBAYARAN</div>
        <div>No. {{ $payment->payment_number }}</div>
    </div>
    <hr>
    <table>
        <tr><td>Tanggal</td><td>{{ $payment->payment_date?->format('d/m/Y') }}</td></tr>
        <tr><td>Siswa</td><td>{{ $payment->invoice?->student?->nama_lengkap ?? '-' }}</td></tr>
        <tr><td>Invoice</td><td>{{ $payment->invoice?->invoice_number ?? '-' }}</td></tr>
        <tr><td>Metode</td><td>{{ $payment->payment_method }}</td></tr>
        <tr><td>Pengirim</td><td>{{ $payment->sender_name }}</td></tr>
    </table>
    <hr>
    <table>
        <tr><td class="fw-bold">Jumlah Dibayar</td><td class="fw-bold">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td></tr>
        <tr><td>Status</td><td class="approved">{{ $payment->status }}</td></tr>
    </table>
    <hr>
    <div class="text-center mt-3 small">
        <div>Terima kasih telah melakukan pembayaran tepat waktu.</div>
        <div class="mt-2">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
    </div>
    <script>window.print();</script>
</body>
</html>
