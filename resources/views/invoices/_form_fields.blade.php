@csrf
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Nomor Invoice</label>
        <input type="text" class="form-control" value="{{ $invoiceNumber ?? $invoice->invoice_number }}" disabled>
    </div>
    <div class="col-md-4">
        <label class="form-label">Siswa</label>
        <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
            @foreach($students as $studentOption)
                <option value="{{ $studentOption->id }}" @selected((string) old('student_id', $invoice->student_id ?? '') === (string) $studentOption->id)>{{ $studentOption->nama_lengkap }} - {{ $studentOption->nis }}</option>
            @endforeach
        </select>
        @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Tahun Ajaran</label>
        <select name="academic_year_id" class="form-select">
            <option value="">Ikuti data siswa</option>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}" @selected((string) old('academic_year_id', $invoice->academic_year_id ?? '') === (string) $year->id)>{{ $year->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Tanggal Invoice</label>
        <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" value="{{ old('invoice_date', isset($invoice->invoice_date) ? $invoice->invoice_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
        @error('invoice_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Jatuh Tempo</label>
        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date', isset($invoice->due_date) ? $invoice->due_date->format('Y-m-d') : now()->addDays(14)->format('Y-m-d')) }}" required>
        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @isset($invoice)
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach([\App\Models\Invoice::STATUS_UNPAID, \App\Models\Invoice::STATUS_PARTIAL, \App\Models\Invoice::STATUS_PAID, \App\Models\Invoice::STATUS_CANCELLED] as $status)
                    <option value="{{ $status }}" @selected(old('status', $invoice->status) === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    @endisset
    <div class="col-md-4">
        <label class="form-label">Jenis Biaya</label>
        <select name="fee_type_id" class="form-select @error('fee_type_id') is-invalid @enderror" required>
            @foreach($feeTypes as $feeType)
                <option value="{{ $feeType->id }}" @selected((string) old('fee_type_id', $item->fee_type_id ?? '') === (string) $feeType->id)>{{ $feeType->name }}</option>
            @endforeach
        </select>
        @error('fee_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Tarif</label>
        <select name="tariff_id" class="form-select">
            <option value="">Tanpa tarif referensi</option>
            @foreach($tariffs as $tariff)
                <option value="{{ $tariff->id }}" @selected((string) old('tariff_id', $item->tariff_id ?? '') === (string) $tariff->id)>{{ $tariff->name }} - Rp{{ number_format($tariff->amount, 0, ',', '.') }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Nominal</label>
        <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $item->amount ?? '') }}" required>
        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Keterangan</label>
        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $item->description ?? '') }}" required>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Catatan</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $invoice->notes ?? '') }}</textarea>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
