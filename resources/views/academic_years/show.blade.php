@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="section-label">Master Sekolah</div>
            <h1 class="h3 mb-1">{{ $academicYear->name }}</h1>
            <p class="text-muted mb-0">Detail tahun ajaran yang dipakai untuk transaksi dan penempatan siswa.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('academic-years.edit', $academicYear) }}" class="btn btn-outline-primary">Edit</a>
            <a href="{{ route('academic-years.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100 bg-white">
                <div class="section-label mb-3">Periode</div>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama</dt><dd class="col-sm-8">{{ $academicYear->name }}</dd>
                    <dt class="col-sm-4">Mulai</dt><dd class="col-sm-8">{{ $academicYear->start_date }}</dd>
                    <dt class="col-sm-4">Selesai</dt><dd class="col-sm-8">{{ $academicYear->end_date }}</dd>
                </dl>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100 bg-white">
                <div class="section-label mb-3">Status</div>
                @if($academicYear->is_active)
                    <span class="badge text-bg-success px-3 py-2">Tahun Ajaran Aktif</span>
                @else
                    <span class="badge text-bg-secondary px-3 py-2">Tidak Aktif</span>
                @endif
                <p class="text-muted mt-3 mb-0">Hanya satu tahun ajaran aktif yang boleh dipakai oleh transaksi berjalan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
