@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><div class="section-label">Keuangan</div><h1 class="h3 mb-0">Jenis Biaya</h1></div>
        <a href="{{ route('fee-types.create') }}" class="btn btn-primary">Tambah Jenis Biaya</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nama</th><th>Kode</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($feeTypes as $feeType)
                    <tr>
                        <td>{{ $feeType->name }}</td>
                        <td>{{ $feeType->code }}</td>
                        <td>{{ $feeType->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="text-end">
                            <a href="{{ route('fee-types.edit', $feeType) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('fee-types.destroy', $feeType) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus jenis biaya ini?')">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada jenis biaya.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
