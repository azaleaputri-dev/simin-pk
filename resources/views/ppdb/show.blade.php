@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="section-label">Detail PPDB</div>
            <h1 class="h3 mb-1">{{ $ppdb->nama_lengkap }}</h1>
            <p class="text-muted mb-0">Status saat ini: {{ $ppdb->status_pendaftaran }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('ppdb.edit', $ppdb) }}" class="btn btn-outline-primary">Edit</a>
            <a href="{{ route('ppdb.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-3">Data Siswa</div>
                <dl class="row mb-0">
                    <dt class="col-sm-4">NIK</dt><dd class="col-sm-8">{{ $ppdb->nik }}</dd>
                    <dt class="col-sm-4">TTL</dt><dd class="col-sm-8">{{ $ppdb->tempat_lahir }}, {{ optional($ppdb->tanggal_lahir)->format('d M Y') }}</dd>
                    <dt class="col-sm-4">Jenis Kelamin</dt><dd class="col-sm-8">{{ $ppdb->jenis_kelamin }}</dd>
                    <dt class="col-sm-4">Agama</dt><dd class="col-sm-8">{{ $ppdb->agama }}</dd>
                    <dt class="col-sm-4">Alamat</dt><dd class="col-sm-8">{{ $ppdb->alamat }}</dd>
                    <dt class="col-sm-4">Asal Sekolah</dt><dd class="col-sm-8">{{ $ppdb->asal_sekolah }}</dd>
                </dl>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100">
                <div class="section-label mb-3">Data Orang Tua & Approval</div>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama</dt><dd class="col-sm-8">{{ $ppdb->nama_orang_tua }}</dd>
                    <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $ppdb->email_orang_tua }}</dd>
                    <dt class="col-sm-4">No. HP</dt><dd class="col-sm-8">{{ $ppdb->no_hp_orang_tua }}</dd>
                    <dt class="col-sm-4">Jalur</dt><dd class="col-sm-8">{{ $ppdb->jalur_pendaftaran }}</dd>
                    <dt class="col-sm-4">Tanggal Daftar</dt><dd class="col-sm-8">{{ optional($ppdb->tanggal_daftar)->format('d M Y') }}</dd>
                    <dt class="col-sm-4">Siswa Aktif</dt>
                    <dd class="col-sm-8">
                        @if($ppdb->student)
                            {{ $ppdb->student->nis }} / {{ $ppdb->student->status_siswa }}
                        @else
                            <span class="text-muted">Belum terbentuk</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
