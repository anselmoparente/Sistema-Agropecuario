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
        Schema::create('propriedades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('municipio');
            $table->char('uf', 2);
            $table->string('inscricao_estadual')->nullable();
            $table->decimal('area_total', 12, 2)->default(0);
            $table->foreignId('produtor_id')->constrained('produtores')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

            $table->index('produtor_id');
            $table->index(['municipio', 'uf']);
            $table->index('nome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propriedades');
    }
};
