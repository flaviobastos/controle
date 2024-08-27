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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contratos')->onDelete('cascade')->onUpdate('cascade');
            $table->date('vencimento');
            $table->string('parcela', 5);
            $table->string('responsavel', 30);
            $table->string('nota_fiscal', 5);
            $table->decimal('valor', 11, 2);
            $table->date('data_pagamento')->nullable();
            $table->date('data_manutencao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
