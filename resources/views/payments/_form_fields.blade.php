@csrf
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Nomor Pembayaran</label>
        <input type="text" class="form-control" value="{{ $paymentNumber }}" disabled>
    </div>
    <div class="col-md-8">
        <label class="form-label">Invoice</label>
        <select name="invoice_id" class="form-select @error('invoice_id') is-invalid @enderror" required>
            @foreach($invoices as $invoice)
                <option value="{{ $invoice->id }}" @selected((string) old('invoice_id') === (string) $invoice->id)>{{ $invoice->invoice_number }} - {{ $invoice->student?->nama_lengkap }} - sisa Rp{{ number_format($invoice->remaining_amount, 0, ',', '.') }}</option>
            @endforeach
        </select>
        @error('invoice_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Tanggal Pembayaran</label>
        <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required>
        @error('payment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Nominal</label>
        <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Metode</label>
        <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
            <option value="{{ \App\Models\Payment::METHOD_TRANSFER_BANK }}" @selected(old('payment_method') === \App\Models\Payment::METHOD_TRANSFER_BANK)>Transfer Bank</option>
            <option value="{{ \App\Models\Payment::METHOD_CASH }}" @selected(old('payment_method') === \App\Models\Payment::METHOD_CASH)>Tunai</option>
        </select>
        @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Nama Pengirim</label>
        <input type="text" name="sender_name" class="form-control" value="{{ old('sender_name') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Bukti Pembayaran</label>
        <input type="text" name="proof_reference" class="form-control" value="{{ old('proof_reference') }}" placeholder="contoh: bukti-transfer-001.jpg">
    </div>
    <div class="col-12">
        <label class="form-label">Catatan</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary">Simpan Pembayaran</button>
    <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
