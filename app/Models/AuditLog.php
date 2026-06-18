<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'auditlog';

    protected $fillable = [
        'action',
        'entity_type',
        'entity_id',
        'description',
    ];
}
