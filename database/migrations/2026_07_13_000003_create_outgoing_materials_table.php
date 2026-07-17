<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outgoing_materials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('material_name');
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->date('date');
            $table->enum('payment_status', ['received', 'partial', 'not_received'])->default('not_received');
            $table->decimal('received_amount', 10, 2)->default(0);
            $table->date('due_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outgoing_materials');
    }
};
