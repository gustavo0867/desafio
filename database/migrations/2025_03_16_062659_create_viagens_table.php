<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('viagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
            $table->integer('distancia')->nullable();
            $table->dateTime('data_hora_inicio');
            $table->dateTime('data_hora_chegada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viagens');
    }
};