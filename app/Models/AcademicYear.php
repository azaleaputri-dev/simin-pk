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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
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
}