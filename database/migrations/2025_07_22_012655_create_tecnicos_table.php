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
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id();

            // Chave estrangeira que liga o técnico ao seu usuário de login
            $table->foreignId('tecnico_id')->nullable()->constrained('tecnicos')->onDelete('set null');

            $table->string('nome');
            $table->string('contato', 100)->nullable();
            $table->string('disponibilidade', 50)->nullable(); // Ex: 'Disponível', 'Em Atendimento'

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tecnicos');
    }
};