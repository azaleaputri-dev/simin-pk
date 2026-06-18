<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class InvoiceManagementService
{
    public function __construct(
        protected NumberGeneratorService $numberGenerator,
        protected InvoiceService $invoiceService
    ) {
    }

    public function createSingleItemInvoice(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {
            $student = Student::findOrFail($data['student_id']);

            $invoice = Invoice::create([
                'invoice_number' => $this->numberGenerator->nextInvoiceNumber(),
                'student_id' => $student->id,
                'parent_id' => $student->parent_id,
                'academic_year_id' => $data['academic_year_id'] ?: $student->academic_year_id,
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'fee_type_id' => $data['fee_type_id'],
                'tariff_id' => $data['tariff_id'] ?? null,
                'description' => $data['description'],
                'amount' => $data['amount'],
            ]);

            return $this->invoiceService->refreshTotals($invoice);
        });
    }

    public function updateSingleItemInvoice(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            $student = Student::findOrFail($data['student_id']);

            $invoice->update([
                'student_id' => $student->id,
                'parent_id' => $student->parent_id,
                'academic_year_id' => $data['academic_year_id'] ?: $student->academic_year_id,
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'notes' => $data['notes'] ?? null,
                'status' => $data['status'],
            ]);

            $item = $invoice->items()->first();

            if ($item) {
                $item->update([
                    'fee_type_id' => $data['fee_type_id'],
                    'tariff_id' => $data['tariff_id'] ?? null,
                    'description' => $data['description'],
                    'amount' => $data['amount'],
                ]);
            }

            return $this->invoiceService->refreshTotals($invoice);
        });
    }
}
