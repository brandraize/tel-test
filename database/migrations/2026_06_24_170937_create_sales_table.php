// database/migrations/2024_01_01_000001_create_sales_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->enum('category', [
                'gress', 'jalee', 'bailt', 'gonde',
                'panjaee', 'tagharee', 'saber_band', 'max_katha'
            ]);
            $table->string('name'); // Customer name
            $table->date('date')->nullable(); // Sale date
            $table->decimal('total_items', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->decimal('net_profit', 15, 2);
            $table->decimal('wasool', 15, 2)->default(0); // Amount collected
            $table->decimal('baqii', 15, 2)->storedAs('total_amount - wasool'); // Pending
            $table->json('extra_fields')->nullable(); // Additional fields
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
