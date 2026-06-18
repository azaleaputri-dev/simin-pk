<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\FeeType;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::with(['feeType', 'academicYear'])->latest()->get();

        return view('tariffs.index', compact('tariffs'));
    }

    public function create()
    {
        return view('tariffs.create', [
            'feeTypes' => FeeType::where('is_active', true)->orderBy('name')->get(),
            'academicYears' => AcademicYear::orderByDesc('start_date')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'fee_type_id' => 'required|exists:fee_types,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'amount' => 'required|numeric|min:0.01',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        Tariff::create($validated);

        return redirect()->route('tariffs.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tariff $tariff)
    {
        return view('tariffs.edit', [
            'tariff' => $tariff,
            'feeTypes' => FeeType::orderBy('name')->get(),
            'academicYears' => AcademicYear::orderByDesc('start_date')->get(),
        ]);
    }

    public function update(Request $request, Tariff $tariff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'fee_type_id' => 'required|exists:fee_types,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'amount' => 'required|numeric|min:0.01',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $tariff->update($validated);

        return redirect()->route('tariffs.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tariff $tariff)
    {
        $tariff->delete();

        return redirect()->route('tariffs.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
