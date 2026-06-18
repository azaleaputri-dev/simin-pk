<?php

namespace Tests\Feature;

use App\Models\Guardian;
use App\Models\PPDB;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_register_page_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register Akun');
    }

    public function test_guardian_account_can_be_registered_from_public_form()
    {
        $response = $this->post('/register', [
            'name' => 'Farik Guardian',
            'email' => 'farik@example.com',
            'phone' => '081299998888',
            'address' => 'Jl. Melati No. 7',
            'password' => 'Secret123',
            'password_confirmation' => 'Secret123',
        ]);

        $response->assertRedirect('/portal-orangtua');
        $this->assertDatabaseHas('users', ['email' => 'farik@example.com']);
        $this->assertDatabaseHas('parents', ['email' => 'farik@example.com', 'phone' => '081299998888']);
    }

    public function test_admin_dashboard_redirects_guest_to_login()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_user_can_login_and_access_admin_dashboard()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_guardian_user_is_redirected_to_parent_portal_after_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123'),
        ]);

        Guardian::create([
            'user_id' => $user->id,
            'name' => 'Orang Tua Demo',
            'email' => $user->email,
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 1',
            'father_name' => 'Ayah Demo',
            'mother_name' => 'Ibu Demo',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/portal-orangtua');
        $this->assertAuthenticatedAs($user);
    }

    public function test_guardian_user_cannot_access_admin_area()
    {
        $user = User::factory()->create();

        Guardian::create([
            'user_id' => $user->id,
            'name' => 'Orang Tua Demo',
            'email' => $user->email,
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 1',
            'father_name' => 'Ayah Demo',
            'mother_name' => 'Ibu Demo',
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertRedirect('/portal-orangtua');
    }

    public function test_guardian_user_can_update_profile_from_portal()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        Guardian::create([
            'user_id' => $user->id,
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'phone' => '081234567890',
            'address' => 'Alamat Lama',
            'father_name' => 'Ayah Demo',
            'mother_name' => 'Ibu Demo',
        ]);

        $response = $this->actingAs($user)->put('/portal-orangtua/profil', [
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
            'phone' => '081200001111',
            'address' => 'Alamat Baru',
        ]);

        $response->assertRedirect('/portal-orangtua');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Nama Baru', 'email' => 'baru@example.com']);
        $this->assertDatabaseHas('parents', ['user_id' => $user->id, 'name' => 'Nama Baru', 'email' => 'baru@example.com', 'phone' => '081200001111']);
    }

    public function test_guardian_user_can_update_password_from_portal()
    {
        $user = User::factory()->create([
            'password' => bcrypt('Secret123'),
        ]);

        Guardian::create([
            'user_id' => $user->id,
            'name' => 'Orang Tua Demo',
            'email' => $user->email,
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 1',
            'father_name' => 'Ayah Demo',
            'mother_name' => 'Ibu Demo',
        ]);

        $response = $this->actingAs($user)->put('/portal-orangtua/password', [
            'current_password' => 'Secret123',
            'password' => 'Password999',
            'password_confirmation' => 'Password999',
        ]);

        $response->assertRedirect('/portal-orangtua');
        $this->assertTrue(password_verify('Password999', $user->fresh()->password));
    }

    public function test_guardian_user_can_upload_ppdb_documents_from_portal()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Guardian::create([
            'user_id' => $user->id,
            'name' => 'Orang Tua Demo',
            'email' => $user->email,
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 1',
            'father_name' => 'Ayah Demo',
            'mother_name' => 'Ibu Demo',
        ]);

        $ppdb = PPDB::create([
            'user_id' => $user->id,
            'nama_lengkap' => 'Siswa Demo',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '2018-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bandung',
            'agama' => 'Islam',
            'alamat' => 'Jl. Mawar No. 1',
            'rt' => '001',
            'rw' => '002',
            'dusun' => 'Mawar',
            'kelurahan' => 'Sukamaju',
            'kecamatan' => 'Cicendo',
            'kabupaten' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40123',
            'no_telp' => '081234567800',
            'email' => 'siswa@example.com',
            'nama_orang_tua' => 'Orang Tua Demo',
            'email_orang_tua' => $user->email,
            'no_hp_orang_tua' => '081234567890',
            'asal_sekolah' => 'TK Demo',
            'nisn_asal' => '1234567890',
            'jalur_pendaftaran' => 'zoning',
            'pilihan_jurusan' => 'A',
            'status_pendaftaran' => 'draft',
            'tanggal_daftar' => '2026-06-17',
        ]);

        $response = $this->actingAs($user)->post('/portal-orangtua/ppdb/' . $ppdb->id . '/documents', [
            'document_type' => 'kk',
            'file' => UploadedFile::fake()->image('kk.png'),
        ]);

        $response->assertRedirect('/portal-orangtua');
        $this->assertNotNull($ppdb->fresh()->berkas['kk']['path'] ?? null);
        Storage::disk('public')->assertExists($ppdb->fresh()->berkas['kk']['path']);
    }

    public function test_guardian_user_can_delete_ppdb_documents_from_portal()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Guardian::create([
            'user_id' => $user->id,
            'name' => 'Orang Tua Demo',
            'email' => $user->email,
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 1',
            'father_name' => 'Ayah Demo',
            'mother_name' => 'Ibu Demo',
        ]);

        Storage::disk('public')->put('ppdb/documents/kk-test.pdf', 'dummy');

        $ppdb = PPDB::create([
            'user_id' => $user->id,
            'nama_lengkap' => 'Siswa Demo',
            'nik' => '1234567890123457',
            'tanggal_lahir' => '2018-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bandung',
            'agama' => 'Islam',
            'alamat' => 'Jl. Mawar No. 1',
            'rt' => '001',
            'rw' => '002',
            'dusun' => 'Mawar',
            'kelurahan' => 'Sukamaju',
            'kecamatan' => 'Cicendo',
            'kabupaten' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40123',
            'no_telp' => '081234567800',
            'email' => 'siswa2@example.com',
            'nama_orang_tua' => 'Orang Tua Demo',
            'email_orang_tua' => $user->email,
            'no_hp_orang_tua' => '081234567890',
            'asal_sekolah' => 'TK Demo',
            'nisn_asal' => '1234567891',
            'jalur_pendaftaran' => 'zoning',
            'pilihan_jurusan' => 'A',
            'status_pendaftaran' => 'draft',
            'tanggal_daftar' => '2026-06-17',
            'berkas' => [
                'kk' => [
                    'path' => 'ppdb/documents/kk-test.pdf',
                    'filename' => 'kk-test.pdf',
                    'original_name' => 'kk.pdf',
                    'url' => '/storage/ppdb/documents/kk-test.pdf',
                    'uploaded_at' => now()->toDateTimeString(),
                ],
            ],
        ]);

        $response = $this->actingAs($user)->delete('/portal-orangtua/ppdb/' . $ppdb->id . '/documents/kk');

        $response->assertRedirect('/portal-orangtua');
        $this->assertNull($ppdb->fresh()->berkas['kk']['path'] ?? null);
        Storage::disk('public')->assertMissing('ppdb/documents/kk-test.pdf');
    }

    public function test_guardian_user_cannot_manage_documents_when_ppdb_status_is_final()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Guardian::create([
            'user_id' => $user->id,
            'name' => 'Orang Tua Demo',
            'email' => $user->email,
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 1',
            'father_name' => 'Ayah Demo',
            'mother_name' => 'Ibu Demo',
        ]);

        $ppdb = PPDB::create([
            'user_id' => $user->id,
            'nama_lengkap' => 'Siswa Demo',
            'nik' => '1234567890123458',
            'tanggal_lahir' => '2018-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bandung',
            'agama' => 'Islam',
            'alamat' => 'Jl. Mawar No. 1',
            'rt' => '001',
            'rw' => '002',
            'dusun' => 'Mawar',
            'kelurahan' => 'Sukamaju',
            'kecamatan' => 'Cicendo',
            'kabupaten' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40123',
            'no_telp' => '081234567800',
            'email' => 'siswa3@example.com',
            'nama_orang_tua' => 'Orang Tua Demo',
            'email_orang_tua' => $user->email,
            'no_hp_orang_tua' => '081234567890',
            'asal_sekolah' => 'TK Demo',
            'nisn_asal' => '1234567892',
            'jalur_pendaftaran' => 'zoning',
            'pilihan_jurusan' => 'A',
            'status_pendaftaran' => 'diterima',
            'tanggal_daftar' => '2026-06-17',
        ]);

        $uploadResponse = $this->actingAs($user)->post('/portal-orangtua/ppdb/' . $ppdb->id . '/documents', [
            'document_type' => 'kk',
            'file' => UploadedFile::fake()->image('kk.png'),
        ]);

        $uploadResponse->assertRedirect('/portal-orangtua');
        $this->assertNull($ppdb->fresh()->berkas['kk']['path'] ?? null);
    }

    public function test_api_ppdb_submit_uses_supported_draft_status()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/ppdb/submit', [
            'nama_lengkap' => 'Siswa API',
            'nik' => '1234567890123459',
            'tanggal_lahir' => '2018-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bandung',
            'agama' => 'Islam',
            'alamat' => 'Jl. API No. 1',
            'rt' => '001',
            'rw' => '002',
            'dusun' => 'Mawar',
            'kelurahan' => 'Sukamaju',
            'kecamatan' => 'Cicendo',
            'kabupaten' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40123',
            'no_telp' => '081234567801',
            'email' => 'siswa-api@example.com',
            'nama_orang_tua' => 'Orang Tua API',
            'email_orang_tua' => 'ortu-api@example.com',
            'no_hp_orang_tua' => '081234567891',
            'asal_sekolah' => 'TK API',
            'nisn_asal' => '1234567893',
            'jalur_pendaftaran' => 'zoning',
            'pilihan_jurusan' => 'A',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status_pendaftaran', 'draft');

        $this->assertDatabaseHas('p_p_d_b_s', [
            'nik' => '1234567890123459',
            'status_pendaftaran' => 'draft',
            'user_id' => $user->id,
        ]);
    }

    public function test_api_login_returns_token_and_user()
    {
        $user = User::factory()->create([
            'password' => bcrypt('Secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Secret123',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.id', $user->id);

        $this->assertNotEmpty($response->json('data.token'));
    }

    public function test_api_profile_returns_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/profile');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $user->id);
    }

    public function test_api_change_password_updates_user_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('Secret123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/change-password', [
            'current_password' => 'Secret123',
            'new_password' => 'BaruPass123',
            'new_password_confirmation' => 'BaruPass123',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true);

        $this->assertTrue(password_verify('BaruPass123', $user->fresh()->password));
    }

    public function test_api_logout_deletes_current_access_token()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $token->plainTextToken)
            ->postJson('/api/logout');

        $response->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
