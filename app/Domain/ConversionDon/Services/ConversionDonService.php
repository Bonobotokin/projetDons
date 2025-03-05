<?php 
// app/Domains/ConversionDon/Services/ConversionDonService.php
namespace App\Domains\ConversionDon\Services;

use App\Domains\ConversionDon\Models\ConversionDon;

class ConversionDonService
{
    public function createConversionDon(array $data): ConversionDon
    {
        return ConversionDon::create($data);
    }

    public function getTotalValue(ConversionDon $conversionDon, int $quantity): float
    {
        return $conversionDon->valeur_unitaire * $quantity;
    }
}
