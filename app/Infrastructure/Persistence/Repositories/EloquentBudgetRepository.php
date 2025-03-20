<?php
// app/Infrastructure/Persistence/Repositories/EloquentBudgetRepository.php

namespace  App\Infrastructure\Persistence\Repositories;

use App\Domains\Budget\Models\Budget;
use App\Domains\Budget\Repositories\BudgetRepository;

class EloquentBudgetRepository implements BudgetRepository
{
    public function save(Budget $budget): void
    {
        $budget->save();
    }

    public function findById(int $id): ?Budget
    {
        return Budget::find($id);
    }

    public function findByName(string $nom_projet): ?Budget
    {
        return Budget::where('nom_projet', $nom_projet)->first();
    }


    public function findAll(): array
    {
        return Budget::with('conversions')->get()->map(function ($budget) {

            return [
                'id' => $budget->id,
                'nom_projet' => $budget->nom_projet,
                'montant_total' => $budget->montant_total,
                'montant_collecte' => $budget->montant_collecte,
                'reste_a_collecter' => $budget->reste_a_collecter,
                'actif' => $budget->actif,
                'conversions' => $budget->conversions->map(function ($conversion) {
                    // Calcul du montant total selon le type de don
                    $montantTotal = ($conversion->choix === "Matériel") 
                        ? $conversion->quantite * $conversion->valeur_unitaire 
                        : $conversion->valeur_unitaire;
            
                    return [
                        'type_don' => $conversion->type_don,
                        'choix' => $conversion->choix,
                        'quantite' => $conversion->quantite,
                        'valeur_unitaire' => $conversion->valeur_unitaire,
                        'montant_total' => $montantTotal,
                    ];
                }),
            ];
        })->toArray();
    }



    public function deleteByName(string $nom_projet): void
    {
        Budget::where('nom_projet', $nom_projet)->delete();
    }
}
