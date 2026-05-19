<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->boolean('allow_sales')->default(true);
            $table->boolean('allow_purchases')->default(true);
            $table->boolean('is_center_of_cost')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn(['allow_sales', 'allow_purchases', 'is_center_of_cost']);
        });
    }
};
