<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Services\FinanceFormOptionsService;
use App\Services\InvoiceManagementService;
use App\Services\InvoiceAccessService;
use App\Services\InvoiceQueryService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    use RespondsWithJson;

    public function __construct(
        protected NumberGeneratorService $numberGenerator,
        protected InvoiceManagementService $invoiceManagementService,
        protected FinanceFormOptionsService $formOptionsService,
        protected InvoiceAccessService $invoiceAccessService,
        protected InvoiceQueryService $invoiceQueryService
    ) {
    }

    public function index(): View
    {
        $invoices = $this->invoiceQueryService->listForIndex();

        return view('invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        return view('invoices.create', $this->formOptionsService->invoiceFormData([
            'invoiceNumber' => $this->numberGenerator->nextInvoiceNumber(),
        ]));
    }

    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        $this->invoiceManagementService->createSingleItemInvoice(
            $request->validated()
        );

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dibuat.');
    }

    public function show(Invoice $invoice): View
    {
        $invoice = $this->invoiceQueryService->loadForShow($invoice);

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice): View|RedirectResponse
    {
        if ($invoice->isPaid()) {
            return redirect()->route('invoices.index')->with('error', 'Invoice PAID tidak dapat diubah.');
        }

        $invoice = $this->invoiceQueryService->loadForEdit($invoice);

        return view('invoices.edit', $this->formOptionsService->invoiceFormData([
            'invoice' => $invoice,
            'item' => $invoice->items->first(),
        ]));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): RedirectResponse
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

    public function destroy(Invoice $invoice): RedirectResponse
    {
        if ($guard = $this->invoiceAccessService->ensureDeletable($invoice)) {
            return redirect()->route('invoices.index')->with('error', $guard['message']);
        }

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $invoices = $this->invoiceQueryService->listForIndex();

        return $this->successJson('Data invoice berhasil diambil', $invoices);
    }

    public function apiShow(Request $request, $id): JsonResponse
    {
        $invoice = $this->invoiceQueryService->findForShow($id);

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
        $invoice = $this->invoiceQueryService->findById($id);

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
        $invoice = $this->invoiceQueryService->findById($id);

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
