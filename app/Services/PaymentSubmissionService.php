<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Validation\ValidationException;

class PaymentSubmissionService
{
    public function __construct(protected NumberGeneratorService $numberGenerator)
    {
    }

    public function submit(array $data): Payment
    {
        $invoice = Invoice::findOrFail($data['invoice_id']);

        if ($invoice->isCancelled()) {
            throw ValidationException::withMessages([
                'invoice_id' => 'Invoice CANCELLED tidak dapat dibayar.',
            ]);
        }

        if ($data['amount'] > $invoice->remaining_amount) {
            throw ValidationException::withMessages([
                'amount' => 'Pembayaran tidak boleh melebihi sisa tagihan.',
            ]);
        }

        if (
            $data['payment_method'] === Payment::METHOD_TRANSFER_BANK
            && empty($data['proof_reference'])
            && empty($data['proof_file'])
        ) {
            throw ValidationException::withMessages([
                'proof_file' => 'Bukti transfer wajib diupload untuk metode transfer.',
            ]);
        }

        return Payment::create([
            'payment_number' => $this->numberGenerator->nextPaymentNumber(),
            'invoice_id' => $invoice->id,
            'payment_date' => $data['payment_date'],
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'sender_name' => $data['sender_name'] ?? null,
            'proof_reference' => $data['proof_reference'] ?? null,
            'status' => Payment::STATUS_PENDING,
            'notes' => $data['notes'] ?? null,
        ]);
    }
}
