<div class="col-lg-6">
    <div class="surface-card h-100 card-tone-gold">
        <div class="section-label mb-2">Data Anak</div>
        <h3 class="h5">Anak yang Terhubung</h3>
        <div class="dashboard-stack mt-3">
            @forelse($students as $student)
                <div class="list-surface-item">
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
    <div class="surface-card h-100 card-tone-coral-light">
        <div class="section-label mb-2">Tagihan Aktif</div>
        <h3 class="h5">Invoice Orang Tua/User</h3>
        <div class="dashboard-stack mt-3">
            @forelse($invoices as $invoice)
                <div class="list-surface-item">
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
    <div class="surface-card card-tone-sand">
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
