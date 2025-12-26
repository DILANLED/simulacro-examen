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
        Schema::create('respuesta', function (Blueprint $table) {
            $table->bigIncrements('id_respuesta');

            $table->smallInteger('estado_respuesta')->default(1);

            $table->unsignedBigInteger('id_pregunta');
            $table->unsignedBigInteger('id_examen');
            $table->unsignedBigInteger('id_opcion');

            $table->foreign('id_pregunta')
                ->references('id_pregunta')->on('pregunta')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_examen')
                ->references('id_examen')->on('examen')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_opcion')
                ->references('id_opcion')->on('opcion')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->unique(['id_examen', 'id_pregunta']);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta');
    }
};
