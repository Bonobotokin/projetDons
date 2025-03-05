<?php 
// app/Domains/Budget/Models/Budget.php
namespace App\Domains\Budget\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'nom_projet',
        'montant_total',
        'montant_collecte',
        'reste_a_collecter',
        'actif',
    ];

    // Relations et méthodes métier si nécessaire
}
