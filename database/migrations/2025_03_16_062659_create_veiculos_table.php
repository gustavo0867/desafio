<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->integer('ano');
            $table->date('data_aquisicao');
            $table->integer('km_atual');
            $table->integer('km_aquisicao');
            $table->string('renavam')->unique();
            $table->string('placa')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
