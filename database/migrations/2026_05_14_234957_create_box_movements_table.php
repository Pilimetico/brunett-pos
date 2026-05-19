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
        Schema::create('box_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('box_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('type'); // in, out (Gasto del día, Pago proveedor, Retiro admin, Devolución, etc)
            $table->string('reason');
            $table->string('person_involved')->nullable(); // Quién tomó el dinero o a quién se le dio
            $table->decimal('amount', 10, 2);
            $table->text('notes')->nullable();
            $table->string('evidence_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('box_movements');
    }
};
