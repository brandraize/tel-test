<?php

namespace Database\Seeders;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        foreach ($sales as $sale) {
            Sale::updateOrCreate([
                'name' => $sale['name'],
                'total_amount' => $sale['total_amount'],
            ], [
                'category' => $sale['category'] ?? 'gress',
                'name' => $sale['name'],
                'date' => $sale['date'] ? Carbon::createFromFormat('d/m/Y', $sale['date'])->format('Y-m-d') : null,
                'total_items' => $sale['total_items'],
                'total_amount' => $sale['total_amount'],
                'net_profit' => $sale['net_profit'],
                'wasool' => $sale['wasool'] ?? 0,
            ]);
        }
    }
}
