@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Keuangan</div>
    <h1 class="h3 mb-4">Edit Jenis Biaya</h1>
    <form action="{{ route('fee-types.update', $feeType) }}" method="POST">
        @method('PUT')
        @php($submitLabel = 'Perbarui Jenis Biaya')
        @include('fee-types.form')
    </form>
</div>
@endsection
