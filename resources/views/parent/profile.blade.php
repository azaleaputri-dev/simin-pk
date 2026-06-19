@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('parent._portal_styles')
    @php($portalPageEyebrow = 'Portal Orang Tua / Profil')
    @php($portalPageTitle = 'Kelola Profil Akun')
    @include('parent._portal_header')
    @include('parent._portal_quick_nav')

    <div class="row justify-content-center">
        <div class="col-xl-8">
            @include('parent._portal_profile_form')
        </div>
    </div>
</div>
@endsection
