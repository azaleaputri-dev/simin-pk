@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nama Kelas</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $kelas->name ?? '') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Tahun Ajaran</label>
        <select name="academic_year_id" class="form-select @error('academic_year_id') is-invalid @enderror" required>
            <option value="">Pilih tahun ajaran</option>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}" @selected((string) old('academic_year_id', $kelas->academic_year_id ?? '') === (string) $year->id)>{{ $year->name }}</option>
            @endforeach
        </select>
        @error('academic_year_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Jenjang</label>
        <select name="jenjang" class="form-select @error('jenjang') is-invalid @enderror" required>
            @foreach(['PAUD A', 'PAUD B', 'TK A', 'TK B'] as $jenjang)
                <option value="{{ $jenjang }}" @selected(old('jenjang', $kelas->jenjang ?? '') === $jenjang)>{{ $jenjang }}</option>
            @endforeach
        </select>
        @error('jenjang') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Kuota</label>
        <input type="number" min="0" name="quota" class="form-control @error('quota') is-invalid @enderror" value="{{ old('quota', $kelas->quota ?? 0) }}" required>
        @error('quota') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="status" value="1" id="status" @checked(old('status', $kelas->status ?? true))>
            <label class="form-check-label" for="status">Kelas aktif</label>
        </div>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
