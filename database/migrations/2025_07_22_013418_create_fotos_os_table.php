<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // public function up(): void
    // {
    //     Schema::create('fotos_os', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('ordem_servico_id')->constrained('ordem_servicos')->onDelete('cascade');
    //         $table->string('caminho_arquivo');
    //         $table->string('legenda')->nullable();
    //         $table->timestamps();
    //         $table->softDeletes();
    //     });
    // }

    // public function down(): void
    // {
    //     Schema::dropIfExists('fotos_os');
    // }
};
