<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceAccessService
{
    public function ensureEditable(Invoice $invoice, bool $forApi = false): ?array
    {
        if ($invoice->isPaid()) {
            return $this->message('Invoice PAID tidak dapat diubah.', $forApi, 400);
        }

        if ($invoice->hasPaymentsRecorded()) {
            return $this->message('Invoice yang memiliki pembayaran tidak dapat diubah.', $forApi, 400);
        }

        return null;
    }

    public function ensureDeletable(Invoice $invoice, bool $forApi = false): ?array
    {
        if ($invoice->hasPaymentsRecorded()) {
            return $this->message('Invoice yang memiliki pembayaran tidak dapat dihapus.', $forApi, 400);
        }

        return null;
    }

    protected function message(string $message, bool $forApi, int $status): array
    {
        return [
            'message' => $message,
            'status' => $status,
            'for_api' => $forApi,
        ];
    }
}
