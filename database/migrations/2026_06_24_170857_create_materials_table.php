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
        Schema::create('materials', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('item_name'); // Material name
            $table->text('description')->nullable(); // Description (optional)
            $table->integer('no_of_items'); // Number of items
            $table->decimal('price', 15, 2); // Price per item
            $table->date('date')->nullable(); // Purchase date
            $table->decimal('total_cost', 15, 2)->storedAs('no_of_items * price'); // Auto-calculated
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reve$e the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
