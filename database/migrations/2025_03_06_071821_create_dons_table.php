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
        Schema::create('dons', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->string('personnes'); // Nom du donateur
            $table->string('telephone'); // Téléphone du donateur
            $table->date('date_don'); // Date du don
            $table->unsignedBigInteger('type_don'); // Clé étrangère vers 'conversion_dons'
            $table->string('choix'); // Quantité ou montant du don
            $table->decimal('quantite', 10, 2)->default(0.00); // Quantité 
            $table->decimal('montant', 10, 2)->default(0.00); // montant du don
            $table->timestamps();

            // Définition de la contrainte de clé étrangère
            $table->foreign('type_don')->references('id')->on('conversion_dons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dons');
    }
};
