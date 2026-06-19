@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

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
