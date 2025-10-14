<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**A
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rebanhos', function (Blueprint $table) {
            $table->id();
            $table->string('especie');
            $table->unsignedInteger('quantidade')->default(0);
            $table->string('finalidade')->nullable();
            $table->date('data_atualizacao')->nullable();
            $table->foreignId('propriedade_id')->constrained('propriedades')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

            $table->index(['especie']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rebanhos');
    }
};
