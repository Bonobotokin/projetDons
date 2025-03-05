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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('nom_projet');
            $table->decimal('montant_total', 10, 2); // 10 chiffres au total, 2 chiffres après la virgule
            $table->decimal('montant_collecte', 10, 2); // 10 chiffres au total, 2 chiffres après la virgule
            $table->decimal('reste_a_collecter', 10, 2); // 10 chiffres au total, 2 chiffres après la virgule
            $table->string('actif');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
