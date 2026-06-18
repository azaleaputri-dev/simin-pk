<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;

class InvoiceQueryService
{
    public function listForIndex(): Collection
    {
        return Invoice::with(['student', 'guardian', 'academicYear'])->latest()->get();
    }

    public function loadForShow(Invoice $invoice): Invoice
    {
        return $invoice->load(['student', 'guardian', 'academicYear', 'items.feeType', 'payments']);
    }

    public function loadForEdit(Invoice $invoice): Invoice
    {
        return $invoice->load('items');
    }

    public function findForShow(int|string $id): ?Invoice
    {
        return Invoice::with(['student', 'guardian', 'academicYear', 'items.feeType', 'payments'])->find($id);
    }

    public function findById(int|string $id): ?Invoice
    {
        return Invoice::find($id);
    }
}
