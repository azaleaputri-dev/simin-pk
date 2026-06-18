@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="section-label">Modul Orang Tua</div>
            <h1 class="h3 mb-0">Data Wali Siswa</h1>
        </div>
        <a href="{{ route('parents.create') }}" class="btn btn-primary">Tambah Orang Tua</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nama</th><th>Email</th><th>No. HP</th><th>Jumlah Anak</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($parents as $parent)
                    <tr>
                        <td>{{ $parent->name }}</td>
                        <td>{{ $parent->email }}</td>
                        <td>{{ $parent->phone }}</td>
                        <td>{{ $parent->students_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data orang tua ini?')">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data orang tua.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
