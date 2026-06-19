<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
        'quota',
        'ppdb_is_open',
        'ppdb_start_date',
        'ppdb_end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'ppdb_is_open' => 'boolean',
        'ppdb_start_date' => 'date',
        'ppdb_end_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getActive()
    {
        return self::active()->first();
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    protected static function booted()
    {
        static::saving(function ($academicYear) {
            if ($academicYear->is_active) {
                // Deactivate all other academic years
                self::where('is_active', true)
                    ->where('id', '!=', $academicYear->id)
                    ->update(['is_active' => false]);
            }
        });
    }

    public function getRemainingQuotaAttribute()
    {
        if ($this->quota === null) {
            return null; // unlimited
        }
        return max($this->quota - $this->students()->count(), 0);
    }

    public function isQuotaExceeded()
    {
        if ($this->quota === null) {
            return false; // unlimited
        }
        return $this->students()->count() >= $this->quota;
    }

    public function isPpdbOpen(): bool
    {
        return $this->ppdb_is_open && $this->is_active;
    }

    public function isPpdbWithinPeriod(): bool
    {
        if (!$this->ppdb_start_date || !$this->ppdb_end_date) {
            return true;
        }
        $now = now()->startOfDay();
        return $now->gte($this->ppdb_start_date) && $now->lte($this->ppdb_end_date);
    }

    public function ppdbStatusBadge(): array
    {
        if (!$this->is_active) {
            return ['label' => 'Tidak Ada Tahun Ajaran Aktif', 'class' => 'text-bg-secondary'];
        }
        if ($this->isPpdbOpen() && $this->isPpdbWithinPeriod()) {
            return ['label' => 'PPDB Dibuka', 'class' => 'text-bg-success'];
        }
        if ($this->ppdb_is_open && !$this->isPpdbWithinPeriod()) {
            return ['label' => 'PPDB Diluar Periode', 'class' => 'text-bg-warning'];
        }
        return ['label' => 'PPDB Ditutup', 'class' => 'text-bg-danger'];
    }
}