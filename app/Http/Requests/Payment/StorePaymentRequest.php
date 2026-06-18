<?php

namespace App\Http\Requests\Payment;

use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => 'required|exists:invoices,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:' . implode(',', Payment::METHODS),
            'sender_name' => 'nullable|string|max:100',
            'proof_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}
