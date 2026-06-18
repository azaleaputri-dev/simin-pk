<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Services\ProfilSekolahDataService;
use Illuminate\Http\Request;

class ProfilSekolahController extends Controller
{
    public function __construct(protected ProfilSekolahDataService $profilSekolahDataService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profilSekolahs = ProfilSekolah::all();
        return view('profil_sekolahs.index', compact('profilSekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profil_sekolahs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ProfilSekolah::create($this->profilSekolahDataService->validate($request));

        return redirect()->route('profil-sekolahs.index')
            ->with('success', 'Profil sekolah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilSekolah $profilSekolah)
    {
        return view('profil_sekolahs.show', compact('profilSekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfilSekolah $profilSekolah)
    {
        return view('profil_sekolahs.edit', compact('profilSekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfilSekolah $profilSekolah)
    {
        $profilSekolah->update($this->profilSekolahDataService->validate($request, $profilSekolah));

        return redirect()->route('profil-sekolahs.index')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilSekolah $profilSekolah)
    {
        $profilSekolah->delete();

        return redirect()->route('profil-sekolahs.index')
            ->with('success', 'Profil sekolah berhasil dihapus.');
    }
}
