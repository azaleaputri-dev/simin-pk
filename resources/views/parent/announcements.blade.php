@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @php($portalPageEyebrow = 'Portal Orang Tua')
    @php($portalPageTitle = 'Pengumuman Sekolah')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    <div class="dashboard-stack">
        @forelse($announcements as $announcement)
            <div class="surface-card card-tone-{{ $loop->index % 2 === 0 ? 'teal-light' : 'gold' }} mb-3">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="fw-semibold mb-1">{{ $announcement->title }}</div>
                        @if($announcement->publish_date)
                            <div class="small text-muted">{{ $announcement->publish_date->format('d M Y') }}</div>
                        @endif
                        <div class="mt-2">{!! nl2br(e($announcement->content)) !!}</div>
                        @if($announcement->target)
                            <div class="small text-muted mt-2"><i class="bi bi-people me-1"></i>Target: {{ $announcement->target }}</div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="surface-card card-tone-sand text-center py-5">
                <i class="bi bi-megaphone fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">Belum ada pengumuman dari sekolah.</p>
            </div>
        @endforelse
    </div>
</div>
@include('parent._portal_scripts')
@endsection
