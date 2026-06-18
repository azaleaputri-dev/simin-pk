<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Requests\PPDB\ApiDocumentUploadRequest;
use App\Http\Requests\PPDB\PublicPpdbRequest;
use App\Http\Requests\PPDB\PortalDocumentUploadRequest;
use App\Http\Requests\PPDB\StoreAdminPpdbRequest;
use App\Http\Requests\PPDB\UpdateAdminPpdbRequest;
use App\Models\PPDB;
use App\Services\PpdbDocumentService;
use App\Services\PpdbRegistrationService;
use App\Services\PpdbValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PPDBController extends Controller
{
    use RespondsWithJson;

    public function __construct(
        protected PpdbRegistrationService $registrationService,
        protected PpdbValidationService $validationService,
        protected PpdbDocumentService $documentService
    ) {
    }

    public function register()
    {
        $user = Auth::user();
        $guardian = $user?->guardian;
        $draftPpdb = new PPDB([
            'nama_orang_tua' => $guardian?->name ?? $user?->name,
            'email_orang_tua' => $guardian?->email ?? $user?->email,
            'no_hp_orang_tua' => $guardian?->phone,
            'alamat' => $guardian?->address,
        ]);

        return view('ppdb.register', compact('draftPpdb'));
    }

    public function submit(PublicPpdbRequest $request)
    {
        $this->createPublicPpdb($request);

        $redirectRoute = $request->user()?->isGuardianUser() ? 'parent.portal' : 'ppdb.register';

        return redirect()->route($redirectRoute)
            ->with('success', 'Pendaftaran PPDB berhasil dikirim. Tim admin akan meninjau data Anda.');
    }

    public function uploadPortalDocument(PortalDocumentUploadRequest $request, PPDB $ppdb): RedirectResponse
    {
        $this->authorizePortalPpdbAccess($request, $ppdb);

        if (! $ppdb->canManagePortalDocuments()) {
            return redirect()->route('parent.portal')
                ->with('error', 'Upload berkas dikunci karena status PPDB sudah final.');
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
        $this->authorizePortalPpdbAccess($request, $ppdb);

        if (! in_array($documentType, PpdbDocumentService::DOCUMENT_TYPES, true)) {
            abort(404);
        }

        if (! $ppdb->canManagePortalDocuments()) {
            return redirect()->route('parent.portal')
                ->with('error', 'Berkas tidak bisa dihapus karena status PPDB sudah final.');
        }

        if (! $this->documentService->deletePortalDocument($ppdb, $documentType)) {
            return redirect()->route('parent.portal')
                ->with('error', 'Berkas yang dipilih tidak ditemukan.');
        }

        return redirect()->route('parent.portal')
            ->with('success', 'Berkas ' . strtoupper($documentType) . ' berhasil dihapus.');
    }

    public function index()
    {
        $ppdbs = PPDB::with('student')->latest()->get();

        return view('ppdb.index', compact('ppdbs'));
    }

    public function create()
    {
        return view('ppdb.create');
    }

    public function store(StoreAdminPpdbRequest $request)
    {
        $this->registrationService->createAdmin(
            $this->validationService->normalize($request->validated())
        );

        return redirect()->route('ppdb.index')
            ->with('success', 'Pendaftaran PPDB berhasil ditambahkan.');
    }

    public function show(PPDB $ppdb)
    {
        $ppdb->load('student');

        return view('ppdb.show', compact('ppdb'));
    }

    public function edit(PPDB $ppdb)
    {
        return view('ppdb.edit', compact('ppdb'));
    }

    public function update(UpdateAdminPpdbRequest $request, PPDB $ppdb)
    {
        $this->registrationService->updateAdmin(
            $ppdb,
            $this->validationService->normalize($request->validated())
        );

        return redirect()->route('ppdb.index')
            ->with('success', 'Pendaftaran PPDB berhasil diperbarui.');
    }

    public function destroy(PPDB $ppdb)
    {
        $ppdb->delete();

        return redirect()->route('ppdb.index')
            ->with('success', 'Pendaftaran PPDB berhasil dihapus.');
    }

    public function apiRegister(PublicPpdbRequest $request): JsonResponse
    {
        $ppdb = $this->createPublicPpdb($request);

        return $this->successJson('Pendaftaran PPDB berhasil dikirim', $ppdb);
    }

    public function apiSubmit(PublicPpdbRequest $request): JsonResponse
    {
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

    protected function authorizePortalPpdbAccess(Request $request, PPDB $ppdb): void
    {
        $user = $request->user();

        abort_unless(
            $user && ($ppdb->user_id === $user->id || $ppdb->email_orang_tua === $user->email),
            403
        );
    }

    protected function createPublicPpdb(PublicPpdbRequest $request): PPDB
    {
        return $this->registrationService->createPublic(
            $request->validated(),
            $request->user()
        );
    }

}
