<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public const STATUS_UNPAID = 'UNPAID';
    public const STATUS_PARTIAL = 'PARTIAL';
    public const STATUS_PAID = 'PAID';
    public const STATUS_CANCELLED = 'CANCELLED';

    public const OPEN_STATUSES = [
        self::STATUS_UNPAID,
        self::STATUS_PARTIAL,
    ];

    public const EDITABLE_STATUSES = [
        self::STATUS_UNPAID,
        self::STATUS_PARTIAL,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'invoice_number',
        'student_id',
        'parent_id',
        'academic_year_id',
        'invoice_date',
        'due_date',
        'status',
        'total_amount',
        'approved_payment_total',
        'remaining_amount',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'approved_payment_total' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'parent_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function hasPaymentsRecorded(): bool
    {
        return $this->payments()->exists();
    }
}
