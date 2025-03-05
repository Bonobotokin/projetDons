<?php 
// app/Infrastructure/Persistence/Repositories/EloquentBudgetRepository.php
namespace App\Infrastructure\Persistence\Repositories;

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

    public function findAll(): array
    {
        return Budget::all()->toArray();
    }

    public function delete(int $id): void
    {
        Budget::destroy($id);
    }
}
