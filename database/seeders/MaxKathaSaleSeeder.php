<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class MaxKathaSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'name' => 'Roman',
                'date' => null,
                'total_items' => null,
                'total_amount' => 1300,
                'net_profit' => 500,
                'wasool' => 1300,
                'extra_fields' => ['description' => 'Polii'],
            ],
            [
                'name' => 'Irshad',
                'date' => null,
                'total_items' => null,
                'total_amount' => 750,
                'net_profit' => 750,
                'wasool' => 0,
                'extra_fields' => ['description' => null],
            ],
            [
                'name' => 'Imam Said',
                'date' => null,
                'total_items' => null,
                'total_amount' => 11000,
                'net_profit' => 800,
                'wasool' => 11000,
                'extra_fields' => ['description' => 'Baring'],
            ],
            [
                'name' => 'Farhad',
                'date' => null,
                'total_items' => null,
                'total_amount' => 8200,
                'net_profit' => 800,
                'wasool' => 8200,
                'extra_fields' => ['description' => 'Baring'],
            ],
            [
                'name' => 'Patah',
                'date' => null,
                'total_items' => null,
                'total_amount' => 15700,
                'net_profit' => 0,
                'wasool' => 11000,
                'extra_fields' => ['description' => null],
            ],
            [
                'name' => 'Noral',
                'date' => null,
                'total_items' => null,
                'total_amount' => 6000,
                'net_profit' => 950,
                'wasool' => 0,
                'extra_fields' => ['description' => 'polie'],
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create([
                'category' => 'max_katha',
                'name' => $sale['name'],
                'date' => $sale['date'],
                'total_items' => $sale['total_items'],
                'total_amount' => $sale['total_amount'],
                'net_profit' => $sale['net_profit'],
                'wasool' => $sale['wasool'],
                'extra_fields' => $sale['extra_fields'],
            ]);
        }
    }
}
