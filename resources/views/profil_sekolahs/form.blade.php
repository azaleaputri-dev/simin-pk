@csrf
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Nama Sekolah</label>
        <input type="text" name="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" value="{{ old('nama_sekolah', $profilSekolah->nama_sekolah ?? '') }}" required>
        @error('nama_sekolah') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">NPSN</label>
        <input type="text" name="npsn" class="form-control @error('npsn') is-invalid @enderror" value="{{ old('npsn', $profilSekolah->npsn ?? '') }}">
        @error('npsn') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $profilSekolah->alamat ?? '') }}</textarea>
        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Kecamatan</label>
        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $profilSekolah->kecamatan ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Kabupaten</label>
        <input type="text" name="kabupaten" class="form-control" value="{{ old('kabupaten', $profilSekolah->kabupaten ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Provinsi</label>
        <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $profilSekolah->provinsi ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Kode Pos</label>
        <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $profilSekolah->kode_pos ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Telepon</label>
        <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $profilSekolah->telepon ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $profilSekolah->email ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Website</label>
        <input type="url" name="website" class="form-control" value="{{ old('website', $profilSekolah->website ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="negeri" @selected(old('status', $profilSekolah->status ?? '') === 'negeri')>Negeri</option>
            <option value="swasta" @selected(old('status', $profilSekolah->status ?? 'swasta') === 'swasta')>Swasta</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Akreditasi</label>
        <input type="text" name="akreditasi" class="form-control" value="{{ old('akreditasi', $profilSekolah->akreditasi ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Tahun Berdiri</label>
        <input type="number" name="tahun_berdiri" class="form-control" value="{{ old('tahun_berdiri', $profilSekolah->tahun_berdiri ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Kepala Sekolah</label>
        <input type="text" name="kepala_sekolah" class="form-control" value="{{ old('kepala_sekolah', $profilSekolah->kepala_sekolah ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">NIP Kepala Sekolah</label>
        <input type="text" name="nip_kepala" class="form-control" value="{{ old('nip_kepala', $profilSekolah->nip_kepala ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Jumlah Guru</label>
        <input type="number" min="0" name="jumlah_guru" class="form-control" value="{{ old('jumlah_guru', $profilSekolah->jumlah_guru ?? 0) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Jumlah Siswa</label>
        <input type="number" min="0" name="jumlah_siswa" class="form-control" value="{{ old('jumlah_siswa', $profilSekolah->jumlah_siswa ?? 0) }}">
    </div>
    <div class="col-12">
        <label class="form-label">Fasilitas</label>
        <textarea name="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" rows="3">{{ old('fasilitas', isset($profilSekolah->fasilitas) ? (is_array($profilSekolah->fasilitas) ? json_encode($profilSekolah->fasilitas) : $profilSekolah->fasilitas) : '') }}</textarea>
        <div class="form-text">Gunakan format JSON array, misalnya `["perpustakaan","laboratorium"]`.</div>
        @error('fasilitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $profilSekolah->deskripsi ?? '') }}</textarea>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('profil-sekolahs.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
