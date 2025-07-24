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
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            
            // Chave estrangeira para a tabela 'clientes'
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            $table->string('tipo', 50);
            $table->string('marca', 50);
            $table->string('modelo', 100);
            $table->string('serial', 100)->unique()->nullable();
            $table->integer('contador')->nullable();
            $table->string('tipo_posse', 20); // Ex: 'próprio', 'locado'
            $table->text('observacao')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};