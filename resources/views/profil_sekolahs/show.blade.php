@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="section-label">Master Sekolah</div>
            <h1 class="h3 mb-1">{{ $profilSekolah->nama_sekolah }}</h1>
            <p class="text-muted mb-0">Detail identitas sekolah untuk kebutuhan operasional dan dokumen sistem.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('profil-sekolahs.edit', $profilSekolah) }}" class="btn btn-outline-primary">Edit</a>
            <a href="{{ route('profil-sekolahs.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    @php($fasilitas = is_array($profilSekolah->fasilitas) ? $profilSekolah->fasilitas : (json_decode($profilSekolah->fasilitas ?? '[]', true) ?: []))

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100 bg-white">
                <div class="section-label mb-3">Identitas</div>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama Sekolah</dt><dd class="col-sm-8">{{ $profilSekolah->nama_sekolah }}</dd>
                    <dt class="col-sm-4">NPSN</dt><dd class="col-sm-8">{{ $profilSekolah->npsn ?: '-' }}</dd>
                    <dt class="col-sm-4">Status</dt><dd class="col-sm-8 text-capitalize">{{ $profilSekolah->status }}</dd>
                    <dt class="col-sm-4">Akreditasi</dt><dd class="col-sm-8">{{ $profilSekolah->akreditasi ?: '-' }}</dd>
                    <dt class="col-sm-4">Tahun Berdiri</dt><dd class="col-sm-8">{{ $profilSekolah->tahun_berdiri ?: '-' }}</dd>
                    <dt class="col-sm-4">Kepala Sekolah</dt><dd class="col-sm-8">{{ $profilSekolah->kepala_sekolah ?: '-' }}</dd>
                    <dt class="col-sm-4">NIP Kepala</dt><dd class="col-sm-8">{{ $profilSekolah->nip_kepala ?: '-' }}</dd>
                </dl>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100 bg-white">
                <div class="section-label mb-3">Kontak dan Lokasi</div>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Alamat</dt><dd class="col-sm-8">{{ $profilSekolah->alamat ?: '-' }}</dd>
                    <dt class="col-sm-4">Kecamatan</dt><dd class="col-sm-8">{{ $profilSekolah->kecamatan ?: '-' }}</dd>
                    <dt class="col-sm-4">Kabupaten</dt><dd class="col-sm-8">{{ $profilSekolah->kabupaten ?: '-' }}</dd>
                    <dt class="col-sm-4">Provinsi</dt><dd class="col-sm-8">{{ $profilSekolah->provinsi ?: '-' }}</dd>
                    <dt class="col-sm-4">Kode Pos</dt><dd class="col-sm-8">{{ $profilSekolah->kode_pos ?: '-' }}</dd>
                    <dt class="col-sm-4">Telepon</dt><dd class="col-sm-8">{{ $profilSekolah->telepon ?: '-' }}</dd>
                    <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $profilSekolah->email ?: '-' }}</dd>
                    <dt class="col-sm-4">Website</dt>
                    <dd class="col-sm-8">
                        @if($profilSekolah->website)
                            <a href="{{ $profilSekolah->website }}" target="_blank">{{ $profilSekolah->website }}</a>
                        @else
                            -
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100 bg-white">
                <div class="section-label mb-3">Statistik</div>
                <div class="row g-3">
                    <div class="col-6"><div class="stat-card"><small>Jumlah Guru</small><strong>{{ $profilSekolah->jumlah_guru }}</strong></div></div>
                    <div class="col-6"><div class="stat-card"><small>Jumlah Siswa</small><strong>{{ $profilSekolah->jumlah_siswa }}</strong></div></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="border rounded-4 p-4 h-100 bg-white">
                <div class="section-label mb-3">Fasilitas</div>
                @if($fasilitas)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($fasilitas as $item)
                            <span class="badge text-bg-light px-3 py-2">{{ $item }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">Belum ada fasilitas yang dicatat.</p>
                @endif
            </div>
        </div>
        <div class="col-12">
            <div class="border rounded-4 p-4 bg-white">
                <div class="section-label mb-3">Deskripsi</div>
                <p class="mb-0">{{ $profilSekolah->deskripsi ?: 'Belum ada deskripsi sekolah.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
