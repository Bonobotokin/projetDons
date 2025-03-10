<?php 
namespace App\Domains\Dons\Repositories;

use App\Domains\Dons\Models\Don;

interface DonRepository
{
    public function save(Don $don): void;
    public function findById(int $id): ?Don;
    public function findAll(): array;

    public function getDons($data);

    public function getDonsWithTotals($budget_id);
}
