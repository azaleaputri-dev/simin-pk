<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;

class InvoiceService
{
    public function refreshTotals(Invoice $invoice): Invoice
    {
        $invoice->loadMissing('items', 'payments');

        $total = (float) $invoice->items->sum('amount');
        $approved = (float) $invoice->payments->where('status', Payment::STATUS_APPROVED)->sum('amount');
        $remaining = max($total - $approved, 0);

        $status = match (true) {
            $invoice->isCancelled() => Invoice::STATUS_CANCELLED,
            $remaining <= 0 && $total > 0 => Invoice::STATUS_PAID,
            $approved > 0 => Invoice::STATUS_PARTIAL,
            default => Invoice::STATUS_UNPAID,
        };

        $invoice->update([
            'total_amount' => $total,
            'approved_payment_total' => $approved,
            'remaining_amount' => $remaining,
            'status' => $status,
        ]);

        return $invoice->fresh(['student', 'guardian', 'items', 'payments']);
    }
}
