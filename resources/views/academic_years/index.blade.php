@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="section-label">Master Sekolah</div>
            <h1 class="h3 mb-1">Tahun Ajaran</h1>
            <p class="text-muted mb-0">Pastikan hanya satu tahun ajaran aktif agar transaksi dan penempatan siswa tetap konsisten.</p>
        </div>
        <a href="{{ route('academic-years.create') }}" class="btn btn-primary">Tambah Tahun Ajaran</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($academicYears as $year)
                    <tr>
                        <td class="fw-semibold">{{ $year->name }}</td>
                        <td>{{ $year->start_date }}</td>
                        <td>{{ $year->end_date }}</td>
                        <td>
                            @if($year->is_active)
                                <span class="badge text-bg-success">Aktif</span>
                            @else
                                <span class="badge text-bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('academic-years.show', $year) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('academic-years.edit', $year) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            @if(!$year->is_active)
                                <form action="{{ route('academic-years.destroy', $year) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus tahun ajaran ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Data tahun ajaran belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
