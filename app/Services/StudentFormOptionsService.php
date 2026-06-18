<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Guardian;
use App\Models\Kelas;

class StudentFormOptionsService
{
    public function formData(array $extra = []): array
    {
        return array_merge([
            'parents' => Guardian::orderBy('name')->get(),
            'kelas' => Kelas::orderBy('name')->get(),
            'academicYears' => AcademicYear::orderByDesc('start_date')->get(),
        ], $extra);
    }
}
