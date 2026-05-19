<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authorization_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Solicitor
            $table->string('action'); // e.g., 'apply_discount', 'change_price'
            $table->string('module'); // e.g., 'POS'
            $table->text('motive');
            $table->json('data')->nullable(); // Original values and requested values
            $table->enum('status', ['pending', 'approved', 'denied', 'expired'])->default('pending');
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->text('response_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorization_requests');
    }
};
