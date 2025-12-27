<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examen', function (Blueprint $table) {

            // 1️⃣ Renombrar columna
            $table->renameColumn('duracion_segundos', 'duracion');

            // 2️⃣ Agregar FK a carrera
            $table->unsignedBigInteger('id_carrera')->after('duracion');

            $table->foreign('id_carrera')
                  ->references('id_carrera')
                  ->on('carrera')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->index('id_carrera');
        });
    }

    public function down(): void
    {
        Schema::table('examen', function (Blueprint $table) {

            $table->dropForeign(['id_carrera']);
            $table->dropIndex(['id_carrera']);
            $table->dropColumn('id_carrera');

            $table->renameColumn('duracion', 'duracion_segundos');
        });
    }
};
