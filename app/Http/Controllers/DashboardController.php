<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Models\AcademicYear;
use App\Models\Announcement;
use App\Models\Invoice;
use App\Models\Guardian;
use App\Models\Kelas;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PPDB;
use App\Models\ProfilSekolah;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    use RespondsWithJson;

    public function index()
    {
        $activeAcademicYear = AcademicYear::getActive();

        $stats = [
            'profilSekolah' => ProfilSekolah::count(),
            'tahunAjaran' => AcademicYear::count(),
            'kelas' => Kelas::count(),
            'orangTua' => Guardian::count(),
            'siswa' => Student::count(),
            'ppdb' => PPDB::count(),
            'ppdbPending' => PPDB::whereIn('status_pendaftaran', array_merge([PPDB::STATUS_DRAFT], PPDB::REVIEW_STATUSES))->count(),
            'ppdbApproved' => PPDB::where('status_pendaftaran', PPDB::STATUS_ACCEPTED)->count(),
            'ppdbRejected' => PPDB::whereIn('status_pendaftaran', [PPDB::STATUS_REJECTED, PPDB::STATUS_CANCELLED])->count(),
            'invoiceActive' => Invoice::whereIn('status', Invoice::OPEN_STATUSES)->count(),
            'paymentPending' => Payment::where('status', Payment::STATUS_PENDING)->count(),
            'revenueApproved' => Payment::where('status', Payment::STATUS_APPROVED)->sum('amount'),
            'outstanding' => Invoice::sum('remaining_amount'),
        ];

        $recentApplicants = PPDB::latest()->take(5)->get();

        return view('dashboard.index', compact('activeAcademicYear', 'stats', 'recentApplicants'));
    }

    public function togglePpdb(Request $request): RedirectResponse
    {
        $activeYear = AcademicYear::getActive();

        if (!$activeYear) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Tidak ada tahun ajaran aktif. Atur tahun ajaran terlebih dahulu.');
        }

        $activeYear->update(['ppdb_is_open' => !$activeYear->ppdb_is_open]);

        $status = $activeYear->ppdb_is_open ? 'dibuka' : 'ditutup';

        return redirect()->route('admin.dashboard')
            ->with('success', "PPDB berhasil {$status} untuk tahun ajaran {$activeYear->name}.");
    }

    public function updatePpdbPeriod(Request $request): RedirectResponse
    {
        $activeYear = AcademicYear::getActive();

        if (!$activeYear) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $validated = $request->validate([
            'ppdb_start_date' => 'nullable|date',
            'ppdb_end_date' => 'nullable|date|after_or_equal:ppdb_start_date',
        ]);

        $activeYear->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Periode PPDB berhasil diperbarui.');
    }

    // API Methods for Announcements
    public function apiAnnouncements(Request $request): JsonResponse
    {
        $announcements = Announcement::where('status', 'active')
            ->orderByDesc('publish_date')
            ->get();

        return $this->successJson('Data pengumuman berhasil diambil', $announcements);
    }

    public function apiAnnouncementDetail(Request $request, $id): JsonResponse
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return $this->errorJson('Pengumuman tidak ditemukan', 404);
        }

        return $this->successJson('Data pengumuman berhasil diambil', $announcement);
    }

    // API Methods for Notifications
    public function apiNotifications(Request $request): JsonResponse
    {
        $notifications = Notification::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->get();

        return $this->successJson('Data notifikasi berhasil diambil', $notifications);
    }

    public function apiMarkNotificationAsRead(Request $request): JsonResponse
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:notifications,id',
        ]);

        Notification::whereIn('id', $request->input('notification_ids'))
            ->where('user_id', $request->user()->id)
            ->update(['is_read' => true]);

        return $this->successJson('Notifikasi berhasil ditandai sebagai sudah dibaca');
    }
}
