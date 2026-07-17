<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingMaterial extends Model
{
    protected $fillable = [
        'supplier_name',
        'material_name',
        'quantity',
        'unit_price',
        'total_cost',
        'date_received',
        'payment_status',
        'paid_amount',
        'due_date',
        'invoice_number',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'date_received' => 'date',
        'due_date' => 'date',
    ];

    public function getPendingAmountAttribute(): float
    {
        return round((float) $this->total_cost - (float) $this->paid_amount, 2);
    }
}
