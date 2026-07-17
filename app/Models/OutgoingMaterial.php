<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingMaterial extends Model
{
    protected $fillable = [
        'customer_name',
        'material_name',
        'quantity',
        'unit_price',
        'total_price',
        'date',
        'payment_status',
        'received_amount',
        'due_date',
        'invoice_number',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'received_amount' => 'decimal:2',
        'date' => 'date',
        'due_date' => 'date',
    ];

    public function getPendingAmountAttribute(): float
    {
        return round((float) $this->total_price - (float) $this->received_amount, 2);
    }
}
