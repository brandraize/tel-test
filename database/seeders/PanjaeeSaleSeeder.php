<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class PanjaeeSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'name' => 'Bad Shah',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 800,
                'net_profit' => 300,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'Shah moqim',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 800,
                'net_profit' => 300,
                'wasool' => 800, // Fully paid
            ],
            [
                'name' => 'Alam Zib',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 1600,
                'net_profit' => 600,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'Wahab',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 800,
                'net_profit' => 300,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'zahid', // First zahid
                'date' => null,
                'total_items' => 1,
                'total_amount' => 800,
                'net_profit' => 300,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'naiz',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 1600,
                'net_profit' => 600,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'zahid', // Second zahid
                'date' => null,
                'total_items' => 1,
                'total_amount' => 800,
                'net_profit' => 300,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'shafiq',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 800,
                'net_profit' => 300,
                'wasool' => 0, // Nothing paid
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create([
                'category' => 'panjaee',
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
