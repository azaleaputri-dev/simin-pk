<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\PPDB;
use App\Models\User;

class PpdbRegistrationService
{
    public function __construct(protected PpdbApprovalService $approvalService)
    {
    }

    public function createPublic(array $data, ?User $user = null, string $status = PPDB::STATUS_DRAFT): PPDB
    {
        $data['user_id'] = $user?->id;
        $data['status_pendaftaran'] = $status;
        $data['tanggal_daftar'] = $data['tanggal_daftar'] ?? now()->toDateString();

        return PPDB::create($data);
    }

    public function createAdmin(array $data): PPDB
    {
        $ppdb = PPDB::create($data);

        $this->applyAcceptanceFlow($ppdb);

        return $ppdb;
    }

    public function updateAdmin(PPDB $ppdb, array $data): PPDB
    {
        $ppdb->update($data);
        $ppdb->refresh();

        $this->applyAcceptanceFlow($ppdb);

        return $ppdb;
    }

    protected function applyAcceptanceFlow(PPDB $ppdb): void
    {
        if ($ppdb->status_pendaftaran !== PPDB::STATUS_ACCEPTED) {
            return;
        }

        $activeYear = AcademicYear::getActive();

        if ($activeYear && $activeYear->isQuotaExceeded()) {
            $ppdb->update(['status_pendaftaran' => PPDB::STATUS_WAITLIST]);

            return;
        }

        $this->approvalService->approve($ppdb);
    }
}
