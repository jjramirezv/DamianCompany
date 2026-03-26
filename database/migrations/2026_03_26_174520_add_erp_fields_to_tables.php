<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agregamos los campos a la tabla productos
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('precio_compra', 10, 2)->nullable()->after('codigo');
            $table->decimal('precio_docena', 10, 2)->nullable()->after('precio');
            $table->integer('stock_min')->default(5)->after('stock');
            $table->boolean('estado')->default(true)->after('destacado'); // true = Activo, false = Inactivo
            $table->text('especificaciones')->nullable()->after('descripcion');
        });

        // 2. Agregamos los campos de auditoría al Kardex
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->integer('stock_antes')->nullable()->after('cantidad');
            $table->integer('stock_despues')->nullable()->after('stock_antes');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['precio_compra', 'precio_docena', 'stock_min', 'estado', 'especificaciones']);
        });

        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropColumn(['stock_antes', 'stock_despues']);
        });
    }
};