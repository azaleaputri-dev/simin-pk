<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Services\FinanceFormOptionsService;
use App\Services\InvoiceManagementService;
use App\Services\InvoiceAccessService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use RespondsWithJson;

    public function __construct(
        protected NumberGeneratorService $numberGenerator,
        protected InvoiceManagementService $invoiceManagementService,
        protected FinanceFormOptionsService $formOptionsService,
        protected InvoiceAccessService $invoiceAccessService
    ) {
    }

    public function index()
    {
        $invoices = Invoice::with(['student', 'guardian', 'academicYear'])->latest()->get();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create', $this->formOptionsService->invoiceFormData([
            'invoiceNumber' => $this->numberGenerator->nextInvoiceNumber(),
        ]));
    }

    public function store(StoreInvoiceRequest $request)
    {
        $this->invoiceManagementService->createSingleItemInvoice(
            $request->validated()
        );

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dibuat.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['student', 'guardian', 'academicYear', 'items.feeType', 'payments']);

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->isPaid()) {
            return redirect()->route('invoices.index')->with('error', 'Invoice PAID tidak dapat diubah.');
        }

        $invoice->load('items');

        return view('invoices.edit', $this->formOptionsService->invoiceFormData([
            'invoice' => $invoice,
            'item' => $invoice->items->first(),
        ]));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        if ($guard = $this->invoiceAccessService->ensureEditable($invoice)) {
            return redirect()->route('invoices.index')->with('error', $guard['message']);
        }

        $this->invoiceManagementService->updateSingleItemInvoice(
            $invoice,
            $request->validated()
        );

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice berhasil diperbarui.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($guard = $this->invoiceAccessService->ensureDeletable($invoice)) {
            return redirect()->route('invoices.index')->with('error', $guard['message']);
        }

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $invoices = Invoice::with(['student', 'guardian', 'academicYear'])->latest()->get();

        return $this->successJson('Data invoice berhasil diambil', $invoices);
    }

    public function apiShow(Request $request, $id): JsonResponse
    {
        $invoice = Invoice::with(['student', 'guardian', 'academicYear', 'items.feeType', 'payments'])->find($id);

        if (! $invoice) {
            return $this->errorJson('Invoice tidak ditemukan', 404);
        }

        return $this->successJson('Data invoice berhasil diambil', $invoice);
    }

    public function apiStore(StoreInvoiceRequest $request): JsonResponse
    {
        $invoice = $this->invoiceManagementService->createSingleItemInvoice(
            $request->validated()
        );

        return $this->successJson('Invoice berhasil dibuat', $invoice);
    }

    public function apiUpdate(UpdateInvoiceRequest $request, $id): JsonResponse
    {
        $invoice = Invoice::find($id);

        if (! $invoice) {
            return $this->errorJson('Invoice tidak ditemukan', 404);
        }

        if ($guard = $this->invoiceAccessService->ensureEditable($invoice, true)) {
            return $this->errorJson($guard['message'], $guard['status']);
        }

        $invoice = $this->invoiceManagementService->updateSingleItemInvoice(
            $invoice,
            $request->validated()
        );

        return $this->successJson('Invoice berhasil diperbarui', $invoice);
    }

    public function apiDestroy($id): JsonResponse
    {
        $invoice = Invoice::find($id);

        if (! $invoice) {
            return $this->errorJson('Invoice tidak ditemukan', 404);
        }

        if ($guard = $this->invoiceAccessService->ensureDeletable($invoice, true)) {
            return $this->errorJson($guard['message'], $guard['status']);
        }

        $invoice->delete();

        return $this->successJson('Invoice berhasil dihapus');
    }
}
