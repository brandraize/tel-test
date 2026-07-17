<?php

namespace Database\Seeders;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GressSaleSeeder extends Seeder
{
    public function run(): void
    {
        $sales = [
            [
                'name' => 'Abullah',
                'date' => '2026-05-15',
                'total_items' => 13,
                'total_amount' => 18200,
                'net_profit' => 1625,
                'wasool' => 18200, // Fully paid
            ],
            [
                'name' => 'Roman',
                'date' => '2026-05-16',
                'total_items' => 10,
                'total_amount' => 14000,
                'net_profit' => 1250,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'Ifthar',
                'date' => '2026-05-17',
                'total_items' => 13,
                'total_amount' => 18200,
                'net_profit' => 1625,
                'wasool' => 10000, // Partial payment
            ],
            [
                'name' => 'Badshah said',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 2400,
                'net_profit' => 250,
                'wasool' => 2400, // Fully paid
            ],
            [
                'name' => 'Wahab',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 1400,
                'net_profit' => 125,
                'wasool' => 1400, // Fully paid
            ],
            [
                'name' => 'Shafiq',
                'date' => null,
                'total_items' => 7,
                'total_amount' => 9800,
                'net_profit' => 875,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'farhad',
                'date' => null,
                'total_items' => 5,
                'total_amount' => 7000,
                'net_profit' => 625,
                'wasool' => 7000, // Fully paid
            ],
            [
                'name' => 'Zahid',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 2800,
                'net_profit' => 250,
                'wasool' => 2800, // Fully paid
            ],
            [
                'name' => 'Ibrar',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 1400,
                'net_profit' => 125,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'Ikram',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 2800,
                'net_profit' => 250,
                'wasool' => 2800, // Fully paid
            ],
            [
                'name' => 'Ali Abas',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 2800,
                'net_profit' => 250,
                'wasool' => 2800, // Fully paid (your image shows 2800)
            ],
            [
                'name' => 'Shakir',
                'date' => null,
                'total_items' => 2,
                'total_amount' => 2800,
                'net_profit' => 250,
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'Shah Moqim',
                'date' => null,
                'total_items' => 1,
                'total_amount' => 1400,
                'net_profit' => 125,
                'wasool' => 1400, // Fully paid
            ],
            [
                'name' => 'Niaz mamad',
                'date' => null,
                'total_items' => 7,
                'total_amount' => 10150,
                'net_profit' => 875, // Fixed: was 3500 in your code
                'wasool' => 0, // Nothing paid
            ],
            [
                'name' => 'iqbal said',
                'date' => null,
                'total_items' => 6,
                'total_amount' => 8700,
                'net_profit' => 750,
                'wasool' => 0, // Nothing paid
            ],
              [
                'name' => 'iqbal said',
                'date' => null,
                'total_items' => 5,
                'total_amount' => 7250,
                'net_profit' => 625,
                'wasool' => 0, // Nothing paid
            ],
        ];

        foreach ($sales as $sale) {
            Sale::create([
                'category' => 'gress',
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
