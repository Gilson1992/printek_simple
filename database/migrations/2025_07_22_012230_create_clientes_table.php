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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); // Equivalente a: id INT PRIMARY KEY AUTO_INCREMENT
            $table->string('nome'); // Equivalente a: VARCHAR(255)
            $table->string('cnpj', 18)->unique()->nullable(); // CNPJ único e opcional
            $table->string('contato', 100)->nullable(); // Contato opcional
            $table->string('email')->unique()->nullable(); // Email único e opcional
            $table->text('endereco')->nullable(); // Endereço opcional
            $table->text('observacao')->nullable(); // Observação opcional
            $table->boolean('ativo')->default(true); // Ativo por padrão
            $table->timestamps(); // Cria as colunas created_at e updated_at
            $table->softDeletes(); // Cria a coluna deleted_at para exclusão suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};