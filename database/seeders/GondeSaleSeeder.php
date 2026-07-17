<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class GondeSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'name' => 'Shark',
                'date' => null,
                'total_items' => 10,
                'total_amount' => 600,
                'net_profit' => 160,
                'wasool' => 600, // Fully paid
            ],
            [
                'name' => 'abdul haq',
                'date' => null,
                'total_items' => 10,
                'total_amount' => 600,
                'net_profit' => 160,
                'wasool' => 600, // Fully paid
            ],
            [
                'name' => 'Roman',
                'date' => null,
                'total_items' => 100,
                'total_amount' => 6000,
                'net_profit' => 1600,
                'wasool' => 6000, // Fully paid
            ],
            [
                'name' => 'Wahab',
                'date' => null,
                'total_items' => 10,
                'total_amount' => 600,
                'net_profit' => 160,
                'wasool' => 600, // Fully paid
            ],
            [
                'name' => 'Iqbal',
                'date' => null,
                'total_items' => 36, // Fixed: was 18 in your code
                'total_amount' => 2160, // Fixed: was 1080 in your code
                'net_profit' => 576, // Fixed: was 288 in your code
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'Bad Shah',
                'date' => null,
                'total_items' => 20,
                'total_amount' => 1200,
                'net_profit' => 320,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'ibrar',
                'date' => null,
                'total_items' => 14,
                'total_amount' => 840,
                'net_profit' => 224,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'zahid', // Fixed: was 'iqbal' (duplicate)
                'date' => null,
                'total_items' => 10, // Fixed: was 18
                'total_amount' => 600, // Fixed: was 1080
                'net_profit' => 160, // Fixed: was 288
                'wasool' => 0, // Nothing paid
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create([
                'category' => 'gonde',
                'name' => $sale['name'],
                'date' => $sale['date'],
                'total_items' => $sale['total_items'],
                'total_amount' => $sale['total_amount'],
                'net_profit' => $sale['net_profit'],
                'wasool' => $sale['wasool'],
                // baqii is NOT included - model calculates it automatically!
            ]);
        }
    }
}
