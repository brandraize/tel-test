<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class TaghareeSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'name' => 'Ali Abas',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 400,
                'net_profit' => 210,
                'wasool' => 400, // Fully paid
            ],
            [
                'name' => 'Qaser',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 400,
                'net_profit' => 210,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'shark',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 400,
                'net_profit' => 420,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'naiz',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 400,
                'net_profit' => 0, // No profit listed
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'shafiq',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 400,
                'net_profit' => 0, // No profit listed
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'iqbal said',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 400,
                'net_profit' => 0, // No profit listed
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'nasir',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 400,
                'net_profit' => 0, // No profit listed
                'wasool' => 0, // Nothing paid
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create([
                'category' => 'tagharee',
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
