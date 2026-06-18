<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Services\PpdbApprovalService;
use Illuminate\Support\Facades\Hash;

class PPBDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@siminpk.local'],
            [
                'name' => 'Administrator SIMIN-PK',
                'password' => Hash::make('admin12345'),
            ]
        );

        $ppdb = \App\Models\PPDB::updateOrCreate(['nik' => '3174012304980003'], [
            'nama_lengkap' => 'Budi Santoso',
            'tanggal_lahir' => '2008-05-15',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Jakarta',
            'agama' => 'Islam',
            'alamat' => 'Jl. Pahlawan No. 12',
            'rt' => '005',
            'rw' => '002',
            'kelurahan' => 'Senen',
            'kecamatan' => 'Senen',
            'kabupaten' => 'Jakarta Pusat',
            'provinsi' => 'DKI Jakarta',
            'kode_pos' => '10410',
            'no_telp' => '081234567890',
            'email' => 'budi.santo@example.com',
            'nama_orang_tua' => 'Siti Rahmawati',
            'email_orang_tua' => 'rahmawati.parent@example.com',
            'no_hp_orang_tua' => '081298765432',
            'asal_sekolah' => 'SMP Negeri 1 Jakarta',
            'nisn_asal' => '1234567890',
            'jalur_pendaftaran' => 'zoning',
            'pilihan_jurusan' => 'IPA',
            'status_pendaftaran' => 'diterima',
            'tanggal_daftar' => '2023-06-01',
            'tanggal_tes' => '2023-06-15',
            'tanggal_pengumuman' => '2023-06-20',
            'berkas' => ['ijazah.pdf', 'raport.pdf', 'kk.pdf'],
            'catatan' => 'Calon siswa bersifat aktif dan prestatif.',
            'user_id' => $user->id,
        ]);

        if ($ppdb->status_pendaftaran === 'diterima') {
            app(PpdbApprovalService::class)->approve($ppdb);
        }
    }
}
