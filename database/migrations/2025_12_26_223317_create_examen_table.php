<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('examen', function (Blueprint $table) {
            $table->bigIncrements('id_examen');

            $table->decimal('puntaje_examen', 8, 2)->default(0);

            // Fecha en la que se rindió el examen
            $table->timestamp('fecha_examen')->useCurrent();

            // ⏱️ Duración total del examen en segundos
            // Ej: 1250 = 20 minutos y 50 segundos
            $table->integer('duracion_segundos')->default(0);

            // Estado (1 = activo, 0 = inactivo)
            $table->smallInteger('estado_examen')->default(1);

            // Usuario que rindió el examen
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')
                ->references('id_usuario')->on('usuario')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->index('id_usuario');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examen');
    }
};
