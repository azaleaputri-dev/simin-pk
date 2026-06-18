@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @include('parent._portal_header')

    @php($documentSummary = $latestPpdb?->portalDocumentSummary())
    @php($uploadedDocuments = $latestPpdb?->berkas ?? [])

    <div class="row g-4">
        @include('parent._portal_journey')
        @include('parent._portal_account')
        @include('parent._portal_documents')
        @include('parent._portal_profile_forms')
        @include('parent._portal_histories')
    </div>
</div>
@include('parent._portal_preview_modal')
@include('parent._portal_scripts')
@endsection
