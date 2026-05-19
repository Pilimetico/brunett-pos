<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Seed basic settings from PDF 1
        DB::table('settings')->insert([
            ['key' => 'company_name', 'value' => 'Brunett Ecuador', 'group' => 'company', 'description' => 'Nombre de la empresa'],
            ['key' => 'company_ruc', 'value' => '', 'group' => 'company', 'description' => 'RUC de la empresa'],
            ['key' => 'annual_goal', 'value' => '120000', 'group' => 'goals', 'description' => 'Meta de venta anual'],
            ['key' => 'daily_goal', 'value' => '1000', 'group' => 'goals', 'description' => 'Meta de venta diaria'],
            ['key' => 'iva_percentage', 'value' => '15', 'group' => 'tax', 'description' => 'Porcentaje de IVA vigente'],
            ['key' => 'membership_cost', 'value' => '10', 'group' => 'membership', 'description' => 'Costo membresía Socio Brunett'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
