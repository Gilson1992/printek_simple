<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pecas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('os_id')->constrained('ordens_servicos')->onDelete('cascade');
            $table->string('descricao');
            $table->string('codigo');
            $table->string('quantidade');
            $table->string('unidade', 10)->nullable(); // Ex: 'pç', 'un', 'cx'
            $table->decimal('preco_unitario', 10, 2);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pecas');
    }
};
