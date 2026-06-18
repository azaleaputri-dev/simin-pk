<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Student;

class NumberGeneratorService
{
    public function nextInvoiceNumber(?int $year = null): string
    {
        $year ??= (int) now()->format('Y');
        $count = Invoice::whereYear('created_at', $year)->count() + 1;

        return sprintf('INV-%s-%06d', $year, $count);
    }

    public function nextPaymentNumber(?int $year = null): string
    {
        $year ??= (int) now()->format('Y');
        $count = Payment::whereYear('created_at', $year)->count() + 1;

        return sprintf('PAY-%s-%06d', $year, $count);
    }

    public function nextStudentNumber(?int $year = null): string
    {
        $year ??= (int) now()->format('Y');
        $count = Student::whereYear('created_at', $year)->count() + 1;

        return sprintf('S-%s-%04d', $year, $count);
    }
}
