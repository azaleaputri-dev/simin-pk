@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Keuangan</div>
    <h1 class="h3 mb-4">Edit Invoice</h1>
    <form action="{{ route('invoices.update', $invoice) }}" method="POST">
        @method('PUT')
        @php($submitLabel = 'Perbarui Invoice')
        @include('invoices.form')
    </form>
</div>
@endsection
