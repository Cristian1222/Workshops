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
    Schema::create('matriculas', function (Blueprint $table) {
        $table->id();
        $table->string('estudiante', 150);
        $table->string('identificacion', 30);
        $table->string('correo', 150);
        $table->foreignId('curso_id')
            ->constrained('cursos')
            ->restrictOnDelete();
        $table->date('fecha');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
