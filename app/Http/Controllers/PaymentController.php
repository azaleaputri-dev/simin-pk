<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Requests\Payment\ApiUploadProofRequest;
use App\Http\Requests\Payment\RejectPaymentRequest;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Models\Payment;
use App\Services\FinanceFormOptionsService;
use App\Services\NumberGeneratorService;
use App\Services\PaymentApprovalService;
use App\Services\PaymentControllerService;
use App\Services\PaymentSubmissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    use RespondsWithJson;

    public function __construct(
        protected NumberGeneratorService $numberGenerator,
        protected PaymentApprovalService $paymentApprovalService,
        protected PaymentSubmissionService $paymentSubmissionService,
        protected FinanceFormOptionsService $formOptionsService,
        protected PaymentControllerService $paymentControllerService
    ) {
    }

    public function index()
    {
        $payments = Payment::with('invoice.student')->latest()->get();

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return view('payments.create', $this->formOptionsService->paymentCreateData(
            $this->numberGenerator->nextPaymentNumber()
        ));
    }

    public function store(StorePaymentRequest $request)
    {
        try {
            $this->paymentSubmissionService->submit($request->validated());
        } catch (ValidationException $exception) {
            return back()->with('error', $this->paymentControllerService->firstValidationMessage($exception))->withInput();
        }

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dibuat.');
    }

    public function show(Payment $payment)
    {
        $payment->load('invoice.student');

        return view('payments.show', compact('payment'));
    }

    public function approve(Request $request, Payment $payment)
    {
        if ($guard = $this->paymentControllerService->ensurePending($payment, 'Hanya pembayaran PENDING yang bisa disetujui.')) {
            return back()->with('error', $guard['message']);
        }

        $this->paymentApprovalService->approve($payment, $request->input('notes'));

        return redirect()->route('payments.show', $payment)->with('success', 'Pembayaran berhasil disetujui.');
    }

    public function reject(RejectPaymentRequest $request, Payment $payment)
    {
        $validated = $request->validated();

        if ($guard = $this->paymentControllerService->ensurePending($payment, 'Hanya pembayaran PENDING yang bisa ditolak.')) {
            return back()->with('error', $guard['message']);
        }

        $this->paymentApprovalService->reject($payment, $validated['notes']);

        return redirect()->route('payments.show', $payment)->with('success', 'Pembayaran berhasil ditolak.');
    }

    public function apiStore(StorePaymentRequest $request): JsonResponse
    {
        try {
            $payment = $this->paymentSubmissionService->submit($request->validated());
        } catch (ValidationException $exception) {
            return $this->errorJson($this->paymentControllerService->firstValidationMessage($exception), 400);
        }

        return $this->successJson('Pembayaran berhasil dibuat', $payment);
    }

    public function apiUploadProof(ApiUploadProofRequest $request): JsonResponse
    {
        $payment = Payment::findOrFail($request->input('payment_id'));

        if ($guard = $this->paymentControllerService->ensurePending($payment, 'Hanya pembayaran PENDING yang bisa diupload bukti.', true)) {
            return $this->errorJson($guard['message'], $guard['status']);
        }

        return $this->successJson('Bukti pembayaran berhasil diupload', $this->paymentControllerService->storeProof(
            $payment,
            $request->file('file')
        ));
    }

    public function apiHistory(Request $request): JsonResponse
    {
        $payments = Payment::with('invoice.student')->latest()->get();

        return $this->successJson('Riwayat pembayaran berhasil diambil', $payments);
    }

    public function apiApprove(Request $request, $id): JsonResponse
    {
        $payment = Payment::find($id);

        if (! $payment) {
            return $this->errorJson('Pembayaran tidak ditemukan', 404);
        }

        if ($guard = $this->paymentControllerService->ensurePending($payment, 'Hanya pembayaran PENDING yang bisa disetujui.', true)) {
            return $this->errorJson($guard['message'], $guard['status']);
        }

        $payment = $this->paymentApprovalService->approve($payment, $request->input('notes'));

        return $this->successJson('Pembayaran berhasil disetujui', $payment);
    }

    public function apiReject(RejectPaymentRequest $request, $id): JsonResponse
    {
        $payment = Payment::find($id);

        if (! $payment) {
            return $this->errorJson('Pembayaran tidak ditemukan', 404);
        }

        if ($guard = $this->paymentControllerService->ensurePending($payment, 'Hanya pembayaran PENDING yang bisa ditolak.', true)) {
            return $this->errorJson($guard['message'], $guard['status']);
        }

        $validated = $request->validated();

        $payment = $this->paymentApprovalService->reject($payment, $validated['notes']);

        return $this->successJson('Pembayaran berhasil ditolak', $payment);
    }
}
