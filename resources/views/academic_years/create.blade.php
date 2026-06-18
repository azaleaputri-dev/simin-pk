@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Master Sekolah</div>
    <h1 class="h3 mb-4">Tambah Tahun Ajaran</h1>

    @if($errors->any())
        <div class="alert alert-danger">{{ implode(' ', $errors->all()) }}</div>
    @endif

    <form action="{{ route('academic-years.store') }}" method="POST">
        @php($submitLabel = 'Simpan Tahun Ajaran')
        @include('academic_years.form', ['academicYear' => null])
    </form>
</div>
@endsection
