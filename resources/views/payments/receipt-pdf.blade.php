<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota {{ $payment->payment_number }}</title>
    <style>
        @page { margin: 20px 24px; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: #17343a;
            font-family: DejaVu Sans, sans-serif;
            font-size: 9.5px;
            line-height: 1.45;
        }
        table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: middle; }
        .brand-mark {
            width: 48px;
            height: 48px;
            color: #fff;
            background: #1f7a8c;
            border-radius: 12px;
            font-size: 24px;
            font-weight: bold;
            line-height: 48px;
            text-align: center;
        }
        .school-name {
            margin: 0 0 2px;
            color: #12343b;
            font-size: 16px;
            font-weight: bold;
        }
        .school-meta {
            color: #687b80;
            font-size: 8px;
            line-height: 1.5;
        }
        .receipt-label {
            color: #1f7a8c;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1.2px;
            text-align: right;
        }
        .receipt-number {
            margin-top: 3px;
            font-size: 11px;
            font-weight: bold;
            text-align: right;
        }
        .divider {
            height: 3px;
            margin: 12px 0 14px;
            background: #1f7a8c;
        }
        .status-row td { vertical-align: middle; }
        .title {
            margin: 0;
            color: #12343b;
            font-size: 19px;
            font-weight: bold;
        }
        .subtitle {
            margin-top: 2px;
            color: #738489;
            font-size: 8.5px;
        }
        .status {
            display: inline-block;
            padding: 5px 11px;
            border-radius: 12px;
            color: #fff;
            background: {{ $payment->status === 'APPROVED' ? '#198754' : ($payment->status === 'REJECTED' ? '#dc3545' : '#c88918') }};
            font-size: 7.5px;
            font-weight: bold;
            letter-spacing: .4px;
        }
        .info-box {
            margin-top: 14px;
            padding: 10px 12px;
            border: 1px solid #dbe7e9;
            border-radius: 9px;
            background: #f6fafb;
        }
        .info-grid td {
            width: 50%;
            padding: 4px 10px 4px 0;
            vertical-align: top;
        }
        .info-label {
            display: block;
            margin-bottom: 1px;
            color: #738489;
            font-size: 7.5px;
            text-transform: uppercase;
        }
        .info-value {
            color: #17343a;
            font-size: 9.5px;
            font-weight: bold;
        }
        .section { margin-top: 15px; }
        .section-title {
            margin-bottom: 7px;
            color: #1f7a8c;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: .8px;
            text-transform: uppercase;
        }
        .items {
            border: 1px solid #dbe7e9;
            border-radius: 8px;
        }
        .items th {
            padding: 7px 8px;
            color: #fff;
            background: #12343b;
            font-size: 7.5px;
            text-align: left;
            text-transform: uppercase;
        }
        .items td {
            padding: 8px;
            border-bottom: 1px solid #e5edef;
            vertical-align: top;
        }
        .items tr:last-child td { border-bottom: 0; }
        .item-meta { color: #75868a; font-size: 7.5px; }
        .text-right { text-align: right !important; }
        .summary {
            margin-top: 12px;
            margin-left: 42%;
        }
        .summary td { padding: 3px 0 3px 10px; }
        .summary td:first-child { color: #6b7c80; }
        .summary .grand-total td {
            padding-top: 8px;
            border-top: 2px solid #1f7a8c;
            color: #12343b;
            font-size: 12px;
            font-weight: bold;
        }
        .amount-banner {
            margin-top: 13px;
            padding: 11px 13px;
            color: #fff;
            background: #1f7a8c;
            border-radius: 9px;
        }
        .amount-banner table td { vertical-align: middle; }
        .amount-label { font-size: 8px; text-transform: uppercase; }
        .amount-value { font-size: 17px; font-weight: bold; text-align: right; }
        .notes {
            margin-top: 12px;
            padding: 8px 10px;
            color: #5f7074;
            border-left: 3px solid #e2a64b;
            background: #fff9ed;
        }
        .signature-table {
            margin-top: 22px;
            text-align: center;
        }
        .signature-table td { width: 50%; vertical-align: bottom; }
        .signature-space { height: 42px; }
        .signature-name {
            display: inline-block;
            min-width: 120px;
            padding-top: 4px;
            border-top: 1px solid #51666b;
            font-weight: bold;
        }
        .footer {
            margin-top: 18px;
            padding-top: 8px;
            border-top: 1px dashed #aebdc0;
            color: #718388;
            font-size: 7px;
            text-align: center;
        }
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
            $schoolProfile?->kode_pos,
        ])->filter()->implode(', ');
        $methodLabel = $payment->payment_method === 'TRANSFER_BANK' ? 'Transfer Bank' : 'Tunai';
        $statusLabel = match ($payment->status) {
            'APPROVED' => 'PEMBAYARAN DISETUJUI',
            'REJECTED' => 'PEMBAYARAN DITOLAK',
            default => 'MENUNGGU VERIFIKASI',
        };
        $guardianName = $payment->invoice?->guardian?->name
            ?? $payment->invoice?->student?->guardian?->name
            ?? '-';
        $invoiceTotal = (float) ($payment->invoice?->total_amount ?? $payment->amount);
        $remainingAmount = max((float) ($payment->invoice?->remaining_amount ?? 0), 0);
    @endphp

    <table class="header-table">
        <tr>
            <td style="width:58px;"><div class="brand-mark">S</div></td>
            <td>
                <div class="school-name">{{ $schoolName }}</div>
                <div class="school-meta">
                    {{ $schoolAddress ?: 'Alamat sekolah belum diatur' }}<br>
                    @if($schoolProfile?->telepon) Tel. {{ $schoolProfile->telepon }} @endif
                    @if($schoolProfile?->email) &nbsp;|&nbsp; {{ $schoolProfile->email }} @endif
                    @if($schoolProfile?->website) &nbsp;|&nbsp; {{ $schoolProfile->website }} @endif
                </div>
            </td>
            <td style="width:145px;">
                <div class="receipt-label">BUKTI PEMBAYARAN</div>
                <div class="receipt-number">{{ $payment->payment_number }}</div>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="status-row">
        <tr>
            <td>
                <div class="title">Nota Pembayaran</div>
                <div class="subtitle">Bukti pencatatan transaksi keuangan sekolah</div>
            </td>
            <td class="text-right"><span class="status">{{ $statusLabel }}</span></td>
        </tr>
    </table>

    <div class="info-box">
        <table class="info-grid">
            <tr>
                <td>
                    <span class="info-label">Nama Siswa</span>
                    <span class="info-value">{{ $payment->invoice?->student?->nama_lengkap ?? '-' }}</span>
                </td>
                <td>
                    <span class="info-label">Nomor Invoice</span>
                    <span class="info-value">{{ $payment->invoice?->invoice_number ?? '-' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="info-label">NIS / Wali Murid</span>
                    <span class="info-value">{{ $payment->invoice?->student?->nis ?? '-' }} / {{ $guardianName }}</span>
                </td>
                <td>
                    <span class="info-label">Tanggal Pembayaran</span>
                    <span class="info-value">{{ $payment->payment_date?->translatedFormat('d F Y') ?? '-' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="info-label">Tahun Ajaran</span>
                    <span class="info-value">{{ $payment->invoice?->academicYear?->name ?? '-' }}</span>
                </td>
                <td>
                    <span class="info-label">Metode / Pengirim</span>
                    <span class="info-value">{{ $methodLabel }}{{ $payment->sender_name ? ' / ' . $payment->sender_name : '' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Rincian Pembayaran</div>
        <table class="items">
            <thead>
                <tr>
                    <th style="width:34px;">No.</th>
                    <th>Keterangan Tagihan</th>
                    <th class="text-right" style="width:125px;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payment->invoice?->items ?? [] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->description }}</strong>
                            @if($item->feeType?->name)
                                <br><span class="item-meta">{{ $item->feeType->name }}</span>
                            @endif
                        </td>
                        <td class="text-right">Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>1</td>
                        <td><strong>Pembayaran {{ $payment->invoice?->invoice_number }}</strong></td>
                        <td class="text-right">Rp{{ number_format($invoiceTotal, 0, ',', '.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <table class="summary">
        <tr>
            <td>Total Invoice</td>
            <td class="text-right">Rp{{ number_format($invoiceTotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Sisa Tagihan</td>
            <td class="text-right">Rp{{ number_format($remainingAmount, 0, ',', '.') }}</td>
        </tr>
        <tr class="grand-total">
            <td>Dibayarkan</td>
            <td class="text-right">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="amount-banner">
        <table>
            <tr>
                <td class="amount-label">Jumlah pembayaran diterima</td>
                <td class="amount-value">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    @if($payment->notes)
        <div class="notes"><strong>Catatan:</strong> {{ $payment->notes }}</div>
    @endif

    <table class="signature-table">
        <tr>
            <td>
                Penerima,
                <div class="signature-space"></div>
                <span class="signature-name">Bendahara Sekolah</span>
            </td>
            <td>
                Orang Tua / Wali,
                <div class="signature-space"></div>
                <span class="signature-name">{{ $guardianName }}</span>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen dibuat otomatis oleh SIMIN-PK pada {{ now()->translatedFormat('d F Y, H:i') }} WIB.<br>
        Simpan nota ini sebagai bukti transaksi. Keabsahan pembayaran mengikuti status verifikasi pada sistem.
    </div>
</body>
</html>
