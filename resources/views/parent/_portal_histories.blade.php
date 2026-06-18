<div class="col-12">
    <div class="border rounded-4 p-4 bg-white">
        <div class="section-label mb-2">Riwayat PPDB</div>
        <h3 class="h5">Status Pendaftaran Saya</h3>
        <div class="mt-3">
            @forelse($ppdbs as $ppdb)
                @php($progress = $ppdb->portalProgress())
                @php($statusAppearance = $ppdb->statusAppearance())
                <div class="border rounded-3 p-3 mb-3">
                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                        <div>
                            <div class="fw-semibold">{{ $ppdb->nama_lengkap }}</div>
                            <div class="small text-muted">{{ $ppdb->asal_sekolah }} | daftar {{ optional($ppdb->tanggal_daftar)->format('d M Y') ?? '-' }}</div>
                            <div class="small text-muted">{{ ucfirst($ppdb->jalur_pendaftaran) }} | {{ $ppdb->pilihan_jurusan ?: 'Jurusan belum diisi' }}</div>
                        </div>
                        <div class="text-lg-end">
                            <span class="badge {{ $statusAppearance['class'] }}">{{ $statusAppearance['label'] }}</span>
                            @if($ppdb->student)
                                <div class="small text-success mt-2">Sudah jadi siswa dengan NIS {{ $ppdb->student->nis }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="small text-muted mt-2">Tahap saat ini: {{ collect($progress['steps'])->firstWhere('key', $progress['current'])['label'] ?? '-' }}</div>
                    @if($ppdb->catatan)
                        <div class="small text-muted mt-2">Catatan admin: {{ $ppdb->catatan }}</div>
                    @endif
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada pendaftaran PPDB yang terhubung ke akun ini.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="border rounded-4 p-4 bg-white h-100">
        <div class="section-label mb-2">Data Anak</div>
        <h3 class="h5">Anak yang Terhubung</h3>
        <div class="mt-3">
            @forelse($students as $student)
                <div class="border rounded-3 p-3 mb-3">
                    <div class="fw-semibold">{{ $student->nama_lengkap }}</div>
                    <div class="small text-muted">NIS {{ $student->nis }} | {{ $student->kelas?->name ?? 'Belum ditempatkan ke kelas' }}</div>
                    <div class="small text-muted">{{ $student->academicYear?->name ?? 'Belum ada tahun ajaran' }} | {{ $student->status_siswa }}</div>
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada data anak untuk portal ini.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="border rounded-4 p-4 bg-white h-100">
        <div class="section-label mb-2">Tagihan Aktif</div>
        <h3 class="h5">Invoice Orang Tua/User</h3>
        <div class="mt-3">
            @forelse($invoices as $invoice)
                <div class="border rounded-3 p-3 mb-3">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <div class="fw-semibold">{{ $invoice->invoice_number }}</div>
                            <div class="small text-muted">{{ $invoice->student?->nama_lengkap }} | jatuh tempo {{ $invoice->due_date?->format('d M Y') }}</div>
                        </div>
                        <span class="badge text-bg-light">{{ $invoice->status }}</span>
                    </div>
                    <div class="small mt-2">Total: Rp{{ number_format($invoice->total_amount, 0, ',', '.') }}</div>
                    <div class="small text-muted">Sisa: Rp{{ number_format($invoice->remaining_amount, 0, ',', '.') }}</div>
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada invoice untuk orang tua ini.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="col-12">
    <div class="border rounded-4 p-4 bg-white">
        <div class="section-label mb-2">Riwayat Pembayaran</div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>No. Pembayaran</th>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_number }}</td>
                            <td>{{ $payment->invoice?->invoice_number }}</td>
                            <td>{{ $payment->payment_date?->format('d M Y') }}</td>
                            <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td>{{ $payment->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada riwayat pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
