@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="section-label">Modul Kelas</div>
            <h1 class="h3 mb-0">Daftar Kelas</h1>
        </div>
        <a href="{{ route('kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nama</th><th>Jenjang</th><th>Tahun Ajaran</th><th>Kuota</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($kelas as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->jenjang }}</td>
                        <td>{{ $item->academicYear?->name ?? '-' }}</td>
                        <td>{{ $item->quota }}</td>
                        <td>{{ $item->status ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="text-end">
                            <a href="{{ route('kelas.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('kelas.destroy', $item) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus kelas ini?')">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data kelas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
