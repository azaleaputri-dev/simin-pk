@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Master Sekolah</div>
    <h1 class="h3 mb-4">Tambah Profil Sekolah</h1>

    @if($errors->any())
        <div class="alert alert-danger">{{ implode(' ', $errors->all()) }}</div>
    @endif

    <form action="{{ route('profil-sekolahs.store') }}" method="POST">
        @php($submitLabel = 'Simpan Profil')
        @include('profil_sekolahs.form', ['profilSekolah' => null])
    </form>
</div>
@endsection
