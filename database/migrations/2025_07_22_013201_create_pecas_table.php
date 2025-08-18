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
            $table->text('descricao')->nullable();
            $table->string('codigo')->nullable();
            $table->integer('quantidade')->default(0);
            $table->string('unidade', 10)->nullable(); // Ex: 'pç', 'un', 'cx'
            $table->decimal('preco', 10, 2)->nullable();
            $table->boolean('ativo')->default(true); // controle de estoque
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pecas');
    }
};
