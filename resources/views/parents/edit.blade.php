@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Modul Orang Tua</div>
    <h1 class="h3 mb-4">Edit Data Orang Tua</h1>
    <form action="{{ route('parents.update', $parent->id) }}" method="POST">
        @method('PUT')
        @php($submitLabel = 'Perbarui Orang Tua')
        @include('parents.form')
    </form>
</div>
@endsection
