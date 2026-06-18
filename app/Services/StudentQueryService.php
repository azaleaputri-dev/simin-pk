<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class StudentQueryService
{
    public function listForIndex(): Collection
    {
        return Student::with(['guardian', 'kelas', 'academicYear'])->latest()->get();
    }

    public function findForShow(int|string $id): ?Student
    {
        return Student::with(['guardian', 'kelas', 'academicYear'])->find($id);
    }
}
