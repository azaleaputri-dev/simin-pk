@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Keuangan</div>
    <h1 class="h3 mb-4">Input Pembayaran</h1>
    <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
        @include('payments.form')
    </form>
</div>
@endsection
