@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Modul Siswa</div>
    <h1 class="h3 mb-4">Edit Siswa</h1>
    <form action="{{ route('students.update', $student) }}" method="POST">
        @method('PUT')
        @php($submitLabel = 'Perbarui Siswa')
        @include('students.form')
    </form>
</div>
@endsection
