@extends('layouts.app')

@php
    $statusAppearance = fn($s) => match ($s) {
        'PAID' => ['label' => 'Lunas', 'class' => 'text-bg-success'],
        'PARTIAL' => ['label' => 'Angsuran', 'class' => 'text-bg-warning'],
        'UNPAID' => ['label' => 'Belum Dibayar', 'class' => 'text-bg-secondary'],
        'CANCELLED' => ['label' => 'Dibatalkan', 'class' => 'text-bg-danger'],
        default => ['label' => $s, 'class' => 'text-bg-light'],
    };
@endphp

@section('content')
<div class="page-card p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="section-label">Keuangan</div>
            <h1 class="h3 mb-1">Invoice</h1>
            <p class="text-muted mb-0">Daftar tagihan siswa dan status pembayaran.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('fee-types.index') }}" class="btn btn-outline-secondary btn-sm">Jenis Biaya</a>
            <a href="{{ route('tariffs.index') }}" class="btn btn-outline-secondary btn-sm">Tarif</a>
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">Buat Invoice</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Siswa</th>
                    <th>Jatuh Tempo</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Sisa</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    @php($appearance = $statusAppearance($invoice->status))
                    @php($isOverdue = $invoice->due_date && $invoice->due_date->isPast() && in_array($invoice->status, ['UNPAID', 'PARTIAL']))
                    <tr class="{{ $isOverdue ? 'table-warning' : '' }}">
                        <td class="fw-semibold">{{ $invoice->invoice_number }}</td>
                        <td>
                            <div>{{ $invoice->student?->nama_lengkap ?? '-' }}</div>
                            @if($invoice->guardian)
                                <div class="small text-muted">{{ $invoice->guardian->name }}</div>
                            @endif
                        </td>
                        <td>
                            {{ $invoice->due_date?->format('d M Y') }}
                            @if($isOverdue)
                                <span class="badge text-bg-danger ms-1">Overdue</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold">Rp{{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                        <td class="text-end {{ $invoice->remaining_amount > 0 ? 'text-danger fw-semibold' : 'text-success' }}">
                            Rp{{ number_format($invoice->remaining_amount, 0, ',', '.') }}
                        </td>
                        <td><span class="badge {{ $appearance['class'] }}">{{ $appearance['label'] }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            @if(!$invoice->isPaid())
                                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            @endif
                            @if(!$invoice->hasPaymentsRecorded())
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus invoice ini?')">Hapus</button></form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">Belum ada invoice. <a href="{{ route('invoices.create') }}">Buat invoice baru</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
