<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'fee_type_id',
        'tariff_id',
        'description',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    protected static function booted()
    {
        static::deleting(function ($invoiceItem) {
            $invoice = $invoiceItem->invoice;
            // Count items excluding this one
            $count = $invoice->items()->where('id', '!=', $invoiceItem->id)->count();
            if ($count === 0) {
                // Prevent deletion of the last item
                throw new \Exception('Cannot delete the last invoice item. Invoice must have at least one item.');
            }
        });
    }
}