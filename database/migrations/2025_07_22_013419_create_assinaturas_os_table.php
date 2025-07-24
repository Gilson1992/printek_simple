<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Define a criação da tabela 'assinaturas_os'
        Schema::create('assinaturas_os', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incrementável

            // Cria a chave estrangeira para a tabela 'ordens_servico'
            $table->foreignId('ordem_servico_id')
                  ->constrained('ordens_servico')
                  ->onDelete('cascade'); // Se uma OS for deletada, a assinatura também será

            // Define o tipo de assinatura (ex: 'cliente', 'tecnico')
            $table->string('tipo', 50);

            // Armazena a imagem da assinatura em formato base64.
            // Usamos longText para garantir que assinaturas complexas caibam no campo.
            $table->longText('imagem_base64');

            // Colunas padrão do Laravel
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
            $table->softDeletes(); // Cria a coluna 'deleted_at' para exclusão suave
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Define como reverter a migration, ou seja, apagar a tabela
        Schema::dropIfExists('assinaturas_os');
    }
};