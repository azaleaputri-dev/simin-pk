<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Requests\PPDB\ApiDocumentUploadRequest;
use App\Http\Requests\PPDB\PublicPpdbRequest;
use App\Http\Requests\PPDB\PortalDocumentUploadRequest;
use App\Http\Requests\PPDB\StoreAdminPpdbRequest;
use App\Http\Requests\PPDB\UpdateAdminPpdbRequest;
use App\Models\AcademicYear;
use App\Models\PPDB;
use App\Services\PpdbDocumentService;
use App\Services\PpdbPortalService;
use App\Services\PpdbRegistrationService;
use App\Services\PpdbValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PPDBController extends Controller
{
    use RespondsWithJson;

    public function __construct(
        protected PpdbRegistrationService $registrationService,
        protected PpdbValidationService $validationService,
        protected PpdbDocumentService $documentService,
        protected PpdbPortalService $portalService
    ) {
    }

    public function register(): View|RedirectResponse
    {
        if ($redirect = $this->checkPpdbClosed()) {
            return $redirect;
        }

        $draftPpdb = $this->portalService->draftFor(request()->user());

        return view('ppdb.register', compact('draftPpdb'));
    }

    public function submit(PublicPpdbRequest $request): RedirectResponse
    {
        if ($redirect = $this->checkPpdbClosed()) {
            return $redirect;
        }

        $this->createPublicPpdb($request);

        return redirect()->route($this->portalService->submitRedirectRoute($request->user()))
            ->with('success', 'Pendaftaran PPDB berhasil dikirim. Tim admin akan meninjau data Anda.');
    }

    public function uploadPortalDocument(PortalDocumentUploadRequest $request, PPDB $ppdb): RedirectResponse
    {
        $this->portalService->authorizeAccess($request->user(), $ppdb);

        if ($message = $this->portalService->cannotManageDocumentMessage($ppdb)) {
            return redirect()->route('parent.portal')
                ->with('error', $message);
        }

        $validated = $request->validated();

        $this->documentService->storePortalDocument(
            $ppdb,
            $validated['document_type'],
            $request->file('file')
        );

        return redirect()->route('parent.portal')
            ->with('success', 'Berkas ' . strtoupper($validated['document_type']) . ' berhasil diupload.');
    }

    public function destroyPortalDocument(Request $request, PPDB $ppdb, string $documentType): RedirectResponse
    {
        $this->portalService->authorizeAccess($request->user(), $ppdb);

        if (! in_array($documentType, PpdbDocumentService::DOCUMENT_TYPES, true)) {
            abort(404);
        }

        if ($message = $this->portalService->cannotManageDocumentMessage($ppdb, 'delete')) {
            return redirect()->route('parent.portal')
                ->with('error', $message);
        }

        if (! $this->documentService->deletePortalDocument($ppdb, $documentType)) {
            return redirect()->route('parent.portal')
                ->with('error', 'Berkas yang dipilih tidak ditemukan.');
        }

        return redirect()->route('parent.portal')
            ->with('success', 'Berkas ' . strtoupper($documentType) . ' berhasil dihapus.');
    }

    public function index(): View
    {
        $ppdbs = PPDB::with('student')->latest()->get();

        return view('ppdb.index', compact('ppdbs'));
    }

    public function create(): View
    {
        return view('ppdb.create');
    }

    public function store(StoreAdminPpdbRequest $request): RedirectResponse
    {
        $this->registrationService->createAdmin(
            $this->validationService->normalize($request->validated())
        );

        return redirect()->route('ppdb.index')
            ->with('success', 'Pendaftaran PPDB berhasil ditambahkan.');
    }

    public function show(PPDB $ppdb): View
    {
        $ppdb->load('student');

        return view('ppdb.show', compact('ppdb'));
    }

    public function edit(PPDB $ppdb): View
    {
        return view('ppdb.edit', compact('ppdb'));
    }

    public function update(UpdateAdminPpdbRequest $request, PPDB $ppdb): RedirectResponse
    {
        $this->registrationService->updateAdmin(
            $ppdb,
            $this->validationService->normalize($request->validated())
        );

        return redirect()->route('ppdb.index')
            ->with('success', 'Pendaftaran PPDB berhasil diperbarui.');
    }

    public function destroy(PPDB $ppdb): RedirectResponse
    {
        $ppdb->delete();

        return redirect()->route('ppdb.index')
            ->with('success', 'Pendaftaran PPDB berhasil dihapus.');
    }

    public function apiRegister(PublicPpdbRequest $request): JsonResponse
    {
        if ($this->checkPpdbClosed()) {
            return $this->errorJson('Maaf, pendaftaran PPDB sedang ditutup.', 403);
        }

        $ppdb = $this->createPublicPpdb($request);

        return $this->successJson('Pendaftaran PPDB berhasil dikirim', $ppdb);
    }

    public function apiSubmit(PublicPpdbRequest $request): JsonResponse
    {
        if ($this->checkPpdbClosed()) {
            return $this->errorJson('Maaf, pendaftaran PPDB sedang ditutup.', 403);
        }

        $ppdb = $this->createPublicPpdb($request);

        return $this->successJson('Pendaftaran PPDB berhasil disubmit', $ppdb);
    }

    public function apiStatus(Request $request): JsonResponse
    {
        $ppdb = PPDB::latest()->first();

        if (! $ppdb) {
            return $this->successJson('Belum ada pendaftaran PPDB');
        }

        return $this->successJson('Status PPDB berhasil diambil', $ppdb);
    }

    public function apiUploadDocument(ApiDocumentUploadRequest $request): JsonResponse
    {
        return $this->successJson(
            'Dokumen berhasil diupload',
            $this->documentService->storeApiDocument($request->file('file'))
        );
    }

    protected function checkPpdbClosed(): ?RedirectResponse
    {
        $activeYear = AcademicYear::getActive();

        if (!$activeYear || !$activeYear->isPpdbOpen()) {
            return redirect()->route('home')
                ->with('error', 'Maaf, pendaftaran PPDB sedang ditutup. Silakan hubungi admin sekolah untuk informasi lebih lanjut.');
        }

        if (!$activeYear->isPpdbWithinPeriod()) {
            return redirect()->route('home')
                ->with('error', 'Maaf, pendaftaran PPDB sudah diluar periode yang ditentukan.');
        }

        return null;
    }

    protected function createPublicPpdb(PublicPpdbRequest $request): PPDB
    {
        return $this->registrationService->createPublic(
            $request->validated(),
            $request->user()
        );
    }
}
