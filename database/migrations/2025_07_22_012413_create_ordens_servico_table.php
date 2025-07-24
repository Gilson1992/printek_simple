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
        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();

            // Chave estrangeira para a tabela 'clientes'
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            
            // Chave estrangeira para a tabela 'users' (assumindo que técnicos são usuários)
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('status', 30); // Ex: 'Aberta', 'Em atendimento', 'Aguardando Peças', 'Finalizada'
            $table->text('defeito_declarado');
            $table->text('defeito_encontrado')->nullable();
            $table->text('solucao')->nullable();
            $table->text('observacao')->nullable();
            
            $table->dateTime('data_abertura');
            $table->dateTime('data_fechamento')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordens_servico');
    }
};