<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('area', function (Blueprint $table) {
            $table->integer('n_preguntas')
                  ->default(0)
                  ->after('nombre_area');
        });
    }

    public function down(): void
    {
        Schema::table('area', function (Blueprint $table) {
            $table->dropColumn('n_preguntas');
        });
    }
};
