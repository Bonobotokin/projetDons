<?php

namespace Database\Seeders;

use App\Domains\Budget\Models\Budget;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifie si la table est vide avant d'insérer
        if (Budget::count() == 0) {
            Budget::create([
                'nom_projet' => 'Carreaux',
                'montant_total' => 10000.00,
                'montant_collecte' => 0.00,
                'reste_a_collecter' => 10000.00, // Correction logique
                'actif' => 'oui',
            ]);
        }
    }
}
