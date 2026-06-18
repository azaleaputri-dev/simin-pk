@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Modul Kelas</div>
    <h1 class="h3 mb-4">Edit Kelas</h1>
    <form action="{{ route('kelas.update', $kelas) }}" method="POST">
        @method('PUT')
        @php($submitLabel = 'Perbarui Kelas')
        @include('kelas.form')
    </form>
</div>
@endsection
