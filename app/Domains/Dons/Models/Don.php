<?php 
namespace App\Domains\Dons\Models;

use App\Domains\ConversionDon\Models\ConversionDon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Don extends Model
{
    protected $fillable = [
        'personnes',
        'telephone',
        'type_don',
        'choix',
        'quantite',
        'montant',
        'date_don',
    ];

    /**
     * Un don appartient à une conversion de don.
     */
    public function conversion(): BelongsTo
    {
        return $this->belongsTo(ConversionDon::class, 'type_don');
    }
}
