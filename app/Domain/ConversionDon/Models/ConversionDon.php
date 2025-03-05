<?php 
// app/Domains/ConversionDon/Models/ConversionDon.php
namespace App\Domains\ConversionDon\Models;

use Illuminate\Database\Eloquent\Model;

class ConversionDon extends Model
{
    protected $fillable = [
        'type_don',
        'valeur_unitaire',
    ];

    // Relations et méthodes métier si nécessaire
}
