@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="section-label">Master Sekolah</div>
            <h1 class="h3 mb-1">Profil Sekolah</h1>
            <p class="text-muted mb-0">Kelola identitas sekolah yang dipakai di laporan, invoice, dan dokumen operasional.</p>
        </div>
        <a href="{{ route('profil-sekolahs.create') }}" class="btn btn-primary">Tambah Profil Sekolah</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nama Sekolah</th>
                    <th>NPSN</th>
                    <th>Status</th>
                    <th>Akreditasi</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($profilSekolahs as $profilSekolah)
                    <tr>
                        <td class="fw-semibold">{{ $profilSekolah->nama_sekolah }}</td>
                        <td>{{ $profilSekolah->npsn ?: '-' }}</td>
                        <td class="text-capitalize">{{ $profilSekolah->status }}</td>
                        <td>{{ $profilSekolah->akreditasi ?: '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('profil-sekolahs.show', $profilSekolah) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('profil-sekolahs.edit', $profilSekolah) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('profil-sekolahs.destroy', $profilSekolah) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus profil sekolah ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Data profil sekolah belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
