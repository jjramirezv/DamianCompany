<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->json('imagenes')->nullable()->after('imagen');
            $table->string('video_url', 500)->nullable()->after('imagenes');
        });

        DB::table('proyectos')
            ->whereNotNull('imagen')
            ->orderBy('id')
            ->eachById(function ($proyecto) {
                DB::table('proyectos')
                    ->where('id', $proyecto->id)
                    ->update([
                        'imagenes' => json_encode([$proyecto->imagen]),
                        'imagen' => null,
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropColumn(['imagenes', 'video_url']);
        });
    }
};
