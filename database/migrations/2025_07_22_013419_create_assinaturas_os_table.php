<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // public function up()
    // {
    //     Schema::create('assinaturas_os', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('ordem_servico_id')->constrained('ordem_servicos')->onDelete('cascade');
    //         $table->string('tipo', 50);
    //         $table->longText('imagem_base64');
    //         $table->timestamps();
    //         $table->softDeletes();
    //     });
    // }

    // public function down()
    // {
    //     Schema::dropIfExists('assinaturas_os');
    // }
};
