@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @php($portalPageEyebrow = 'Portal Orang Tua')
    @php($portalPageTitle = 'Data Anak')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    @forelse($students as $student)
        <div class="surface-card card-tone-teal-light mb-4">
            <div class="section-label mb-2">Data Siswa</div>
            <h3 class="h5 mb-3">{{ $student->nama_lengkap }}</h3>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="list-surface-item h-100 mb-0">
                        <div class="small text-muted">NIS</div>
                        <div class="fw-semibold">{{ $student->nis ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="list-surface-item h-100 mb-0">
                        <div class="small text-muted">Kelas</div>
                        <div class="fw-semibold">{{ $student->kelas?->name ?? 'Belum ditempatkan' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="list-surface-item h-100 mb-0">
                        <div class="small text-muted">Tahun Ajaran</div>
                        <div class="fw-semibold">{{ $student->academicYear?->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="list-surface-item h-100 mb-0">
                        <div class="small text-muted">Status</div>
                        <div class="fw-semibold">{{ $student->status_siswa ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="list-surface-item h-100 mb-0">
                        <div class="small text-muted">NISN</div>
                        <div class="fw-semibold">{{ $student->nisn ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="list-surface-item h-100 mb-0">
                        <div class="small text-muted">Tempat / Tgl Lahir</div>
                        <div class="fw-semibold">{{ $student->tempat_lahir ?? '-' }} / {{ $student->tanggal_lahir?->format('d M Y') ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="section-label mt-4 mb-2">Ajukan Perbaikan Data</div>
                <form action="{{ route('parent.portal.correction') }}" method="POST" class="row g-3">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <div class="col-md-3">
                        <label class="form-label small">Field</label>
                        <select name="field" class="form-select" required>
                            <option value="">Pilih field</option>
                            <option value="nama_lengkap">Nama Lengkap</option>
                            <option value="nisn">NISN</option>
                            <option value="tempat_lahir">Tempat Lahir</option>
                            <option value="tanggal_lahir">Tanggal Lahir</option>
                            <option value="alamat">Alamat</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Nilai Saat Ini</label>
                        <input type="text" name="current_value" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Nilai yang Diajukan</label>
                        <input type="text" name="proposed_value" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Alasan</label>
                        <input type="text" name="reason" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-send me-1"></i>Ajukan Perbaikan</button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <div class="surface-card card-tone-sand text-center py-5">
            <i class="bi bi-mortarboard-fill fs-1 text-muted"></i>
            <p class="text-muted mt-2 mb-0">Belum ada data anak yang terhubung ke akun ini.</p>
        </div>
    @endforelse
</div>
@include('parent._portal_scripts')
@endsection
