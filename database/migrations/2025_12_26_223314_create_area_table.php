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
        Schema::create('area', function (Blueprint $table) {
            $table->bigIncrements('id_area');

            $table->string('nombre_area', 150);
            $table->smallInteger('estado_area')->default(1);

            $table->unsignedBigInteger('id_carrera');
            $table->foreign('id_carrera')
                ->references('id_carrera')->on('carrera')
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
        Schema::dropIfExists('area');
    }
};
