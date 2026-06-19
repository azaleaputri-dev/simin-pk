<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota {{ $payment->payment_number }}</title>
    <style>
        @page { margin: 24px; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: #17343a;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.45;
        }
        .header {
            padding-bottom: 14px;
            border-bottom: 2px solid #1f7a8c;
        }
        .school-name {
            margin: 0 0 4px;
            color: #12343b;
            font-size: 18px;
            font-weight: bold;
        }
        .school-meta { color: #607278; font-size: 9px; }
        .receipt-title {
            margin: 18px 0 4px;
            text-align: center;
            font-size: 17px;
            letter-spacing: 1px;
        }
        .receipt-number {
            text-align: center;
            color: #607278;
            font-size: 9px;
        }
        .status {
            display: inline-block;
            margin-top: 6px;
            padding: 4px 10px;
            border-radius: 10px;
            color: #fff;
            background: {{ $payment->status === 'APPROVED' ? '#198754' : ($payment->status === 'REJECTED' ? '#dc3545' : '#c88918') }};
            font-size: 8px;
            font-weight: bold;
        }
        .section { margin-top: 16px; }
        .section-title {
            margin-bottom: 7px;
            color: #1f7a8c;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: .7px;
            text-transform: uppercase;
        }
        table { width: 100%; border-collapse: collapse; }
        .info td { padding: 3px 0; vertical-align: top; }
        .info td:first-child { width: 36%; color: #6b7c80; }
        .items th, .items td {
            padding: 7px 6px;
            border-bottom: 1px solid #dce6e8;
        }
        .items th {
            color: #607278;
            background: #edf6f7;
            font-size: 8px;
            text-align: left;
        }
        .text-right { text-align: right !important; }
        .total-box {
            margin-top: 12px;
            padding: 12px;
            color: #fff;
            background: #12343b;
        }
        .total-label { font-size: 9px; }
        .total-value { float: right; font-size: 16px; font-weight: bold; }
        .notes {
            margin-top: 13px;
            padding: 9px;
            color: #5f7074;
            background: #f5f8f8;
        }
        .footer {
            margin-top: 24px;
            padding-top: 10px;
            border-top: 1px dashed #aebdc0;
            color: #6b7c80;
            font-size: 8px;
            text-align: center;
        }
        .clearfix::after { display: table; clear: both; content: ""; }
    </style>
</head>
<body>
    @php
        $schoolName = $schoolProfile?->nama_sekolah ?? 'SIMIN-PK';
        $schoolAddress = collect([
            $schoolProfile?->alamat,
            $schoolProfile?->kecamatan,
            $schoolProfile?->kabupaten,
            $schoolProfile?->provinsi,
        ])->filter()->implode(', ');
        $methodLabel = $payment->payment_method === 'TRANSFER_BANK' ? 'Transfer Bank' : 'Tunai';
        $statusLabel = match ($payment->status) {
            'APPROVED' => 'DISETUJUI',
            'REJECTED' => 'DITOLAK',
            default => 'MENUNGGU VERIFIKASI',
        };
    @endphp

    <div class="header">
        <div class="school-name">{{ $schoolName }}</div>
        <div class="school-meta">
            {{ $schoolAddress ?: 'Alamat sekolah belum diatur' }}
            @if($schoolProfile?->telepon) | Tel. {{ $schoolProfile->telepon }} @endif
            @if($schoolProfile?->email) | {{ $schoolProfile->email }} @endif
        </div>
    </div>

    <div class="receipt-title">NOTA PEMBAYARAN</div>
    <div class="receipt-number">
        {{ $payment->payment_number }}<br>
        <span class="status">{{ $statusLabel }}</span>
    </div>

    <div class="section">
        <div class="section-title">Informasi Pembayaran</div>
        <table class="info">
            <tr><td>Tanggal Pembayaran</td><td>: {{ $payment->payment_date?->format('d M Y') ?? '-' }}</td></tr>
            <tr><td>Nomor Invoice</td><td>: {{ $payment->invoice?->invoice_number ?? '-' }}</td></tr>
            <tr><td>Nama Siswa</td><td>: {{ $payment->invoice?->student?->nama_lengkap ?? '-' }}</td></tr>
            <tr><td>NIS</td><td>: {{ $payment->invoice?->student?->nis ?? '-' }}</td></tr>
            <tr><td>Orang Tua/Wali</td><td>: {{ $payment->invoice?->guardian?->name ?? $payment->invoice?->student?->guardian?->name ?? '-' }}</td></tr>
            <tr><td>Tahun Ajaran</td><td>: {{ $payment->invoice?->academicYear?->name ?? '-' }}</td></tr>
            <tr><td>Metode</td><td>: {{ $methodLabel }}</td></tr>
            @if($payment->sender_name)
                <tr><td>Nama Pengirim</td><td>: {{ $payment->sender_name }}</td></tr>
            @endif
        </table>
    </div>

    <div class="section">
        <div class="section-title">Rincian Tagihan</div>
        <table class="items">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th class="text-right">Nominal Tagihan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payment->invoice?->items ?? [] as $item)
                    <tr>
                        <td>
                            {{ $item->description }}
                            @if($item->feeType?->name)<br><span style="color:#75868a;font-size:8px;">{{ $item->feeType->name }}</span>@endif
                        </td>
                        <td class="text-right">Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>Pembayaran invoice {{ $payment->invoice?->invoice_number }}</td>
                        <td class="text-right">Rp{{ number_format($payment->invoice?->total_amount ?? $payment->amount, 0, ',', '.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="total-box clearfix">
        <span class="total-label">Jumlah Dibayarkan</span>
        <span class="total-value">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
    </div>

    @if($payment->notes)
        <div class="notes"><strong>Catatan:</strong> {{ $payment->notes }}</div>
    @endif

    <div class="footer">
        Nota dibuat otomatis oleh SIMIN-PK pada {{ now()->format('d M Y H:i') }}.<br>
        Simpan dokumen ini sebagai bukti pencatatan pembayaran.
    </div>
</body>
</html>
