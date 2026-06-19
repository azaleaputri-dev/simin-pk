<div class="dashboard-stat-grid mb-4">
    <div class="row g-3">
        <div class="col-md-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Profil Sekolah', 'value' => $stats['profilSekolah'], 'countValue' => $stats['profilSekolah'], 'icon' => 'bi-building', 'tone' => 'teal'])</div>
        <div class="col-md-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Tahun Ajaran', 'value' => $stats['tahunAjaran'], 'countValue' => $stats['tahunAjaran'], 'icon' => 'bi-calendar-range', 'tone' => 'gold'])</div>
        <div class="col-md-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Kelas', 'value' => $stats['kelas'], 'countValue' => $stats['kelas'], 'icon' => 'bi-diagram-3-fill', 'tone' => 'sand'])</div>
        <div class="col-md-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Orang Tua', 'value' => $stats['orangTua'], 'countValue' => $stats['orangTua'], 'icon' => 'bi-people-fill', 'tone' => 'coral'])</div>
        <div class="col-md-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Siswa Aktif', 'value' => $stats['siswa'], 'countValue' => $stats['siswa'], 'icon' => 'bi-mortarboard-fill', 'tone' => 'teal'])</div>
        <div class="col-md-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'Total PPDB', 'value' => $stats['ppdb'], 'countValue' => $stats['ppdb'], 'icon' => 'bi-journal-check', 'tone' => 'gold'])</div>
        <div class="col-md-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'PPDB Pending', 'value' => $stats['ppdbPending'], 'countValue' => $stats['ppdbPending'], 'icon' => 'bi-hourglass-split', 'tone' => 'sand'])</div>
        <div class="col-md-6 col-xl-3">@include('components.dashboard._stat_card', ['label' => 'PPDB Diterima', 'value' => $stats['ppdbApproved'], 'countValue' => $stats['ppdbApproved'], 'icon' => 'bi-patch-check-fill', 'tone' => 'coral'])</div>
    </div>
</div>
