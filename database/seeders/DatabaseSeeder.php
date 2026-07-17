<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MaterialSeeder::class,
            GressSaleSeeder::class,
            JaleeSaleSeeder::class,
            BailtSaleSeeder::class,
            GondeSaleSeeder::class,
            PanjaeeSaleSeeder::class,
            TaghareeSaleSeeder::class,
            SaberBandSaleSeeder::class,
            MaxKathaSaleSeeder::class,
        ]);
    }
}
