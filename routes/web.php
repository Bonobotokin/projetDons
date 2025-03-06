<?php

use App\Domains\Budget\Controllers\BudgetController;
use App\Domains\ConversionDon\Controllers\ConversionDonController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BudgetController::class, 'redirect'])->name('redirection'); // Redirige vers le premier budget
Route::get('/parametres', [BudgetController::class, 'parametres'])->name('parametres');

Route::prefix('projets')->group(function () {
    Route::get('/', [BudgetController::class, 'index'])->name('budgets.index');  // Liste des projets
    Route::post('/', [BudgetController::class, 'store'])->name('budgets.store');  // Action pour stocker un projet
    Route::post('/save_dons', [ConversionDonController::class, 'store'])->name('dons.store');  // Action pour stocker un projet
    Route::get('/{nom_projet}', [BudgetController::class, 'show'])->name('budgets.show'); // Voir les détails d'un projet
    Route::delete('/{nom_projet}', [BudgetController::class, 'destroy'])->name('budgets.destroy'); // Supprimer un projet
});
