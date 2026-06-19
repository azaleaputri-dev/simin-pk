<div class="border rounded-4 p-4 bg-white">
    <div class="section-label mb-2">Keamanan Akun</div>
    <h3 class="h5">Ganti password</h3>
    <form action="{{ route('parent.portal.password.update') }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Password Saat Ini</label>
            <div class="input-group">
                <input type="password" name="current_password" id="portalCurrentPassword" class="form-control @error('current_password') is-invalid @enderror" required>
                <button type="button" class="btn btn-outline-secondary password-toggle" data-password-target="portalCurrentPassword">Lihat</button>
                @error('current_password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <div class="input-group">
                <input type="password" name="password" id="portalNewPassword" class="form-control @error('password') is-invalid @enderror" required>
                <button type="button" class="btn btn-outline-secondary password-toggle" data-password-target="portalNewPassword">Lihat</button>
            </div>
            <div class="form-text">Minimal 8 karakter, ada huruf besar, huruf kecil, dan angka.</div>
            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="portalPasswordConfirmation" class="form-control" required>
                <button type="button" class="btn btn-outline-secondary password-toggle" data-password-target="portalPasswordConfirmation">Lihat</button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>
