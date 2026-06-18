<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'status',
        'akreditasi',
        'tahun_berdiri',
        'kepala_sekolah',
        'nip_kepala',
        'jumlah_guru',
        'jumlah_siswa',
        'fasilitas',
        'deskripsi',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'tahun_berdiri' => 'integer',
        'jumlah_guru' => 'integer',
        'jumlah_siswa' => 'integer',
    ];
}
