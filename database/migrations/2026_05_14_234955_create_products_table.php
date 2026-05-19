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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('sku')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->decimal('pvp1', 10, 2)->default(0); // Precio Normal
            $table->decimal('pvp2', 10, 2)->default(0); // Precio Cantidad
            $table->decimal('pvp3', 10, 2)->default(0); // Precio Mayorista
            $table->decimal('pvp4', 10, 2)->default(0); // Precio Socio Brunett
            $table->decimal('pvp5', 10, 2)->default(0);
            $table->decimal('pvp6', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->boolean('is_active')->default(true);
            $table->boolean('available_local')->default(true);
            $table->boolean('available_whatsapp')->default(true);
            $table->boolean('available_online')->default(true);
            $table->string('woocommerce_status')->default('borrador'); // borrador, publicado
            $table->string('image_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
