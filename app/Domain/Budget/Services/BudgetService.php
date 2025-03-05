<?php 
// app/Domains/Budget/Services/BudgetService.php
namespace App\Domains\Budget\Services;

use App\Domains\Budget\Models\Budget;

class BudgetService
{
    public function createBudget(array $data): Budget
    {
        return Budget::create($data);
    }

    public function calculateRemainingAmount(Budget $budget): float
    {
        return $budget->montant_total - $budget->montant_collecte;
    }
}
