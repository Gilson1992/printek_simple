<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordens_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('servico_id')->nullable()->constrained('servicos')->onDelete('set null');
            $table->foreignId('peca_id')->nullable()->constrained('pecas')->onDelete('set null');
            $table->dateTime('data_abertura');
            $table->dateTime('data_prevista');
            $table->dateTime('data_fechamento')->nullable();
            $table->text('defeito_declarado');
            $table->text('defeito_encontrado')->nullable();
            $table->text('solucao')->nullable();
            $table->text('observacao_recebimento')->nullable();
            $table->text('observacao_servico')->nullable();
            $table->text('observacao_tecnica')->nullable();
            $table->string('status', 20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordens_servicos');
    }
};
