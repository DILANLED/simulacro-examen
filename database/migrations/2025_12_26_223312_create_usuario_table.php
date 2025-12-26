<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->bigIncrements('id_usuario');

            $table->string('nombre_usuario', 150);
            $table->string('nombre_login_usuario', 100)->unique();
            $table->string('password_usuario');
            $table->smallInteger('estado_usuario')->default(1);

            $table->unsignedBigInteger('id_rol');
            $table->foreign('id_rol')
                ->references('id_rol')->on('rol')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
