<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use App\Services\StudentFormOptionsService;
use App\Services\StudentQueryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    use RespondsWithJson;

    public function __construct(
        protected StudentFormOptionsService $formOptionsService,
        protected StudentQueryService $studentQueryService
    ) {
    }

    public function index(): View
    {
        $students = $this->studentQueryService->listForIndex();

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        return view('students.create', $this->formOptionsService->formData());
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        Student::create($request->validated());

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        return view('students.edit', $this->formOptionsService->formData([
            'student' => $student,
        ]));
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $student->update($request->validated());

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    // API Methods
    public function apiIndex(Request $request): JsonResponse
    {
        $students = $this->studentQueryService->listForIndex();

        return $this->successJson('Data siswa berhasil diambil', $students);
    }

    public function apiShow(Request $request, $id): JsonResponse
    {
        $student = $this->studentQueryService->findForShow($id);

        if (! $student) {
            return $this->errorJson('Siswa tidak ditemukan', 404);
        }

        return $this->successJson('Data siswa berhasil diambil', $student);
    }
}
