<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Kelas;
use App\Models\PPDB;
use App\Models\ProfilSekolah;
use App\Models\Student;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $schoolProfile = ProfilSekolah::latest('id')->first();
        $activeAcademicYear = AcademicYear::getActive();

        $stats = [
            'students' => Student::count(),
            'classes' => Kelas::count(),
            'ppdb' => PPDB::count(),
            'teachers' => (int) ($schoolProfile?->jumlah_guru ?? 0),
        ];

        $facilities = collect($schoolProfile?->fasilitas ?? [])
            ->filter()
            ->take(6)
            ->values();

        return view('landing', compact('schoolProfile', 'activeAcademicYear', 'stats', 'facilities'));
    }
}
