<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->foreignId('tecnico_id')->nullable()->constrained('tecnicos')->onDelete('set null');
            $table->dateTime('data_entrada');
            $table->dateTime('data_prevista')->nullable();
            $table->dateTime('data_conclusao')->nullable();
            $table->text('defeito_declarado');
            $table->text('defeito_encontrado')->nullable();
            $table->text('solucao')->nullable();
            $table->text('observacao_recebimento')->nullable();
            $table->text('observacao_servico')->nullable();
            $table->text('observacao_tecnico')->nullable();
            $table->integer('contador');
            $table->string('status', 20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordens_servico');
    }
};
