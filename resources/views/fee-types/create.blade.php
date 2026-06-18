@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Keuangan</div>
    <h1 class="h3 mb-4">Tambah Jenis Biaya</h1>
    <form action="{{ route('fee-types.store') }}" method="POST">
        @php($submitLabel = 'Simpan Jenis Biaya')
        @include('fee-types.form', ['feeType' => null])
    </form>
</div>
@endsection
