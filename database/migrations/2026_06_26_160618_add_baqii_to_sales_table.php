<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if column exists before adding it
        if (!Schema::hasColumn('sales', 'baqii')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->decimal('baqii', 10, 2)->default(0)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('baqii');
        });
    }
};
