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
        // Primero borramos la columna problemática
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });

        // Luego la volvemos a crear como TEXT y permitiendo que quede vacía (nullable)
        Schema::table('productos', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('codigo');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->string('descripcion')->nullable()->after('codigo');
        });
    }
};
