<?php

namespace App\Http\Requests\ProfilSekolah;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfilSekolahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return app(\App\Services\ProfilSekolahDataService::class)->rules($this);
    }
}
