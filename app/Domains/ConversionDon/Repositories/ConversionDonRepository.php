<?php 
// app/Domains/ConversionDon/Repositories/ConversionDonRepository.php
namespace App\Domains\ConversionDon\Repositories;

use App\Domains\ConversionDon\Models\ConversionDon;

interface ConversionDonRepository
{
    public function save(ConversionDon $conversionDon): void;

    public function findById(int $id): ?ConversionDon;

    public function findAll(): array;

    public function delete(int $id): void;

    public function getDons($data);

    public function getTypeChoixDons($data);
}
