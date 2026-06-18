<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Notification;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentApprovalService
{
    public function approve(Payment $payment, ?string $notes = null): Payment
    {
        return DB::transaction(function () use ($payment, $notes) {
            $payment->update([
                'status' => Payment::STATUS_APPROVED,
                'notes' => $notes ?: $payment->notes,
                'verified_at' => now(),
            ]);

            $payment->refresh();
            app(InvoiceService::class)->refreshTotals($payment->invoice);

            Notification::create([
                'title' => 'Pembayaran Disetujui',
                'message' => 'Pembayaran ' . $payment->payment_number . ' telah disetujui.',
                'target_type' => 'payment',
                'target_id' => $payment->id,
            ]);

            AuditLog::create([
                'action' => 'PAYMENT_APPROVED',
                'entity_type' => 'payment',
                'entity_id' => $payment->id,
                'description' => 'Pembayaran ' . $payment->payment_number . ' disetujui.',
            ]);

            return $payment->fresh('invoice');
        });
    }

    public function reject(Payment $payment, string $notes): Payment
    {
        return DB::transaction(function () use ($payment, $notes) {
            $payment->update([
                'status' => Payment::STATUS_REJECTED,
                'notes' => $notes,
                'verified_at' => now(),
            ]);

            Notification::create([
                'title' => 'Pembayaran Ditolak',
                'message' => 'Pembayaran ' . $payment->payment_number . ' ditolak. Alasan: ' . $notes,
                'target_type' => 'payment',
                'target_id' => $payment->id,
            ]);

            AuditLog::create([
                'action' => 'PAYMENT_REJECTED',
                'entity_type' => 'payment',
                'entity_id' => $payment->id,
                'description' => 'Pembayaran ' . $payment->payment_number . ' ditolak.',
            ]);

            return $payment->fresh('invoice');
        });
    }
}
