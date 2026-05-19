<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->enum('channel', ['whatsapp', 'online', 'local'])->default('whatsapp');
            $table->string('status')->default('created'); // created, pending_payment, paid, preparing, shipped, etc
            $table->decimal('total', 15, 2);
            $table->text('notes')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('shipping_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
