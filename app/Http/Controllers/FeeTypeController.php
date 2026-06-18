<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function index()
    {
        $feeTypes = FeeType::latest()->get();

        return view('fee-types.index', compact('feeTypes'));
    }

    public function create()
    {
        return view('fee-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:fee_types,name',
            'code' => 'required|string|max:30|unique:fee_types,code',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        FeeType::create($validated);

        return redirect()->route('fee-types.index')->with('success', 'Jenis biaya berhasil ditambahkan.');
    }

    public function edit(FeeType $feeType)
    {
        return view('fee-types.edit', compact('feeType'));
    }

    public function update(Request $request, FeeType $feeType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:fee_types,name,' . $feeType->id,
            'code' => 'required|string|max:30|unique:fee_types,code,' . $feeType->id,
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $feeType->update($validated);

        return redirect()->route('fee-types.index')->with('success', 'Jenis biaya berhasil diperbarui.');
    }

    public function destroy(FeeType $feeType)
    {
        if ($feeType->tariffs()->exists()) {
            return back()->with('error', 'Jenis biaya yang sudah dipakai tarif tidak dapat dihapus.');
        }

        $feeType->delete();

        return redirect()->route('fee-types.index')->with('success', 'Jenis biaya berhasil dihapus.');
    }
}
