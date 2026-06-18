<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\FeeType;
use App\Models\Guardian;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PPDB;
use App\Models\Student;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PpdbApprovalService
{
    public function __construct(
        protected NumberGeneratorService $numberGenerator,
        protected InvoiceService $invoiceService
    ) {
    }

    public function approve(PPDB $ppdb): Student
    {
        return DB::transaction(function () use ($ppdb) {
            $guardianEmail = $ppdb->email_orang_tua ?: $this->generateFallbackEmail($ppdb);

            $user = User::firstOrCreate(
                ['email' => $guardianEmail],
                [
                    'name' => $ppdb->nama_orang_tua ?: $ppdb->nama_lengkap . ' Parent',
                    'password' => Hash::make('password123'),
                ]
            );

            $guardian = Guardian::updateOrCreate(
                ['email' => $guardianEmail],
                [
                    'user_id' => $user->id,
                    'name' => $ppdb->nama_orang_tua ?: $user->name,
                    'phone' => $ppdb->no_hp_orang_tua ?: $ppdb->no_telp,
                    'address' => $ppdb->alamat,
                    'father_name' => $ppdb->nama_orang_tua ?: $user->name,
                    'mother_name' => $ppdb->nama_orang_tua ?: $user->name,
                ]
            );

            $activeAcademicYear = AcademicYear::getActive();

            $student = Student::updateOrCreate(
                ['ppdb_id' => $ppdb->id],
                [
                    'parent_id' => $guardian->id,
                    'academic_year_id' => $activeAcademicYear?->id,
                    'nis' => $ppdb->student?->nis ?: $this->numberGenerator->nextStudentNumber((int) ($activeAcademicYear?->start_date?->format('Y') ?? now()->format('Y'))),
                    'nik' => $ppdb->nik,
                    'nama_lengkap' => $ppdb->nama_lengkap,
                    'jenis_kelamin' => $ppdb->jenis_kelamin,
                    'tempat_lahir' => $ppdb->tempat_lahir,
                    'tanggal_lahir' => $ppdb->tanggal_lahir,
                    'agama' => $ppdb->agama,
                    'alamat' => $ppdb->alamat,
                    'status_siswa' => 'ACTIVE',
                ]
            );

            $this->createRegistrationInvoice($student, $activeAcademicYear);

            return $student;
        });
    }

    protected function createRegistrationInvoice(Student $student, ?AcademicYear $academicYear): void
    {
        if (! $academicYear) {
            return;
        }

        $registrationFeeType = FeeType::where('code', 'REGISTRASI')->first();

        if (! $registrationFeeType) {
            return;
        }

        $tariff = Tariff::where('fee_type_id', $registrationFeeType->id)
            ->where('academic_year_id', $academicYear->id)
            ->where('is_active', true)
            ->first();

        if (! $tariff) {
            return;
        }

        $invoice = Invoice::firstOrCreate(
            [
                'student_id' => $student->id,
                'notes' => 'Invoice registrasi otomatis dari approval PPDB.',
            ],
            [
                'invoice_number' => $this->numberGenerator->nextInvoiceNumber((int) $academicYear->start_date->format('Y')),
                'parent_id' => $student->parent_id,
                'academic_year_id' => $academicYear->id,
                'invoice_date' => now()->toDateString(),
                'due_date' => now()->addDays(7)->toDateString(),
                'status' => 'UNPAID',
            ]
        );

        InvoiceItem::firstOrCreate(
            [
                'invoice_id' => $invoice->id,
                'fee_type_id' => $registrationFeeType->id,
            ],
            [
                'tariff_id' => $tariff->id,
                'description' => 'Biaya registrasi siswa baru',
                'amount' => $tariff->amount,
            ]
        );

        $this->invoiceService->refreshTotals($invoice);
    }

    protected function generateFallbackEmail(PPDB $ppdb): string
    {
        return 'ortu+' . $ppdb->id . '-' . Str::slug($ppdb->nama_lengkap) . '@siminpk.local';
    }
}
