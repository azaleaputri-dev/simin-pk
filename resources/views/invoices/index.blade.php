@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><div class="section-label">Keuangan</div><h1 class="h3 mb-0">Invoice</h1></div>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">Buat Invoice</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>No. Invoice</th><th>Siswa</th><th>Jatuh Tempo</th><th>Total</th><th>Sisa</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->student?->nama_lengkap }}</td>
                        <td>{{ $invoice->due_date?->format('d M Y') }}</td>
                        <td>Rp{{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($invoice->remaining_amount, 0, ',', '.') }}</td>
                        <td>{{ $invoice->status }}</td>
                        <td class="text-end">
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus invoice ini?')">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada invoice.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
