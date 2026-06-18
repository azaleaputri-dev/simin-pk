<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\FeeType;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\Tariff;

class FinanceFormOptionsService
{
    public function invoiceFormData(array $extra = []): array
    {
        return array_merge([
            'students' => Student::with('guardian', 'academicYear')->orderBy('nama_lengkap')->get(),
            'academicYears' => AcademicYear::orderByDesc('start_date')->get(),
            'feeTypes' => FeeType::where('is_active', true)->orderBy('name')->get(),
            'tariffs' => Tariff::with('feeType')->where('is_active', true)->orderBy('name')->get(),
        ], $extra);
    }

    public function paymentCreateData(string $paymentNumber): array
    {
        return [
            'invoices' => Invoice::with('student')
                ->whereIn('status', Invoice::OPEN_STATUSES)
                ->orderByDesc('invoice_date')
                ->get(),
            'paymentNumber' => $paymentNumber,
        ];
    }
}
