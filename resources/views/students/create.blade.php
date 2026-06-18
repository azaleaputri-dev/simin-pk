@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Modul Siswa</div>
    <h1 class="h3 mb-4">Tambah Siswa</h1>
    <form action="{{ route('students.store') }}" method="POST">
        @php($submitLabel = 'Simpan Siswa')
        @include('students.form', ['student' => null])
    </form>
</div>
@endsection
