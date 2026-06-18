<?php

namespace App\Services;

use App\Models\Guardian;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PPDB;
use App\Models\User;

class ParentPortalService
{
    public function buildFor(?User $user): ?array
    {
        if (! $user) {
            return null;
        }

        $guardian = $this->guardianForUser($user);

        if (! $guardian) {
            return null;
        }

        $students = $guardian->students ?? collect();
        $invoices = $students->flatMap->invoices->sortByDesc('invoice_date')->values();
        $payments = $invoices->flatMap->payments->sortByDesc('payment_date')->values();
        $ppdbs = $this->ppdbsFor($user, $guardian);
        $latestPpdb = $ppdbs->first();

        return [
            'guardian' => $guardian,
            'students' => $students,
            'invoices' => $invoices,
            'payments' => $payments,
            'ppdbs' => $ppdbs,
            'stats' => [
                'children' => $students->count(),
                'activeInvoices' => $invoices->whereIn('status', Invoice::OPEN_STATUSES)->count(),
                'outstanding' => $invoices->sum('remaining_amount'),
                'approvedPayments' => $payments->where('status', Payment::STATUS_APPROVED)->sum('amount'),
                'ppdb' => $ppdbs->count(),
            ],
            'latestPpdb' => $latestPpdb,
            'portalJourney' => $latestPpdb?->portalProgress() ?? PPDB::emptyPortalJourney(),
        ];
    }

    public function guardianForUser(User $user): ?Guardian
    {
        return Guardian::with([
            'students.kelas',
            'students.academicYear',
            'students.invoices.payments',
        ])->where('user_id', $user->id)->first();
    }

    public function requireGuardianForUser(User $user): Guardian
    {
        return Guardian::where('user_id', $user->id)->firstOrFail();
    }

    protected function ppdbsFor(User $user, Guardian $guardian)
    {
        return PPDB::with('student')
            ->where(function ($query) use ($user, $guardian) {
                $query->where('user_id', $user->id)
                    ->orWhere('email_orang_tua', $user->email);

                if ($guardian->email) {
                    $query->orWhere('email_orang_tua', $guardian->email);
                }
            })
            ->latest()
            ->get();
    }
}
