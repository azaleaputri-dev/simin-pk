@csrf
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">NIS</label>
        <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $student->nis ?? '') }}" required>
        @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-8">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $student->nama_lengkap ?? '') }}" required>
        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">NIK</label>
        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $student->nik ?? '') }}">
        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
            @foreach(['Laki-laki', 'Perempuan'] as $gender)
                <option value="{{ $gender }}" @selected(old('jenis_kelamin', $student->jenis_kelamin ?? '') === $gender)>{{ $gender }}</option>
            @endforeach
        </select>
        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Status Siswa</label>
        <select name="status_siswa" class="form-select @error('status_siswa') is-invalid @enderror" required>
            @foreach(['ACTIVE', 'INACTIVE', 'TRANSFERRED', 'GRADUATED'] as $status)
                <option value="{{ $status }}" @selected(old('status_siswa', $student->status_siswa ?? 'ACTIVE') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        @error('status_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $student->tempat_lahir ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', isset($student->tanggal_lahir) ? $student->tanggal_lahir->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Agama</label>
        <input type="text" name="agama" class="form-control" value="{{ old('agama', $student->agama ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Orang Tua</label>
        <select name="parent_id" class="form-select">
            <option value="">Pilih orang tua</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" @selected((string) old('parent_id', $student->parent_id ?? '') === (string) $parent->id)>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Kelas</label>
        <select name="kelas_id" class="form-select">
            <option value="">Pilih kelas</option>
            @foreach($kelas as $classroom)
                <option value="{{ $classroom->id }}" @selected((string) old('kelas_id', $student->kelas_id ?? '') === (string) $classroom->id)>{{ $classroom->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Tahun Ajaran</label>
        <select name="academic_year_id" class="form-select">
            <option value="">Pilih tahun ajaran</option>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}" @selected((string) old('academic_year_id', $student->academic_year_id ?? '') === (string) $year->id)>{{ $year->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $student->alamat ?? '') }}</textarea>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
