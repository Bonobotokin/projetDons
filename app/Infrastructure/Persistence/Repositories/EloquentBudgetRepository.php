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

    public function findByName(string $nom_projet): Budget
    {
        return Budget::where('nom_projet', $nom_projet)->first();
    }

    public function findAll(): array
    {
        // Récupère tous les budgets avec leurs conversions de dons
        return Budget::with('conversions')->get()->toArray();
    }
    

    public function deleteByName(string $nom_projet): void
    {
        Budget::where('nom_projet', $nom_projet)->delete();
    }
}
