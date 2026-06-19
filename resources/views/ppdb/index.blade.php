@extends('layouts.app')

@section('content')
@php($activeYear = \App\Models\AcademicYear::getActive())
<div class="page-card p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="section-label">Modul PPDB</div>
                @if($activeYear)
                    <span class="badge {{ $activeYear->ppdbStatusBadge()['class'] }}">
                        <i class="bi {{ $activeYear->isPpdbOpen() ? 'bi-unlock-fill' : 'bi-lock-fill' }} me-1"></i>
                        {{ $activeYear->ppdbStatusBadge()['label'] }}
                    </span>
                @endif
            </div>
            <h1 class="h3 mb-1">Daftar Pendaftar</h1>
            <p class="text-muted mb-0">Status diterima akan otomatis menyiapkan akun orang tua dan data siswa.</p>
        </div>
        <a href="{{ route('ppdb.create') }}" class="btn btn-primary">Tambah Pendaftar</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Orang Tua</th>
                    <th>Asal Sekolah</th>
                    <th>Status</th>
                    <th>Siswa</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ppdbs as $ppdb)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $ppdb->nama_lengkap }}</div>
                            <div class="small text-muted">{{ $ppdb->nik }}</div>
                        </td>
                        <td>
                            <div>{{ $ppdb->nama_orang_tua }}</div>
                            <div class="small text-muted">{{ $ppdb->no_hp_orang_tua }}</div>
                        </td>
                        <td>{{ $ppdb->asal_sekolah }}</td>
                        <td><span class="badge text-bg-light">{{ $ppdb->status_pendaftaran }}</span></td>
                        <td>
                            @if($ppdb->student)
                                <span class="badge text-bg-success">{{ $ppdb->student->nis }}</span>
                            @else
                                <span class="text-muted small">Belum dibuat</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('ppdb.show', $ppdb) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('ppdb.edit', $ppdb) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('ppdb.destroy', $ppdb) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data pendaftar ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data pendaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
