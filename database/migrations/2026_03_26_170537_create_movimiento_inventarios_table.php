<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->enum('tipo', ['ingreso', 'salida']);
            $table->integer('cantidad');
            $table->string('motivo'); // 'Venta #1', 'Compra a proveedor', 'Ajuste por daño'
            $table->foreignId('user_id')->constrained('users'); // Quién hizo el movimiento
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};