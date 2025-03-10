<?php

namespace App\Domains\Dons\Services;

use App\Domains\Dons\Repositories\DonRepository;
use App\Domains\Dons\Models\Don;
use Illuminate\Support\Facades\Log;

class DonsService
{
    private DonRepository $donRepository;

    public function __construct(DonRepository $donRepository)
    {
        $this->donRepository = $donRepository;
    }

    /**
     * Créer un nouveau don
     *
     * @param array $data
     * @return Don
     */
    public function createDon($data, $montant): Don
    {
        
        // Si $data est une instance de Request, on le convertit en tableau
        if ($data instanceof \Illuminate\Http\Request) {
            $data = $data->all();
        }

        Log::info('Création du don avec les données : ', $data);

        // Validation des données du don
        $validate = $this->validateDonData($data);
        
        // Vérifier si la clé 'choix' est présente et si sa valeur est 'quantite'
        if (isset($data['choix']) && $data['choix'] === "Matériel") {
            // Validation des autres champs nécessaires
            
            if (isset($data['quantite']) && isset($data['personnes']) && isset($data['telephone'])) {
                
                $don = new Don([
                    'personnes' => $data['personnes'],
                    'telephone' => $data['telephone'],
                    'type_don' => $data['type_don'],
                    'quantite' => $data['quantite'],
                    'montant' =>  $montant, // S'assurer que montant est défini
                    'choix' => $data['choix'],
                    'date_don' => $data['date_don'] ?? now(), // Utilisation de la date actuelle si non spécifiée
                ]);

                
            } else {
                Log::error('Données manquantes pour la création du don : personnes, telephone ou quantite');
                throw new \InvalidArgumentException('Les données requises sont manquantes.');
            }
        } else {
        
            
            $don = new Don([
                'personnes' => $data['personnes'],
                'telephone' => $data['telephone'],
                'type_don' => $data['type_don'],
                'quantite' => 0,
                'montant' =>  $montant, // S'assurer que montant est défini
                'choix' => $data['choix'],
                'date_don' => $data['date_don'] ?? now(), // Utilisation de la date actuelle si non spécifiée
            ]);
        }
        
        $this->donRepository->save($don);

        Log::info('Don créé avec succès. ID : ' . $don->id);

        return $don;
    }


    /**
     * Valider les données d'un don
     *
     * @param array $data
     * @return void
     */
    private function validateDonData(array $data): void
    {
        
        if (empty($data['personnes']) || empty($data['type_don'])) {
            throw new \InvalidArgumentException('Les données du don sont invalides.');
        }
    }

    /**
     * Calculer le total d'un don
     *
     * @param Don $don
     * @return float
     */
    public function calculateTotal(Don $don): float
    {
        // Si la logique de calcul doit être ajustée (le calcul précédent utilisait la multiplication de deux champs), 
        // vous pouvez soit supprimer cette méthode, soit la modifier pour retourner la valeur directement.
        return $don->quantite;
    }

    public function getDonsByIdBudget($data)
    {

        return $this->donRepository->getDons($data);
    }


    public function getDonsWithTotals($id)
    {

        return $this->donRepository->getDonsWithTotals($id);

    }
}
