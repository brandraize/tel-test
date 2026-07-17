<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_name',
        'description',
        'no_of_items',
        'price',
        'date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
        'total_cost' => 'decimal:2'
    ];

    /**
     * Get the total cost attribute.
     */
    public function getTotalCostAttribute()
    {
        return $this->no_of_items * $this->price;
    }

    /**
     * Scope a query to only include expensive materials.
     */
    public function scopeExpensive($query, $amount)
    {
        return $query->where('price', '>', $amount);
    }

    /**
     * Scope a query to search materials.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('item_name', 'LIKE', "%{$search}%")
                     ->orWhere('description', 'LIKE', "%{$search}%");
    }
}
