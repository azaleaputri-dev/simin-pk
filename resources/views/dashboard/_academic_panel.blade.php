@php
    $academicMetrics = [
        ['label' => 'PPDB Pending', 'value' => $stats['ppdbPending'], 'max' => max($stats['ppdb'], 1), 'tone' => 'warning'],
        ['label' => 'PPDB Diterima', 'value' => $stats['ppdbApproved'], 'max' => max($stats['ppdb'], 1), 'tone' => 'success'],
        ['label' => 'PPDB Ditolak', 'value' => $stats['ppdbRejected'], 'max' => max($stats['ppdb'], 1), 'tone' => 'danger'],
        ['label' => 'Siswa Aktif', 'value' => $stats['siswa'], 'max' => max($stats['orangTua'] + $stats['siswa'], 1), 'tone' => 'info'],
    ];
@endphp

<div class="surface-card reveal-on-load card-tone-teal-light">
    <div class="section-label mb-2">Panel Akademik</div>
    <h3 class="h5 mb-1">Ringkasan performa PPDB dan siswa</h3>
    <p class="text-muted mb-0">Visual singkat ini bantu admin membaca beban kerja akademik hari ini.</p>

    <div class="mt-4">
        @foreach($academicMetrics as $metric)
            @php($percentage = (int) round(($metric['value'] / $metric['max']) * 100))
            <div class="metric-row">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="fw-semibold">{{ $metric['label'] }}</div>
                        <div class="small text-muted">{{ number_format($metric['value'], 0, ',', '.') }} item</div>
                    </div>
                    <span class="badge text-bg-light">{{ $percentage }}%</span>
                </div>
                <div class="mini-progress">
                    <div class="mini-progress-bar tone-{{ $metric['tone'] }}" data-progress-width="{{ $percentage }}"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
