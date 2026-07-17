<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class JaleeSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'name' => 'Hussain Shah',
                'date' => null,
                'total_items' => 8.6,
                'total_amount' => 2150,
                'net_profit' => 602,
                'wasool' => 2150, // Fully paid
            ],
            [
                'name' => 'Farhad',
                'date' => null,
                'total_items' => 8,
                'total_amount' => 2000,
                'net_profit' => 560,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'Shafiq',
                'date' => null,
                'total_items' => 7.4,
                'total_amount' => 1850,
                'net_profit' => 518,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'Ikram',
                'date' => null,
                'total_items' => 7.3,
                'total_amount' => 1825,
                'net_profit' => 511,
                'wasool' => 1825, // Fully paid
            ],
            [
                'name' => 'Saqib',
                'date' => null,
                'total_items' => 7.6,
                'total_amount' => 1900,
                'net_profit' => 532,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'shakir',
                'date' => null,
                'total_items' => 14.8,
                'total_amount' => 3700,
                'net_profit' => 1036,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'shah moqim',
                'date' => null,
                'total_items' => 8.6,
                'total_amount' => 2150,
                'net_profit' => 602,
                'wasool' => 2150, // Fully paid
            ],
            [
                'name' => 'Niaz mamad',
                'date' => null,
                'total_items' => 25.8,
                'total_amount' => 6450,
                'net_profit' => 1806,
                'wasool' => 5000, // Partial payment (as shown in image)
            ],

        ];

        foreach ($sales as $sale) {
            Sale::create([
                'category' => 'jalee',
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
