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
        Schema::create('conversion_dons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id'); // Clé étrangère vers budgets
            $table->string('type_don');
            $table->decimal('valeur_unitaire', 10, 2)->default(0.00); // 10 chiffres au total, 2 chiffres après la virgule
            $table->timestamps();

            // Définition de la contrainte de clé étrangère
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversion_dons');
    }
};
