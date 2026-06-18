<?php

namespace App\Services;

use App\Models\PPDB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PpdbValidationService
{
    public function validate(Request $request, ?PPDB $ppdb = null, bool $isAdmin = true): array
    {
        $validated = $request->validate($isAdmin
            ? $this->adminRules($request, $ppdb)
            : $this->publicRules($request, $ppdb));

        return $this->normalize($validated, $isAdmin);
    }

    public function publicRules(Request $request, ?PPDB $ppdb = null): array
    {
        return $this->baseRules($request, $ppdb);
    }

    public function adminRules(Request $request, ?PPDB $ppdb = null): array
    {
        $rules = $this->baseRules($request, $ppdb);
        $rules['status_pendaftaran'] = 'required|in:' . implode(',', PPDB::STATUSES);
        $rules['tanggal_daftar'] = 'nullable|date';
        $rules['tanggal_tes'] = 'nullable|date';
        $rules['tanggal_pengumuman'] = 'nullable|date';
        $rules['berkas'] = 'nullable|json';
        $rules['user_id'] = 'nullable|exists:users,id';

        return $rules;
    }

    public function normalize(array $validated, bool $isAdmin = true): array
    {
        if ($isAdmin && isset($validated['berkas']) && is_string($validated['berkas'])) {
            $validated['berkas'] = json_decode($validated['berkas'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $validated['berkas'] = null;
            }
        }

        return $validated;
    }

    protected function baseRules(Request $request, ?PPDB $ppdb): array
    {
        $currentUser = $request->user();
        $currentGuardian = $currentUser?->guardian;

        return [
            'nama_lengkap' => 'required|string|max:100',
            'nik' => ['required', 'string', 'max:16', Rule::unique('p_p_d_b_s', 'nik')->ignore($ppdb?->id)],
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:50',
            'agama' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'dusun' => 'nullable|string|max:50',
            'kelurahan' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'kabupaten' => 'required|string|max:50',
            'provinsi' => 'required|string|max:50',
            'kode_pos' => 'required|string|max:10',
            'no_telp' => 'required|string|max:15',
            'email' => 'nullable|email|max:100',
            'nama_orang_tua' => 'required|string|max:100',
            'email_orang_tua' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($ppdb?->user_id ?? $currentUser?->id)],
            'no_hp_orang_tua' => ['required', 'string', 'max:20', Rule::unique('parents', 'phone')->ignore($ppdb?->user?->guardian?->id ?? $currentGuardian?->id)],
            'asal_sekolah' => 'required|string|max:100',
            'nisn_asal' => 'nullable|string|max:16',
            'jalur_pendaftaran' => 'required|string|max:20',
            'pilihan_jurusan' => 'nullable|string|max:50',
            'catatan' => 'nullable|string',
        ];
    }
}
