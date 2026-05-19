<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('commission_percentage', 5, 2)->default(0);
            $table->decimal('charge_percentage', 5, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed basic methods from PDF 1
        DB::table('payment_methods')->insert([
            ['name' => 'Efectivo', 'slug' => 'cash', 'commission_percentage' => 0, 'charge_percentage' => 0],
            ['name' => 'Transferencia', 'slug' => 'transfer', 'commission_percentage' => 0, 'charge_percentage' => 0],
            ['name' => 'Tarjeta de Crédito', 'slug' => 'credit_card', 'commission_percentage' => 4, 'charge_percentage' => 0],
            ['name' => 'PayPhone', 'slug' => 'payphone', 'commission_percentage' => 6, 'charge_percentage' => 0],
            ['name' => 'DeUna', 'slug' => 'deuna', 'commission_percentage' => 0, 'charge_percentage' => 0],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
