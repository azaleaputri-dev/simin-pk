@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Modul Orang Tua</div>
    <h1 class="h3 mb-4">Tambah Data Orang Tua</h1>
    <form action="{{ route('parents.store') }}" method="POST">
        @php($submitLabel = 'Simpan Orang Tua')
        @include('parents.form', ['parent' => null])
    </form>
</div>
@endsection
