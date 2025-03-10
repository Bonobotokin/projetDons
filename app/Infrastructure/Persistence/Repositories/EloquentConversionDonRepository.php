<?php
// app/Infrastructure/Persistence/Repositories/EloquentConversionDonRepository.php
namespace App\Infrastructure\Persistence\Repositories;

use App\Domains\ConversionDon\Models\ConversionDon;
use App\Domains\ConversionDon\Repositories\ConversionDonRepository;

class EloquentConversionDonRepository implements ConversionDonRepository
{
    public function save(ConversionDon $conversionDon): void
    {
        $conversionDon->save();
    }

    public function findById(int $id): ?ConversionDon
    {
        return ConversionDon::find($id);
    }

    public function findAll(): array
    {
        return ConversionDon::all()->toArray();
    }

    public function delete(int $id): void
    {
        ConversionDon::destroy($id);
    }


    public function getDons($data)
    {
        $dons = ConversionDon::with('dons')
            ->where('budget_id', $data)
            ->get();

        return $dons->map(function ($conversionDon) {
            return [
                'id' => $conversionDon->id,
                'type_don' => $conversionDon->type_don,
                'choix' => $conversionDon->choix,
                'quantite' => $conversionDon->quantite,
                'valeur_unitaire' => $conversionDon->valeur_unitaire,
                'budget_id' => $conversionDon->budget_id,
                'dons' => $conversionDon->dons->map(function ($don) {
                    return [
                        'id' => $don->id,
                        'personnes' => $don->personnes,
                        'telephone' => $don->telephone,
                        'choix' => $don->choix,
                        'quantite' => $don->quantite,
                        'montant' => $don->montant,
                        'date_don' => $don->date_don,
                    ];
                }),
            ];
        });
    }

    public function getTypeChoixDons($data)
    {

        $dons = ConversionDon::select("choix")
            ->where('budget_id', $data)
            ->distinct()
            ->get();

            return $dons->map(function ($conversionDon) {
                return [
                    'choix' => $conversionDon->choix
                ];
            });
    }
    
}
