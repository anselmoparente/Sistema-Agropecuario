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
        Schema::create('produtores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf_cnpj', 20)->unique();
            $table->string('telefone', 20)->nullable();
            $table->string('email')->nullable()->unique();
            $table->text('endereco')->nullable();
            $table->date('data_cadastro')->nullable();
            $table->timestamps();

            $table->index('nome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtores');
    }
};
