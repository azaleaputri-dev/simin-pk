@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><div class="section-label">Keuangan</div><h1 class="h3 mb-0">Tarif</h1></div>
        <a href="{{ route('tariffs.create') }}" class="btn btn-primary">Tambah Tarif</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nama</th><th>Jenis Biaya</th><th>Tahun Ajaran</th><th>Nominal</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($tariffs as $tariff)
                    <tr>
                        <td>{{ $tariff->name }}</td>
                        <td>{{ $tariff->feeType?->name }}</td>
                        <td>{{ $tariff->academicYear?->name }}</td>
                        <td>Rp{{ number_format($tariff->amount, 0, ',', '.') }}</td>
                        <td>{{ $tariff->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="text-end">
                            <a href="{{ route('tariffs.edit', $tariff) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('tariffs.destroy', $tariff) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus tarif ini?')">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada tarif.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
