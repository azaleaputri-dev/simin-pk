@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nama Tarif</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $tariff->name ?? '') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Jenis Biaya</label>
        <select name="fee_type_id" class="form-select @error('fee_type_id') is-invalid @enderror" required>
            @foreach($feeTypes as $feeType)
                <option value="{{ $feeType->id }}" @selected((string) old('fee_type_id', $tariff->fee_type_id ?? '') === (string) $feeType->id)>{{ $feeType->name }}</option>
            @endforeach
        </select>
        @error('fee_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Tahun Ajaran</label>
        <select name="academic_year_id" class="form-select @error('academic_year_id') is-invalid @enderror" required>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}" @selected((string) old('academic_year_id', $tariff->academic_year_id ?? '') === (string) $year->id)>{{ $year->name }}</option>
            @endforeach
        </select>
        @error('academic_year_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Nominal</label>
        <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $tariff->amount ?? '') }}" required>
        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="tariffActive" @checked(old('is_active', $tariff->is_active ?? true))>
            <label class="form-check-label" for="tariffActive">Aktif</label>
        </div>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('tariffs.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
