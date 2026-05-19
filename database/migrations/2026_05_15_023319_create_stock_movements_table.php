<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('warehouse_id')->nullable()->constrained();
            $table->enum('type', ['in', 'out', 'transfer']);
            $table->string('reason'); // 'sale', 'purchase', 'adjustment', 'transfer'
            $table->decimal('quantity', 15, 2);
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->foreignId('user_id')->constrained();
            $table->string('reference_type')->nullable(); // 'Sale', 'Purchase', etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
