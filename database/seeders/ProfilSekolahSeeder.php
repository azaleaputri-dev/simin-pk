<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ProfilSekolah::updateOrCreate(['npsn' => '20123456'], [
            'nama_sekolah' => 'SMA Negeri 1 Contoh',
            'alamat' => 'Jl. Contoh No. 123',
            'kecamatan' => 'Contoh Tengah',
            'kabupaten' => 'Kabupaten Contoh',
            'provinsi' => 'Provinsi Contoh',
            'kode_pos' => '12345',
            'telepon' => '02112345678',
            'email' => 'info@sman1contoh.sch.id',
            'website' => 'https://sman1contoh.sch.id',
            'status' => 'negeri',
            'akreditasi' => 'A',
            'tahun_berdiri' => 1985,
            'kepala_sekolah' => 'Dr. Budi Santoso, S.Pd., M.Pd.',
            'nip_kepala' => '197001012000031001',
            'jumlah_guru' => 45,
            'jumlah_siswa' => 850,
            'fasilitas' => ['laboratorium_ipa', 'perpustakaan', 'lapangan_olahraga', 'aula'],
            'deskripsi' => 'Sekolah menengah atas negeri unggul dengan akreditasi A.'
        ]);
    }
}
