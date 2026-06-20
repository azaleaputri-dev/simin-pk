<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\FeeType;
use App\Models\Guardian;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use App\Services\InvoiceManagementService;
use App\Services\PaymentSubmissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FinanceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_single_item_invoice_can_be_created_with_totals()
    {
        [$student, $feeType] = $this->financeFixture();

        $invoice = app(InvoiceManagementService::class)->createSingleItemInvoice([
            'student_id' => $student->id,
            'academic_year_id' => null,
            'invoice_date' => '2026-06-18',
            'due_date' => '2026-06-30',
            'fee_type_id' => $feeType->id,
            'tariff_id' => null,
            'description' => 'SPP Juni',
            'amount' => 250000,
            'notes' => null,
        ]);

        $this->assertSame(Invoice::STATUS_UNPAID, $invoice->status);
        $this->assertSame('250000.00', $invoice->total_amount);
        $this->assertSame('250000.00', $invoice->remaining_amount);
        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $invoice->id,
            'description' => 'SPP Juni',
        ]);
    }

    public function test_transfer_payment_requires_proof_reference()
    {
        [$student, $feeType] = $this->financeFixture();

        $invoice = app(InvoiceManagementService::class)->createSingleItemInvoice([
            'student_id' => $student->id,
            'academic_year_id' => null,
            'invoice_date' => '2026-06-18',
            'due_date' => '2026-06-30',
            'fee_type_id' => $feeType->id,
            'tariff_id' => null,
            'description' => 'SPP Juni',
            'amount' => 250000,
            'notes' => null,
        ]);

        $this->expectException(ValidationException::class);

        app(PaymentSubmissionService::class)->submit([
            'invoice_id' => $invoice->id,
            'payment_date' => '2026-06-18',
            'amount' => 100000,
            'payment_method' => Payment::METHOD_TRANSFER_BANK,
            'sender_name' => 'Orang Tua Demo',
            'proof_reference' => null,
            'notes' => null,
        ]);
    }

    public function test_payment_receipt_can_be_downloaded_as_pdf()
    {
        [$student, $feeType] = $this->financeFixture();

        $invoice = app(InvoiceManagementService::class)->createSingleItemInvoice([
            'student_id' => $student->id,
            'academic_year_id' => $student->academic_year_id,
            'invoice_date' => '2026-06-18',
            'due_date' => '2026-06-30',
            'fee_type_id' => $feeType->id,
            'tariff_id' => null,
            'description' => 'SPP Juni',
            'amount' => 250000,
            'notes' => null,
        ]);

        $payment = app(PaymentSubmissionService::class)->submit([
            'invoice_id' => $invoice->id,
            'payment_date' => '2026-06-18',
            'amount' => 250000,
            'payment_method' => Payment::METHOD_CASH,
            'sender_name' => 'Orang Tua Demo',
            'proof_reference' => null,
            'notes' => 'Pembayaran tunai',
        ]);

        $admin = User::factory()->create();
        $response = $this->actingAs($admin)->get(route('payments.receipt', $payment));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_payment_receipt_can_be_opened_for_printing()
    {
        [$student, $feeType] = $this->financeFixture();

        $invoice = app(InvoiceManagementService::class)->createSingleItemInvoice([
            'student_id' => $student->id,
            'academic_year_id' => $student->academic_year_id,
            'invoice_date' => '2026-06-18',
            'due_date' => '2026-06-30',
            'fee_type_id' => $feeType->id,
            'tariff_id' => null,
            'description' => 'SPP Juni',
            'amount' => 250000,
            'notes' => null,
        ]);

        $payment = app(PaymentSubmissionService::class)->submit([
            'invoice_id' => $invoice->id,
            'payment_date' => '2026-06-18',
            'amount' => 250000,
            'payment_method' => Payment::METHOD_CASH,
            'sender_name' => 'Orang Tua Demo',
            'proof_reference' => null,
            'notes' => null,
        ]);

        $admin = User::factory()->create();
        $response = $this->actingAs($admin)->get(route('payments.receipt.print', $payment));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('inline', $response->headers->get('content-disposition'));
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    private function financeFixture(): array
    {
        $user = User::factory()->create();

        $guardian = Guardian::create([
            'user_id' => $user->id,
            'name' => 'Orang Tua Demo',
            'email' => $user->email,
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 1',
            'father_name' => 'Ayah Demo',
            'mother_name' => 'Ibu Demo',
        ]);

        $academicYear = AcademicYear::create([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);

        $student = Student::create([
            'parent_id' => $guardian->id,
            'academic_year_id' => $academicYear->id,
            'nis' => 'S-2026-0001',
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Siswa Demo',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2018-01-01',
            'agama' => 'Islam',
            'alamat' => 'Jl. Mawar No. 1',
        ]);

        $feeType = FeeType::create([
            'name' => 'SPP',
            'code' => 'SPP',
            'is_active' => true,
        ]);

        return [$student, $feeType];
    }
}
