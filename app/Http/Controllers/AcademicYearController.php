<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicYear\StoreAcademicYearRequest;
use App\Http\Requests\AcademicYear\UpdateAcademicYearRequest;
use App\Models\AcademicYear;
use App\Services\AcademicYearDataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    public function __construct(protected AcademicYearDataService $academicYearDataService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $academicYears = AcademicYear::all();

        return view('academic_years.index', compact('academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('academic_years.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicYearRequest $request): RedirectResponse
    {
        AcademicYear::create(
            $this->academicYearDataService->normalize($request->validated(), $request)
        );

        return redirect()->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicYear $academicYear): View
    {
        return view('academic_years.show', compact('academicYear'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear): View
    {
        return view('academic_years.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicYearRequest $request, AcademicYear $academicYear): RedirectResponse
    {
        $academicYear->update(
            $this->academicYearDataService->normalize($request->validated(), $request)
        );

        return redirect()->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        if ($academicYear->is_active) {
            return redirect()->route('academic-years.index')
                ->with('error', 'Tahun ajaran aktif tidak dapat dihapus.');
        }

        $academicYear->delete();

        return redirect()->route('academic-years.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
