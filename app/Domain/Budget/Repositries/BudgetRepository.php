<?php 
// app/Domains/Budget/Repositories/BudgetRepository.php
namespace App\Domains\Budget\Repositories;

use App\Domains\Budget\Models\Budget;

interface BudgetRepository
{
    public function save(Budget $budget): void;

    public function findById(int $id): ?Budget;

    public function findAll(): array;

    public function delete(int $id): void;
}
