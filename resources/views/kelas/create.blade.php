@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Modul Kelas</div>
    <h1 class="h3 mb-4">Tambah Kelas</h1>
    <form action="{{ route('kelas.store') }}" method="POST">
        @php($submitLabel = 'Simpan Kelas')
        @include('kelas.form', ['kelas' => null])
    </form>
</div>
@endsection
