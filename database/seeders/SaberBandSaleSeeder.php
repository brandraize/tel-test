<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SaberBandSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'name' => 'Qaser',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 150,
                'net_profit' => 45,
                'wasool' => 0,
            ],
            [
                'name' => 'wahab',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 150,
                'net_profit' => 45,
                'wasool' => 0,
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create([
                'category' => 'saber_band',
                'name' => $sale['name'],
                'date' => $sale['date'],
                'total_items' => $sale['total_items'],
                'total_amount' => $sale['total_amount'],
                'net_profit' => $sale['net_profit'],
                'wasool' => $sale['wasool'],
            ]);
        }
    }
}
