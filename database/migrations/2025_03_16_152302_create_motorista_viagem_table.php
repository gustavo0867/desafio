<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('motorista_viagem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->constrained('motoristas')->onDelete('cascade');
            $table->foreignId('viagem_id')->constrained('viagens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motorista_viagem');
    }
};
