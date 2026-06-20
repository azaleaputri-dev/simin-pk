@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @php($portalPageEyebrow = 'Portal Orang Tua')
    @php($portalPageTitle = 'Kontak Sekolah')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    @php($school = $schoolProfile)
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="surface-card card-tone-teal-light h-100">
                <div class="section-label mb-2">Informasi Kontak</div>
                <h3 class="h5 mb-3">{{ $school?->nama_sekolah ?? 'SIMIN-PK' }}</h3>
                <div class="dashboard-stack">
                    @if($school?->telepon)
                        <a href="tel:{{ $school->telepon }}" class="list-surface-item text-decoration-none d-block mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <span class="stat-card-icon" style="background: rgba(31, 122, 140, 0.15); color: #1e6c7d;"><i class="bi bi-telephone-fill"></i></span>
                                <div>
                                    <div class="fw-semibold">Telepon</div>
                                    <div class="small text-muted">{{ $school->telepon }}</div>
                                </div>
                            </div>
                        </a>
                    @endif
                    @php($cleanPhone = $school?->telepon ? preg_replace('/[^0-9]/', '', $school->telepon) : '')
                    @php($waNumber = $cleanPhone ? (str_starts_with($cleanPhone, '0') ? '62' . substr($cleanPhone, 1) : (str_starts_with($cleanPhone, '62') ? $cleanPhone : '62' . $cleanPhone)) : '')
                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="list-surface-item text-decoration-none d-block mb-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="stat-card-icon" style="background: rgba(37, 211, 102, 0.15); color: #25d366;"><i class="bi bi-whatsapp"></i></span>
                            <div>
                                <div class="fw-semibold">WhatsApp</div>
                                <div class="small text-muted">{{ $school?->telepon ?? '-' }}</div>
                            </div>
                        </div>
                    </a>
                    @if($school?->email)
                        <a href="mailto:{{ $school->email }}" class="list-surface-item text-decoration-none d-block mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <span class="stat-card-icon" style="background: rgba(226, 166, 75, 0.15); color: #b8860b;"><i class="bi bi-envelope-fill"></i></span>
                                <div>
                                    <div class="fw-semibold">Email</div>
                                    <div class="small text-muted">{{ $school->email }}</div>
                                </div>
                            </div>
                        </a>
                    @endif
                    @if($school?->alamat)
                        <a href="https://maps.google.com/?q={{ urlencode($school->alamat) }}" target="_blank" class="list-surface-item text-decoration-none d-block mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <span class="stat-card-icon" style="background: rgba(220, 100, 90, 0.15); color: #dc645a;"><i class="bi bi-geo-alt-fill"></i></span>
                                <div>
                                    <div class="fw-semibold">Alamat</div>
                                    <div class="small text-muted">{{ $school->alamat }}</div>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="surface-card card-tone-sand h-100">
                <div class="section-label mb-2">Formulir Bantuan</div>
                <h3 class="h5 mb-3">Kirim pesan ke admin sekolah</h3>
                <form action="{{ route('parent.portal.contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $guardian->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $guardian->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subjek</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan</label>
                        <textarea name="message" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('parent._portal_scripts')
@endsection
