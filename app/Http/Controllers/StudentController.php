<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Guardian;
use App\Models\Kelas;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['guardian', 'kelas', 'academicYear'])->latest()->get();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create', [
            'parents' => Guardian::orderBy('name')->get(),
            'kelas' => Kelas::orderBy('name')->get(),
            'academicYears' => AcademicYear::orderByDesc('start_date')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateStudent($request);
        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', [
            'student' => $student,
            'parents' => Guardian::orderBy('name')->get(),
            'kelas' => Kelas::orderBy('name')->get(),
            'academicYears' => AcademicYear::orderByDesc('start_date')->get(),
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $this->validateStudent($request, $student);
        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    protected function validateStudent(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'parent_id' => 'nullable|exists:parents,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'nis' => ['required', 'string', 'max:30', Rule::unique('students', 'nis')->ignore($student?->id)],
            'nik' => ['nullable', 'string', 'max:16', Rule::unique('students', 'nik')->ignore($student?->id)],
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'status_siswa' => 'required|in:ACTIVE,INACTIVE,TRANSFERRED,GRADUATED',
        ]);
    }

    // API Methods
    public function apiIndex(Request $request): JsonResponse
    {
        $students = Student::with(['guardian', 'kelas', 'academicYear'])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diambil',
            'data' => $students
        ]);
    }

    public function apiShow(Request $request, $id): JsonResponse
    {
        $student = Student::with(['guardian', 'kelas', 'academicYear'])->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diambil',
            'data' => $student
        ]);
    }
}