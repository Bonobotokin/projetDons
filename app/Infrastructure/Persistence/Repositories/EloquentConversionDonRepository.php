<?php 
// app/Infrastructure/Persistence/Repositories/EloquentConversionDonRepository.php
namespace App\Infrastructure\Persistence\Repositories;

use App\Domains\ConversionDon\Models\ConversionDon;
use App\Domains\ConversionDon\Repositories\ConversionDonRepository;

class EloquentConversionDonRepository implements ConversionDonRepository
{
    public function save(ConversionDon $conversionDon): void
    {
        $conversionDon->save();
    }

    public function findById(int $id): ?ConversionDon
    {
        return ConversionDon::find($id);
    }

    public function findAll(): array
    {
        return ConversionDon::all()->toArray();
    }

    public function delete(int $id): void
    {
        ConversionDon::destroy($id);
    }
}
