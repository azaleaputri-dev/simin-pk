@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="section-label">Modul Siswa</div>
            <h1 class="h3 mb-0">Data Siswa Aktif</h1>
        </div>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Tambah Siswa</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>NIS</th><th>Nama</th><th>Orang Tua</th><th>Kelas</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $student->nis }}</td>
                        <td>
                            <div class="fw-semibold">{{ $student->nama_lengkap }}</div>
                            <div class="small text-muted">{{ $student->academicYear?->name ?? '-' }}</div>
                        </td>
                        <td>{{ $student->guardian?->name ?? '-' }}</td>
                        <td>{{ $student->kelas?->name ?? '-' }}</td>
                        <td><span class="badge text-bg-light">{{ $student->status_siswa }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data siswa ini?')">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
