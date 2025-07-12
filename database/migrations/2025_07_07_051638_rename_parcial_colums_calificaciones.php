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
        Schema::table('calificaciones_escolarizados', function (Blueprint $table) {
            $table->renameColumn('parcialp2', 'parcial2');
            $table->renameColumn('parcialp3', 'parcial3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calificaciones_escolarizados', function (Blueprint $table) {
            $table->renameColumn('parcial2', 'parcialp2');
            $table->renameColumn('parcial3', 'parcialp3');
        });
    }
};
