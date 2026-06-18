@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Keuangan</div>
    <h1 class="h3 mb-4">Tambah Tarif</h1>
    <form action="{{ route('tariffs.store') }}" method="POST">
        @php($submitLabel = 'Simpan Tarif')
        @include('tariffs.form', ['tariff' => null])
    </form>
</div>
@endsection
