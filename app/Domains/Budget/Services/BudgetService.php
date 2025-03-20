<?php
// app/Domains/Budget/Services/BudgetService.php
namespace App\Domains\Budget\Services;

use App\Domains\Budget\Repositories\BudgetRepository;
use App\Domains\Budget\Models\Budget;
use Illuminate\Support\Facades\Log;

class BudgetService
{
    protected BudgetRepository $budgetRepository;

    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function createBudget(array $data): Budget
    {
        // Vérifier et afficher les données entrantes
        Log::info('Données reçues pour la création du budget : ', $data);

        // Créer l'objet Budget
        $budget = new Budget($data);

        // Vérification de l'objet Budget
        Log::info('Objet Budget créé : ', $budget->toArray()); // Utilisation de toArray pour mieux visualiser l'objet

        // Sauvegarde du budget dans la base de données
        $save = $this->budgetRepository->save($budget);

        // Vérification si l'enregistrement a réussi
        if ($save) {
            Log::info('Le budget a été sauvegardé avec succès.');
        } else {
            Log::error('Erreur lors de la sauvegarde du budget.');
        }

        // Retourner l'objet Budget (même s'il n'est pas encore sauvegardé)
        return $budget;
    }


    public function getBudgetById(int $id): ?Budget
    {
        return $this->budgetRepository->findById($id);
    }

    public function getBudgetByName(string $nom_projet): ?Budget
    {
        // Vérifier si le résultat est un objet ou un booléen
        $budget = $this->budgetRepository->findByName($nom_projet);
        return $budget ? $budget : null;
    }


    public function getAll(): array
    {
        return $this->budgetRepository->findAll();
    }

    public function navigation(): array
    {
        return Budget::with('conversions')
            ->get()
            ->filter(fn($budget) => strtolower($budget->actif) === 'actif') // Filtrage des budgets actifs
            ->map(function ($budget) {
                return [
                    'id' => $budget->id,
                    'nom_projet' => $budget->nom_projet,
                    'montant_total' => $budget->montant_total,
                    'montant_collecte' => $budget->montant_collecte,
                    'reste_a_collecter' => $budget->reste_a_collecter,
                    'actif' => $budget->actif,
                    'conversions' => $budget->conversions->map(function ($conversion) {
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
            })
            ->values() // Réindexe les clés après le filtrage
            ->toArray();
    }




    public function deleteBudgetByName(string $nom_projet): void
    {
        $this->budgetRepository->deleteByName($nom_projet);
    }

    public function updateBudget(int $id, float $data): ?Budget
    {


        // Récupérer le budget à mettre à jour
        $budget = $this->budgetRepository->findById($id);

        // Si le budget n'existe pas, retourner null
        if (!$budget) {
            Log::error('Le budget avec l\'ID ' . $id . ' n\'a pas été trouvé.');
            return null;
        }

        $collecter = (float) $budget->montant_collecte + $data;

        $montaAtteindre = (float) $budget->montant_total;

        $resteAfaire = (float) $montaAtteindre - $collecter;

        // Soustraire la valeur du champ 'montant' (ou tout autre champ nécessaire)
        $budget->montant_collecte = $collecter;
        $budget->montant_total = $montaAtteindre;
        $budget->reste_a_collecter = $resteAfaire;

        // Sauvegarder le budget mis à jour dans la base de données
        $budget->save();

        // Vérifier si la mise à jour a été effectuée
        Log::info('Budget mis à jour avec succès. ID : ' . $budget->id);

        // Retourner le budget mis à jour
        return $budget;
    }
}
