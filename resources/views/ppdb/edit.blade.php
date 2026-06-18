@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">PPDB Online</div>
    <h1 class="h3 mb-4">Edit Pendaftaran</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ implode(' ', $errors->all()) }}
        </div>
    @endif

    <form action="{{ route('ppdb.update', $ppdb) }}" method="POST">
        @method('PUT')
        @php($submitLabel = 'Perbarui Pendaftaran')
        @include('ppdb.form')
    </form>
</div>
@endsection
