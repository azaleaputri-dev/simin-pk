@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    @if(! empty($tasks))
        <div class="surface-card card-tone-gold mb-4">
            <div class="section-label mb-2">Tugas Saya</div>
            <div class="dashboard-stack">
                @foreach($tasks as $task)
                    <a href="{{ $task['url'] }}" class="list-surface-item text-decoration-none d-flex align-items-center gap-3 mb-0 mb-2">
                        <span class="stat-card-icon" style="background: {{ $task['urgency'] === 'high' ? 'rgba(220, 53, 69, 0.12); color: #dc3545' : 'rgba(226, 166, 75, 0.15); color: #b8860b' }}"><i class="bi {{ $task['icon'] }}"></i></span>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $task['label'] }}</div>
                            <div class="small text-muted">{{ $task['description'] }}</div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @if($notifications->isNotEmpty())
        <div class="surface-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <div class="section-label mb-1">Notifikasi</div>
                    @if($unreadNotifications > 0)
                        <span class="badge text-bg-danger">{{ $unreadNotifications }} belum dibaca</span>
                    @endif
                </div>
            </div>
            <div class="dashboard-stack">
                @foreach($notifications as $notification)
                    <div class="list-surface-item mb-0 mb-2 {{ ! $notification->is_read ? 'border-start border-primary border-3' : '' }}">
                        <div class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">{{ $notification->title }}</div>
                                <div class="small text-muted">{{ $notification->body }}</div>
                            </div>
                            <div class="small text-muted text-nowrap">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @php($documentSummary = $latestPpdb?->portalDocumentSummary())
    @php($uploadedDocuments = $latestPpdb?->berkas ?? [])

    <div class="row g-4">
        @include('parent._portal_journey')
        @include('parent._portal_account')
        @if($latestPpdb)
            @include('parent._portal_documents')
        @endif
        @include('parent._portal_histories')
    </div>
</div>
@include('parent._portal_preview_modal')
@include('parent._portal_scripts')
@endsection
