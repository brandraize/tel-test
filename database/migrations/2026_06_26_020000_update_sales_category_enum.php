<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Skip this migration for SQLite
        // SQLite doesn't support ENUM or MODIFY

        // For MySQL, uncomment below
        // DB::statement("ALTER TABLE `sales` MODIFY `category` ENUM('gress','jalee','bailt','gonde','panjaee','tagharee','saber_band','max_katha') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip for SQLite
    }
};
