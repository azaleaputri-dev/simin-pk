<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:parents,phone'],
            'address_detail' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kabupaten' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kelurahan' => ['nullable', 'string', 'max:100'],
            'kode_pos' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $detailAddress = trim((string) $this->input('address_detail', ''));
        $parts = array_filter([
            $detailAddress ? 'Jalan/Detail: ' . $detailAddress : null,
            $this->filled('kelurahan') ? 'Kelurahan: ' . $this->input('kelurahan') : null,
            $this->filled('kecamatan') ? 'Kecamatan: ' . $this->input('kecamatan') : null,
            $this->filled('kabupaten') ? 'Kabupaten/Kota: ' . $this->input('kabupaten') : null,
            $this->filled('provinsi') ? 'Provinsi: ' . $this->input('provinsi') : null,
            $this->filled('kode_pos') ? 'Kode Pos: ' . $this->input('kode_pos') : null,
        ]);

        $this->merge([
            'address' => ! empty($parts) ? implode(', ', $parts) : null,
        ]);
    }
}
