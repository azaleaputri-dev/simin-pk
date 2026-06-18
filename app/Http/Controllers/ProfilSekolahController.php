<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilSekolah\StoreProfilSekolahRequest;
use App\Http\Requests\ProfilSekolah\UpdateProfilSekolahRequest;
use App\Models\ProfilSekolah;
use App\Services\ProfilSekolahDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfilSekolahController extends Controller
{
    public function __construct(protected ProfilSekolahDataService $profilSekolahDataService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $profilSekolahs = ProfilSekolah::all();

        return view('profil_sekolahs.index', compact('profilSekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('profil_sekolahs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfilSekolahRequest $request): RedirectResponse
    {
        ProfilSekolah::create($this->profilSekolahDataService->normalize($request->validated()));

        return redirect()->route('profil-sekolahs.index')
            ->with('success', 'Profil sekolah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilSekolah $profilSekolah): View
    {
        return view('profil_sekolahs.show', compact('profilSekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfilSekolah $profilSekolah): View
    {
        return view('profil_sekolahs.edit', compact('profilSekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfilSekolahRequest $request, ProfilSekolah $profilSekolah): RedirectResponse
    {
        $profilSekolah->update($this->profilSekolahDataService->normalize($request->validated()));

        return redirect()->route('profil-sekolahs.index')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilSekolah $profilSekolah): RedirectResponse
    {
        $profilSekolah->delete();

        return redirect()->route('profil-sekolahs.index')
            ->with('success', 'Profil sekolah berhasil dihapus.');
    }
}
