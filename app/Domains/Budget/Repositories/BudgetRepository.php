<?php

namespace App\Domains\Budget\Repositories;

use App\Domains\Budget\Models\Budget;

interface BudgetRepository
{
    public function save(Budget $budget): void;

    public function findById(int $id): ?Budget;

    public function findByName(string $nom_projet): Budget;

    public function findAll(): array;

    public function deleteByName(string $nom_projet): void;
}
