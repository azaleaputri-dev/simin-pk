<?php

namespace App\Services;

use App\Models\PPDB;
use App\Models\User;

class PpdbPortalService
{
    public function draftFor(?User $user): PPDB
    {
        $guardian = $user?->guardian;

        return new PPDB([
            'nama_orang_tua' => $guardian?->name ?? $user?->name,
            'email_orang_tua' => $guardian?->email ?? $user?->email,
            'no_hp_orang_tua' => $guardian?->phone,
            'alamat' => $guardian?->address,
        ]);
    }

    public function submitRedirectRoute(?User $user): string
    {
        return $user?->isGuardianUser() ? 'parent.portal' : 'ppdb.register';
    }

    public function authorizeAccess(?User $user, PPDB $ppdb): void
    {
        abort_unless(
            $user && ($ppdb->user_id === $user->id || $ppdb->email_orang_tua === $user->email),
            403
        );
    }

    public function cannotManageDocumentMessage(PPDB $ppdb, string $action = 'upload'): ?string
    {
        if ($ppdb->canManagePortalDocuments()) {
            return null;
        }

        return $action === 'delete'
            ? 'Berkas tidak bisa dihapus karena status PPDB sudah final.'
            : 'Upload berkas dikunci karena status PPDB sudah final.';
    }
}
