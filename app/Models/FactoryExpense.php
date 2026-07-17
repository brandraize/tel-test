<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactoryExpense extends Model
{
    protected $fillable = [
        'category',
        'description',
        'amount',
        'date',
        'payment_method',
        'reference',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];
}
