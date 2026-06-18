<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('academicYear')->latest()->get();

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view('kelas.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:100',
            'jenjang' => 'required|in:PAUD A,PAUD B,TK A,TK B',
            'quota' => 'required|integer|min:0',
            'status' => 'sometimes|boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        Kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view('kelas.edit', [
            'kelas' => $kela,
            'academicYears' => $academicYears,
        ]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:100',
            'jenjang' => 'required|in:PAUD A,PAUD B,TK A,TK B',
            'quota' => 'required|integer|min:0',
            'status' => 'sometimes|boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $kela->update($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
