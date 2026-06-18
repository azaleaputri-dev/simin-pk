<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

class PaymentQueryService
{
    public function listForHistory(): Collection
    {
        return Payment::with('invoice.student')->latest()->get();
    }

    public function loadForShow(Payment $payment): Payment
    {
        return $payment->load('invoice.student');
    }

    public function findById(int|string $id): ?Payment
    {
        return Payment::find($id);
    }

    public function findByIdOrFail(int|string $id): Payment
    {
        return Payment::findOrFail($id);
    }
}
