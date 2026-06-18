@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Keuangan</div>
    <h1 class="h3 mb-4">Edit Tarif</h1>
    <form action="{{ route('tariffs.update', $tariff) }}" method="POST">
        @method('PUT')
        @php($submitLabel = 'Perbarui Tarif')
        @include('tariffs.form')
    </form>
</div>
@endsection
