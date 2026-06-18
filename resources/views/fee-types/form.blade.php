@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nama Jenis Biaya</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $feeType->name ?? '') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Kode Biaya</label>
        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $feeType->code ?? '') }}" required>
        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $feeType->description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="feeActive" @checked(old('is_active', $feeType->is_active ?? true))>
            <label class="form-check-label" for="feeActive">Aktif</label>
        </div>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('fee-types.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
