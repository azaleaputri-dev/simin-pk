@csrf
<div class="row g-3" data-emsifa-region>
    <div class="col-12"><div class="form-section-header siswa"><i class="bi bi-person-vcard me-2"></i>Data Calon Siswa</div></div>
    <div class="col-md-6">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $ppdb->nama_lengkap ?? '') }}" required>
        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">NIK</label>
        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $ppdb->nik ?? '') }}" maxlength="16" required>
        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $ppdb->tempat_lahir ?? '') }}" required>
        @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', isset($ppdb->tanggal_lahir) ? $ppdb->tanggal_lahir->format('Y-m-d') : '') }}" required>
        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
            @foreach(['Laki-laki', 'Perempuan'] as $gender)
                <option value="{{ $gender }}" @selected(old('jenis_kelamin', $ppdb->jenis_kelamin ?? '') === $gender)>{{ $gender }}</option>
            @endforeach
        </select>
        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Agama</label>
        <input type="text" name="agama" class="form-control @error('agama') is-invalid @enderror" value="{{ old('agama', $ppdb->agama ?? '') }}" required>
        @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">No. HP Siswa</label>
        <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $ppdb->no_telp ?? '') }}" required>
        @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Email Siswa</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $ppdb->email ?? '') }}">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $ppdb->alamat ?? '') }}</textarea>
        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-2">
        <label class="form-label">RT</label>
        <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt', $ppdb->rt ?? '') }}" required>
        @error('rt') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-2">
        <label class="form-label">RW</label>
        <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw', $ppdb->rw ?? '') }}" required>
        @error('rw') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-2">
        <label class="form-label">Dusun</label>
        <input type="text" name="dusun" class="form-control @error('dusun') is-invalid @enderror" value="{{ old('dusun', $ppdb->dusun ?? '') }}">
        @error('dusun') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Provinsi</label>
        <select
            name="provinsi"
            class="form-select @error('provinsi') is-invalid @enderror"
            data-emsifa-level="province"
            data-current="{{ old('provinsi', $ppdb->provinsi ?? '') }}"
            required
        >
            <option value="">Pilih Provinsi</option>
        </select>
        @error('provinsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Kabupaten / Kota</label>
        <select
            name="kabupaten"
            class="form-select @error('kabupaten') is-invalid @enderror"
            data-emsifa-level="regency"
            data-current="{{ old('kabupaten', $ppdb->kabupaten ?? '') }}"
            required
            disabled
        >
            <option value="">Pilih Kabupaten / Kota</option>
        </select>
        @error('kabupaten') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Kecamatan</label>
        <select
            name="kecamatan"
            class="form-select @error('kecamatan') is-invalid @enderror"
            data-emsifa-level="district"
            data-current="{{ old('kecamatan', $ppdb->kecamatan ?? '') }}"
            required
            disabled
        >
            <option value="">Pilih Kecamatan</option>
        </select>
        @error('kecamatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Kelurahan</label>
        <select
            name="kelurahan"
            class="form-select @error('kelurahan') is-invalid @enderror"
            data-emsifa-level="village"
            data-current="{{ old('kelurahan', $ppdb->kelurahan ?? '') }}"
            required
            disabled
        >
            <option value="">Pilih Kelurahan</option>
        </select>
        @error('kelurahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Kode Pos</label>
        <input type="text" name="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos', $ppdb->kode_pos ?? '') }}" required>
        @error('kode_pos') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12 pt-3"><div class="form-section-header orangtua"><i class="bi bi-people me-2"></i>Data Orang Tua</div></div>
    <div class="col-md-4">
        <label class="form-label">Nama Orang Tua</label>
        <input type="text" name="nama_orang_tua" class="form-control @error('nama_orang_tua') is-invalid @enderror" value="{{ old('nama_orang_tua', $ppdb->nama_orang_tua ?? '') }}" required>
        @error('nama_orang_tua') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Email Orang Tua</label>
        <input type="email" name="email_orang_tua" class="form-control @error('email_orang_tua') is-invalid @enderror" value="{{ old('email_orang_tua', $ppdb->email_orang_tua ?? '') }}" required>
        @error('email_orang_tua') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">No. HP Orang Tua</label>
        <input type="text" name="no_hp_orang_tua" class="form-control @error('no_hp_orang_tua') is-invalid @enderror" value="{{ old('no_hp_orang_tua', $ppdb->no_hp_orang_tua ?? '') }}" required>
        @error('no_hp_orang_tua') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12 pt-3"><div class="form-section-header ppdb"><i class="bi bi-journal-check me-2"></i>Data PPDB</div></div>
    <div class="col-md-4">
        <label class="form-label">Asal Sekolah</label>
        <input type="text" name="asal_sekolah" class="form-control @error('asal_sekolah') is-invalid @enderror" value="{{ old('asal_sekolah', $ppdb->asal_sekolah ?? '') }}" required>
        @error('asal_sekolah') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">NISN Asal</label>
        <input type="text" name="nisn_asal" class="form-control @error('nisn_asal') is-invalid @enderror" value="{{ old('nisn_asal', $ppdb->nisn_asal ?? '') }}">
        @error('nisn_asal') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Jalur Pendaftaran</label>
        <select name="jalur_pendaftaran" class="form-select @error('jalur_pendaftaran') is-invalid @enderror" required>
            @foreach(['zoning' => 'Zoning', 'prestasi' => 'Prestasi', 'afirmasi' => 'Afirmasi'] as $key => $label)
                <option value="{{ $key }}" @selected(old('jalur_pendaftaran', $ppdb->jalur_pendaftaran ?? '') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('jalur_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Pilihan Jurusan</label>
        <input type="text" name="pilihan_jurusan" class="form-control @error('pilihan_jurusan') is-invalid @enderror" value="{{ old('pilihan_jurusan', $ppdb->pilihan_jurusan ?? '') }}">
        @error('pilihan_jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @if(($showAdminFields ?? true))
        <div class="col-md-4">
            <label class="form-label">Status Pendaftaran</label>
            <select name="status_pendaftaran" class="form-select @error('status_pendaftaran') is-invalid @enderror" required>
                @foreach(\App\Models\PPDB::STATUSES as $status)
                    <option value="{{ $status }}" @selected(old('status_pendaftaran', $ppdb->status_pendaftaran ?? 'draft') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                @endforeach
            </select>
            @error('status_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="form-control @error('tanggal_daftar') is-invalid @enderror" value="{{ old('tanggal_daftar', isset($ppdb->tanggal_daftar) ? $ppdb->tanggal_daftar->format('Y-m-d') : '') }}">
            @error('tanggal_daftar') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Tes</label>
            <input type="date" name="tanggal_tes" class="form-control @error('tanggal_tes') is-invalid @enderror" value="{{ old('tanggal_tes', isset($ppdb->tanggal_tes) ? $ppdb->tanggal_tes->format('Y-m-d') : '') }}">
            @error('tanggal_tes') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Pengumuman</label>
            <input type="date" name="tanggal_pengumuman" class="form-control @error('tanggal_pengumuman') is-invalid @enderror" value="{{ old('tanggal_pengumuman', isset($ppdb->tanggal_pengumuman) ? $ppdb->tanggal_pengumuman->format('Y-m-d') : '') }}">
            @error('tanggal_pengumuman') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Berkas (JSON)</label>
            <textarea name="berkas" class="form-control @error('berkas') is-invalid @enderror" rows="2">{{ old('berkas', isset($ppdb->berkas) ? json_encode($ppdb->berkas) : '') }}</textarea>
            @error('berkas') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    @endif
    <div class="col-12">
        <label class="form-label">Catatan</label>
        <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan', $ppdb->catatan ?? '') }}</textarea>
        @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ $backUrl ?? route('ppdb.index') }}" class="btn btn-outline-secondary">{{ $backLabel ?? 'Kembali' }}</a>
</div>

@include('components.forms._emsifa_region_script')
