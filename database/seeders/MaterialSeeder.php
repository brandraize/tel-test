<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        Material::truncate();

        $materials = [
            [
                'item_name' => 'Gress katan',
                'description' => 'for Services',
                'no_of_items' => 4,
                'price' => 4200, // Per item price
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Bailt',
                'description' => '195',
                'no_of_items' => 12,
                'price' => 2437,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Bailt',
                'description' => '210',
                'no_of_items' => 10,
                'price' => 2625,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Bailt',
                'description' => '200',
                'no_of_items' => 12,
                'price' => 2500,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Bailt',
                'description' => '185',
                'no_of_items' => 6,
                'price' => 2312,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Bailt',
                'description' => '180',
                'no_of_items' => 6,
                'price' => 2250,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Bailt',
                'description' => '205',
                'no_of_items' => 6,
                'price' => 2562,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Bailt',
                'description' => '240',
                'no_of_items' => 3,
                'price' => 3000,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Bailt',
                'description' => '255',
                'no_of_items' => 5,
                'price' => 3187,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Farhad Bering',
                'description' => 'bering no 4314',
                'no_of_items' => 1,
                'price' => 8200,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => '2 jali bandal',
                'description' => '18000',
                'no_of_items' => 2,
                'price' => 18000,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Gress katan',
                'description' => '25500',
                'no_of_items' => 20,
                'price' => 1275,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'bering',
                'description' => 'imam said',
                'no_of_items' => 1,
                'price' => 11000,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Gonde',
                'description' => '25 kg',
                'no_of_items' => 20,
                'price' => 1275,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'pataha',
                'description' => '15700',
                'no_of_items' => 1,
                'price' => 15700,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'balit c 265',
                'description' => '6625+500',
                'no_of_items' => 1,
                'price' => 7125,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Gress katan',
                'description' => '25500',
                'no_of_items' => 20,
                'price' => 1275,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Gress katan',
                'description' => '51000',
                'no_of_items' => 40,
                'price' => 1275,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'tagaree',
                'description' => '10',
                'no_of_items' => 10,
                'price' => 210,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'pange',
                'description' => '5',
                'no_of_items' => 5,
                'price' => 500,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Gonde',
                'description' => '7150',
                'no_of_items' => 1, // FIXED: Changed from 170 to 1
                'price' => 7150,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'saber bande',
                'description' => '1050',
                'no_of_items' => 10,
                'price' => 105,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'polie',
                'description' => '4700+350',
                'no_of_items' => 1,
                'price' => 5050,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'Balit',
                'description' => '230',
                'no_of_items' => 1,
                'price' => 8975,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'bailt',
                'description' => '165',
                'no_of_items' => 1,
                'price' => 8600.52,
                'date' => '2026-05-15',
            ],
            [
                'item_name' => 'panja',
                'description' => 'panjii bandal',
                'no_of_items' => 1,
                'price' => 18000,
                'date' => '2026-05-15',
            ],

               [
                'item_name' => 'Jalee Lesen',
                'description' => 'Jalee bandal for Lesen khan ',
                'no_of_items' => 1,
                'price' => 18500,
                'date' => '2026-05-15',
            ],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}
