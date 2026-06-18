<?php

namespace App\Http\Requests\ProfilSekolah;

use App\Models\ProfilSekolah;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilSekolahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var ProfilSekolah|null $profilSekolah */
        $profilSekolah = $this->route('profil_sekolah');

        return app(\App\Services\ProfilSekolahDataService::class)->rules($this, $profilSekolah);
    }
}
