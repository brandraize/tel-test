<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class BailtSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'name' => 'Zahid',
                'date' => null,
                'total_items' => 5,
                'total_amount' => 18487.5,
                'net_profit' => 2550,
                'wasool' => 0,
                'extra_fields' => ['bailt_no' => 255],
            ],
            [
                'name' => 'Roman',
                'date' => null,
                'total_items' => 3,
                'total_amount' => 7830,
                'net_profit' => 1080,
                'wasool' => 7830,
                'extra_fields' => ['bailt_no' => 180],
            ],
            [
                'name' => 'Shafiq',
                'date' => null,
                'total_items' => 3,
                'total_amount' => 8700,
                'net_profit' => 1200,
                'wasool' => 8000,
                'extra_fields' => ['bailt_no' => 200],
            ],
            [
                'name' => 'Farooq',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 7685,
                'net_profit' => 1060,
                'wasool' => 0,
                'extra_fields' => ['bailt_no' => 265],
            ],
            [
                'name' => 'Badshah',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 6090,
                'net_profit' => 840,
                'wasool' => 0,
                'extra_fields' => ['bailt_no' => 210],
            ],
            [
                'name' => 'Niaz mamad',
                'date' => null,
                'total_items' => 3,
                'total_amount' => 10350,
                'net_profit' => 1725,
                'wasool' => 0,
                'extra_fields' => ['bailt_no' => 230],
            ],
            [
                'name' => 'reman',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 5280,
                'net_profit' => 1000,
                'wasool' => 0,
                'extra_fields' => ['bailt_no' => 165],
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create([
                'category' => 'bailt',
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
