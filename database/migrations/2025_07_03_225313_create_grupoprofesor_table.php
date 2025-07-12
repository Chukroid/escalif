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
        Schema::create('grupoprofesor', function (Blueprint $table) {
            $table->id();

            $table->foreignId('curso_id')
                  ->constrained('cursos') // This automatically assumes 'courses' table and 'id' column
                  ->onDelete('cascade');  // If a course is deleted, its entries in this pivot table are also deleted

            $table->foreignId('materia_id')
                  ->constrained('materias') // This automatically assumes 'courses' table and 'id' column
                  ->onDelete('cascade');  // If a course is deleted, its entries in this pivot table are also deleted

            $table->foreignId('profesor_id')
                  ->constrained('users') // This automatically assumes 'courses' table and 'id' column
                  ->onDelete('cascade');  // If a course is deleted, its entries in this pivot table are also deleted
            
            $table->unsignedTinyInteger('semestre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupoprofesor');
    }
};
