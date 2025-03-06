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

    public function deleteBudgetByName(string $nom_projet): void
    {
        $this->budgetRepository->deleteByName($nom_projet);
    }
}
