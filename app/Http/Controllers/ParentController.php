<?php

namespace App\Http\Controllers;

use App\Http\Requests\Parent\StoreParentRequest;
use App\Http\Requests\Parent\UpdateParentRequest;
use App\Models\Guardian;
use App\Services\ParentDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ParentController extends Controller
{
    public function __construct(protected ParentDataService $parentDataService)
    {
    }

    public function index(): View
    {
        $parents = Guardian::withCount('students')->latest()->get();

        return view('parents.index', compact('parents'));
    }

    public function create(): View
    {
        return view('parents.create');
    }

    public function store(StoreParentRequest $request): RedirectResponse
    {
        Guardian::create($this->parentDataService->normalize($request->validated()));

        return redirect()->route('parents.index')->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    public function edit(Guardian $parent): View
    {
        return view('parents.edit', compact('parent'));
    }

    public function update(UpdateParentRequest $request, Guardian $parent): RedirectResponse
    {
        $parent->update($this->parentDataService->normalize($request->validated()));

        return redirect()->route('parents.index')->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function destroy(Guardian $parent): RedirectResponse
    {
        $parent->delete();

        return redirect()->route('parents.index')->with('success', 'Data orang tua berhasil dihapus.');
    }
}
