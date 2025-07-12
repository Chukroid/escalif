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
        Schema::create('calificaciones_escolarizados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users') // This automatically assumes 'courses' table and 'id' column
                  ->onDelete('cascade');  // If a course is deleted, its entries in this pivot table are also deleted
            $table->foreignId('curso_id')
                  ->constrained('cursos') // This automatically assumes 'courses' table and 'id' column
                  ->onDelete('cascade');  // If a course is deleted, its entries in this pivot table are also deleted
            $table->unsignedTinyInteger('semestre');
            $table->foreignId('materia_id')
                  ->constrained('materias') // This automatically assumes 'courses' table and 'id' column
                  ->onDelete('cascade');  // If a course is deleted, its entries in this pivot table are also deleted

            $table->decimal('parcial1', 3, 1);
            $table->decimal('parcialp2', 3, 1);
            $table->decimal('parcialp3', 3, 1);
            $table->decimal('final', 3, 1);
            $table->decimal('extra', 3, 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones_escolarizados');
    }
};
