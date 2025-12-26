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
        Schema::create('opcion', function (Blueprint $table) {
            $table->bigIncrements('id_opcion');

            $table->text('texto_opcion');
            $table->smallInteger('es_correcta')->default(0); // 1 = correcta, 0 = incorrecta
            $table->smallInteger('estado_opcion')->default(1);

            $table->unsignedBigInteger('id_pregunta');
            $table->foreign('id_pregunta')
                ->references('id_pregunta')->on('pregunta')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opcion');
    }
};
