<?php

namespace App\Domains\ConversionDon\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Budget\Models\Budget;
use App\Domains\Dons\Models\Don;

class ConversionDon extends Model
{
    protected $fillable = [
        'type_don',
        'choix',
        'quantite',
        'valeur_unitaire',
        'budget_id', // Ajout de budget_id pour la relation
    ];

    /**
     * Une conversion de don appartient à un budget.
     */
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function dons()
    {
        return $this->hasMany(Don::class, 'type_don');
    }
}
