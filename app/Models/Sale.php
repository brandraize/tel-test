<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'name',
        'date',
        'total_items',
        'total_amount',
        'net_profit',
        'wasool',
        'extra_fields'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'total_amount' => 'decimal:2',
        'net_profit' => 'decimal:2',
        'wasool' => 'decimal:2',
        'baqii' => 'decimal:2',
        'extra_fields' => 'array'
    ];

    /**
     * Get the baqii (pending) amount.
     */
    public function getBaqiiAttribute()
    {
        return $this->total_amount - $this->wasool;
    }

    /**
     * Check if sale is fully paid.
     */
    public function isFullyPaid()
    {
        return $this->wasool >= $this->total_amount;
    }

    /**
     * Get the category label.
     */
    public function getCategoryLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->category));
    }

    // Category scopes
    public function scopeGress($query)
    {
        return $query->where('category', 'gress');
    }

    public function scopeJalee($query)
    {
        return $query->where('category', 'jalee');
    }

    public function scopeBailt($query)
    {
        return $query->where('category', 'bailt');
    }

    public function scopeGonde($query)
    {
        return $query->where('category', 'gonde');
    }

    public function scopePanjaee($query)
    {
        return $query->where('category', 'panjaee');
    }

    public function scopeTagharee($query)
    {
        return $query->where('category', 'tagharee');
    }

    public function scopeSaberBand($query)
    {
        return $query->where('category', 'saber_band');
    }

    public function scopeMaxKatha($query)
    {
        return $query->where('category', 'max_katha');
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('date', [$start, $end]);
    }

    /**
     * Get sales with pending amounts.
     */
    public function scopeWithPending($query)
    {
        return $query->whereColumn('wasool', '<', 'total_amount');
    }
}
