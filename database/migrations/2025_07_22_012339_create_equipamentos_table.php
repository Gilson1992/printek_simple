<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('tipo', 50);
            $table->string('tipo_posse', 20);
            $table->string('marca', 50);
            $table->string('modelo', 100);
            $table->string('serial', 100)->unique()->nullable();
            $table->integer('contador')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};
