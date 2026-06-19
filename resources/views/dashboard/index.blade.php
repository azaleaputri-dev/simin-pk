@extends('layouts.app')

@section('content')
<div class="page-card p-4 p-lg-5">
    @include('components.dashboard._hero', [
        'banner' => true,
        'eyebrow' => 'Portal Admin',
        'title' => 'Dashboard Operasional Sekolah',
        'description' => 'Area admin untuk mengelola master data, PPDB, siswa, kelas, invoice, dan verifikasi pembayaran.',
        'meta' => [
            ['label' => 'Mode Akses', 'value' => 'Admin Sekolah'],
            ['label' => 'Tahun Ajaran Aktif', 'value' => $activeAcademicYear?->name ?? 'Belum ditentukan'],
        ],
    ])

    @include('dashboard._stats')
    @include('dashboard._quick_actions')
    @include('dashboard._ppdb_settings')

    <div class="dashboard-tabbar reveal-on-load mb-4" role="tablist" aria-label="Mode dashboard admin">
        <button type="button" class="dashboard-tab is-active" data-dashboard-tab="overview">Overview</button>
        <button type="button" class="dashboard-tab" data-dashboard-tab="akademik">Akademik</button>
        <button type="button" class="dashboard-tab" data-dashboard-tab="keuangan">Keuangan</button>
    </div>

    <div class="dashboard-tab-panel is-active" data-dashboard-panel="overview">
        <div class="row g-4">
            <div class="col-lg-7">
                @include('dashboard._academic_panel')
            </div>
            <div class="col-lg-5">
                @include('dashboard._finance_summary')
            </div>
        </div>
    </div>

    <div class="dashboard-tab-panel d-none" data-dashboard-panel="akademik">
        <div class="row g-4">
            <div class="col-12">
                @include('dashboard._academic_panel')
            </div>
        </div>
    </div>

    <div class="dashboard-tab-panel d-none" data-dashboard-panel="keuangan">
        <div class="row g-4">
            <div class="col-lg-6">
                @include('dashboard._finance_panel')
            </div>
            <div class="col-lg-6">
                @include('dashboard._finance_summary')
            </div>
        </div>
    </div>
</div>
@endsection
