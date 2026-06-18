@extends('layouts.app')

@section('content')
<div class="page-card p-4">
    <div class="section-label mb-2">Keuangan</div>
    <h1 class="h3 mb-4">Buat Invoice</h1>
    <form action="{{ route('invoices.store') }}" method="POST">
        @php($submitLabel = 'Simpan Invoice')
        @include('invoices.form', ['invoice' => new \App\Models\Invoice(), 'item' => new \App\Models\InvoiceItem()])
    </form>
</div>
@endsection
