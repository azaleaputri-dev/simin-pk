<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'title',
        'content',
        'target',
        'publish_date',
        'status',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'status' => 'string',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
