@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @php($portalPageEyebrow = 'Portal Orang Tua / PPDB')
    @php($portalPageTitle = 'Riwayat Pendaftaran PPDB')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    @include('parent._portal_ppdb_history')
</div>
@endsection
