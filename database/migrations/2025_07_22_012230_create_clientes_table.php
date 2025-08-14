<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->char('cnpj', 14)->unique()->nullable();
            $table->char('contato', 11)->nullable();
            $table->string('email', 180)->unique()->nullable();
            $table->string('endereco', 255)->nullable();
            $table->text('observacao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
