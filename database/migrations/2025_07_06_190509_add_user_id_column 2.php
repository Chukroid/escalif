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
        Schema::table('grupo_estudiantes', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users') // This automatically assumes 'courses' table and 'id' column
                ->onDelete('cascade')  // If a course is deleted, its entries in this pivot table are also deleted
                ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupo_estudiantes', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
