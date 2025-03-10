<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domains\Dons\Models\Don;
use App\Domains\Dons\Repositories\DonRepository;
use Illuminate\Support\Facades\DB;

class EloquentDonsRepository implements DonRepository
{
    /**
     * Enregistrer un don
     *
     * @param Don $don
     * @return void
     */
    public function save(Don $don): void
    {

        $don->save();
    }

    /**
     * Trouver un don par ID
     *
     * @param int $id
     * @return Don|null
     */
    public function findById(int $id): ?Don
    {
        return Don::find($id); // Retourne null si le don n'est pas trouvé
    }

    /**
     * Trouver tous les dons
     *
     * @return array
     */
    public function findAll(): array
    {
        return Don::all()->toArray(); // Utilisation de all() pour récupérer toutes les entrées
    }

    public function getDons($data)
    {
        $dons = Don::with('conversion')
            ->whereHas('conversion', function ($query) use ($data) {
                $query->where('budget_id', $data);
            })
            ->get()
            ->map(function ($don) {
                // Transformation si nécessaire
                return [
                    'id' => $don->id,
                    'personnes' => $don->personnes,
                    'telephone' => $don->telephone,
                    'type_don' => $don->conversion->type_don,  // Exemple de relation
                    'choix' => $don->choix,  // Exemple de relation
                    'quantite' => $don->quantite,
                    'montant' => $don->montant,
                    'date_don' => $don->date_don,
                ];
            });

        return $dons;
    }


    public function getDonsWithTotals($budget_id)
{
    // Récupérer les totaux par type de don pour un budget donné
    $totals = DB::table('dons')
        ->join('conversion_dons', 'dons.type_don', '=', 'conversion_dons.id')
        ->select(
            'conversion_dons.type_don',
            DB::raw('SUM(dons.montant) as total_montant'),
            DB::raw('(SUM(conversion_dons.quantite) - SUM(dons.quantite)) as quantite_restante')
        )
        ->where('conversion_dons.budget_id', $budget_id)
        ->groupBy('conversion_dons.type_don')
        ->get();

    

    // Convertir le résultat en tableau associatif pour faciliter l'utilisation dans la vue
    $result = [];
    foreach ($totals as $row) {
        $result[$row->type_don] = [
            'total_montant'     => $row->total_montant,
            'quantite_restante' => $row->quantite_restante,
        ];
    }
    
    return $result;
}

}
