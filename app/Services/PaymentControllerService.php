<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentControllerService
{
    public function ensurePending(Payment $payment, string $message, bool $forApi = false): ?array
    {
        if ($payment->isPending()) {
            return null;
        }

        return [
            'message' => $message,
            'status' => 400,
            'for_api' => $forApi,
        ];
    }

    public function firstValidationMessage(ValidationException $exception): string
    {
        $messages = $exception->validator->errors()->all();

        return $messages[0] ?? 'Data pembayaran tidak valid.';
    }

    public function ensureExists(?Payment $payment): ?array
    {
        if ($payment) {
            return null;
        }

        return [
            'message' => 'Pembayaran tidak ditemukan',
            'status' => 404,
        ];
    }

    public function storeProof(Payment $payment, UploadedFile $file): array
    {
        $filename = 'payment_proof_' . $payment->id . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $disk = Storage::disk('private');
        $disk->makeDirectory('payment_proofs');
        $path = $file->storeAs('payment_proofs', $filename, 'private');

        $payment->update([
            'proof_reference' => $path,
        ]);

        return [
            'path' => $path,
            'filename' => $filename,
            'url' => null,
        ];
    }
}
