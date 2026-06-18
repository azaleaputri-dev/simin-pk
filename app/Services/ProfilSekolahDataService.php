<?php

namespace App\Services;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfilSekolahDataService
{
    public function validate(Request $request, ?ProfilSekolah $profilSekolah = null): array
    {
        $validated = $request->validate($this->rules($request, $profilSekolah));

        return $this->normalize($validated);
    }

    public function rules(Request $request, ?ProfilSekolah $profilSekolah = null): array
    {
        return [
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => ['nullable', 'string', 'max:20', Rule::unique('profil_sekolahs', 'npsn')->ignore($profilSekolah?->id)],
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',
            'status' => 'required|in:negeri,swasta',
            'akreditasi' => 'nullable|string|max:5',
            'tahun_berdiri' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'kepala_sekolah' => 'nullable|string|max:100',
            'nip_kepala' => 'nullable|string|max:20',
            'jumlah_guru' => 'nullable|integer|min:0',
            'jumlah_siswa' => 'nullable|integer|min:0',
            'fasilitas' => 'nullable|json',
            'deskripsi' => 'nullable|string',
        ];
    }

    public function normalize(array $validated): array
    {
        if (isset($validated['fasilitas']) && is_string($validated['fasilitas'])) {
            $validated['fasilitas'] = json_decode($validated['fasilitas'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $validated['fasilitas'] = null;
            }
        }

        return $validated;
    }
}
