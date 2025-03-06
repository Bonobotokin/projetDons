<?php

namespace App\Domains\Budget\Models;

use App\Domains\ConversionDon\Models\ConversionDon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    protected $fillable = [
        'nom_projet',
        'montant_total',
        'montant_collecte',
        'reste_a_collecter',
        'actif',
    ];

    /**
     * Un budget peut avoir plusieurs conversions de dons.
     */
    public function conversions(): HasMany
    {
        return $this->hasMany(ConversionDon::class, 'budget_id');
    }
}
