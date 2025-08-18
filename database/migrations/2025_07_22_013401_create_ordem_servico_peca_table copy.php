<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordem_servico_peca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_servico_id')->constrained('ordens_servico')->onDelete('cascade');
            $table->foreignId('peca_id')->constrained('pecas')->onDelete('restrict');
            $table->unique(['ordem_servico_id', 'peca_id']);
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 10, 2);
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordem_servico_peca');
    }
};
