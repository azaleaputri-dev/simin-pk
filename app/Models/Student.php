<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'kelas_id',
        'academic_year_id',
        'ppdb_id',
        'nis',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'status_siswa',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'parent_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function ppdb()
    {
        return $this->belongsTo(PPDB::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
