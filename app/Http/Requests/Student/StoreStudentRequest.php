<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|exists:parents,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'nis' => ['required', 'string', 'max:30', Rule::unique('students', 'nis')],
            'nik' => ['nullable', 'string', 'max:16', Rule::unique('students', 'nik')],
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'status_siswa' => 'required|in:ACTIVE,INACTIVE,TRANSFERRED,GRADUATED',
        ];
    }
}
