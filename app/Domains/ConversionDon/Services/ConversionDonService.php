<?php
namespace App\Domains\ConversionDon\Services;

use App\Domains\ConversionDon\Models\ConversionDon;
use App\Domains\ConversionDon\Repositories\ConversionDonRepository;
use Illuminate\Support\Facades\Log;

class ConversionDonService
{
    protected ConversionDonRepository $conversionDonRepository;

    public function __construct(ConversionDonRepository $conversionDonRepository)
    {
        $this->conversionDonRepository = $conversionDonRepository;
    }

    public function createConversionDon(array $data): ConversionDon
    {
        // Ajouter un log pour indiquer que la création a commencé
        Log::info('Début de la création du ConversionDon avec les données : ', $data);

        $conversionDon = new ConversionDon($data);
        $this->conversionDonRepository->save($conversionDon);  // Sauvegarde via le repository

        // Ajouter un log pour confirmer que l'enregistrement a été effectué
        Log::info('ConversionDon créé avec succès. ID : ' . $conversionDon->id);

        return $conversionDon;
    }

    public function getTotalValue(ConversionDon $conversionDon, int $quantity): float
    {
        // Ajouter un log pour suivre le calcul de la valeur totale
        Log::info('Calcul du total pour ConversionDon ID ' . $conversionDon->id . ' avec quantité : ' . $quantity);

        $total = $conversionDon->valeur_unitaire * $quantity;

        // Ajouter un log pour afficher le résultat du calcul
        Log::info('Total calculé : ' . $total);

        return $total;
    }
}
