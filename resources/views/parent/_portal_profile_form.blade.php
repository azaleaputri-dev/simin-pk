<div class="border rounded-4 p-4 bg-white">
    <div class="section-label mb-2">Profil Akun</div>
    <h3 class="h5">Perbarui data user</h3>
    <form action="{{ route('parent.portal.profile.update') }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $guardian?->name) }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $guardian?->email) }}" class="form-control @error('email') is-invalid @enderror" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">No. HP</label>
            <input type="text" name="phone" value="{{ old('phone', $guardian?->phone) }}" class="form-control @error('phone') is-invalid @enderror" required>
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $guardian?->address) }}</textarea>
            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Profil</button>
    </form>
</div>
