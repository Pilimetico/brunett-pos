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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('normal'); // normal, socio_brunett
            $table->string('document_number')->unique()->nullable(); // Cédula/RUC
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->text('address')->nullable();
            
            // Socio Brunett Fields
            $table->boolean('is_member_active')->default(false);
            $table->date('membership_expires_at')->nullable();
            
            // Credit Fields
            $table->boolean('has_credit')->default(false);
            $table->decimal('credit_limit', 10, 2)->default(0);
            $table->decimal('credit_used', 10, 2)->default(0);
            
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
