<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('cliente_nombre')->nullable(); // Por si es venta al público general sin registrarlo
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            $table->decimal('total', 10, 2);
            $table->string('metodo_pago'); // Efectivo, Yape, Plin, Transferencia
            $table->string('estado')->default('completada'); // completada, anulada
            $table->foreignId('user_id')->constrained('users'); // El vendedor que registró la venta
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};