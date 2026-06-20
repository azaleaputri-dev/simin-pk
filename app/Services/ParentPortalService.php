<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Guardian;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PPDB;
use App\Models\ProfilSekolah;
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
            'tasks' => $this->buildTasks($guardian, $students, $latestPpdb, $invoices, $payments),
            'announcements' => Announcement::active()->orderByDesc('publish_date')->limit(5)->get(),
            'notifications' => Notification::where('user_id', $user->id)->orderByDesc('created_at')->limit(10)->get(),
            'unreadNotifications' => Notification::where('user_id', $user->id)->where('is_read', false)->count(),
            'schoolProfile' => ProfilSekolah::first(),
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

    protected function buildTasks(Guardian $guardian, $students, $latestPpdb, $invoices, $payments): array
    {
        $tasks = [];

        if (! $latestPpdb || $latestPpdb->status_pendaftaran === 'draft') {
            $tasks[] = [
                'key' => 'isi_ppdb',
                'label' => 'Isi PPDB',
                'description' => $latestPpdb ? 'Lanjutkan data PPDB yang sudah diisi' : 'Belum ada pendaftaran PPDB',
                'url' => route('ppdb.register'),
                'urgency' => 'high',
                'icon' => 'bi-journal-check',
            ];
        }

        if ($latestPpdb && $latestPpdb->canManagePortalDocuments()) {
            $summary = $latestPpdb->portalDocumentSummary();
            if (! $summary['is_complete']) {
                $tasks[] = [
                    'key' => 'lengkapi_berkas',
                    'label' => 'Lengkapi Berkas PPDB',
                    'description' => $summary['remaining'] . ' dokumen masih kurang',
                    'url' => route('parent.portal') . '#berkas-ppdb',
                    'urgency' => 'high',
                    'icon' => 'bi-file-earmark-plus',
                ];
            }
        }

        $pendingPayments = $payments->where('status', Payment::STATUS_PENDING);
        if ($pendingPayments->isNotEmpty()) {
            $tasks[] = [
                'key' => 'verifikasi_pembayaran',
                'label' => 'Menunggu Verifikasi Pembayaran',
                'description' => $pendingPayments->count() . ' pembayaran sedang diproses admin',
                'url' => route('parent.portal.payments'),
                'urgency' => 'medium',
                'icon' => 'bi-clock-history',
            ];
        }

        $unpaidInvoices = $invoices->whereIn('status', Invoice::OPEN_STATUSES);
        if ($unpaidInvoices->isNotEmpty() && $pendingPayments->isEmpty()) {
            $overdueCount = $unpaidInvoices->filter(fn ($i) => $i->due_date && $i->due_date->isPast())->count();
            $tasks[] = [
                'key' => 'bayar_tagihan',
                'label' => $overdueCount ? 'Tagihan Jatuh Tempo' : 'Bayar Tagihan',
                'description' => $unpaidInvoices->count() . ' tagihan aktif, ' . $overdueCount . ' sudah jatuh tempo',
                'url' => route('parent.portal.invoices'),
                'urgency' => $overdueCount ? 'high' : 'medium',
                'icon' => 'bi-cash-stack',
            ];
        }

        return $tasks;
    }
}
