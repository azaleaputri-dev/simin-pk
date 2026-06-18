<?php

namespace App\Http\Requests\AcademicYear;

use App\Models\AcademicYear;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var AcademicYear|null $academicYear */
        $academicYear = $this->route('academic_year');

        return app(\App\Services\AcademicYearDataService::class)->rules($this, $academicYear);
    }
}
