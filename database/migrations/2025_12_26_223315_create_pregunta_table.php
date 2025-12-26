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
        Schema::create('pregunta', function (Blueprint $table) {
            $table->bigIncrements('id_pregunta');

            $table->text('texto_pregunta');
            $table->smallInteger('estado_pregunta')->default(1);

            $table->unsignedBigInteger('id_area');
            $table->foreign('id_area')
                ->references('id_area')->on('area')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregunta');
    }
};
