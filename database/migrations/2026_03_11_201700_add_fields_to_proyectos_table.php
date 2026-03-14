<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('titulo');
            $table->string('imagen')->nullable()->after('descripcion');
            $table->text('codigo_embed')->nullable()->change(); // Permite que el video quede vacío si sube foto
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropColumn(['descripcion', 'imagen']);
        });
    }
};