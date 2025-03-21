<?php

namespace App\Domains\ConversionDon\Controllers;

use App\Domains\Budget\Models\Budget;
use App\Domains\ConversionDon\Services\ConversionDonService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  // Assurez-vous d'utiliser cette classe
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConversionDonController extends Controller
{
    protected ConversionDonService $conversion_don_service;

    public function __construct(ConversionDonService $conversion_don_service)
    {
        $this->conversion_don_service = $conversion_don_service;
    }

    public function store(Request $request)
    {
        // Valider les données de la requête
        $validated = $request->validate([
            'budget_id' => 'required|exists:budgets,id',
            'type_don' => 'required|string|max:255',
            'choix' => 'required|string|max:255',
            'valeur_unitaire' => 'required',
            'quantite' => 'required|numeric|min:0',
        ], [
            'type_don.required' => 'Le nom du projet est requis.',
            'valeur_unitaire.required' => 'Le montant total est requis.',
            'valeur_unitaire.numeric' => 'Le montant total doit être un nombre.',
            'valeur_unitaire.min' => 'Le montant total ne peut pas être inférieur à 0.',
        ]);
        
        // Commencer une transaction
        DB::beginTransaction();

        try {
            // Créer une nouvelle conversion de don

            // Nettoyer le montant_total pour supprimer les séparateurs
            $validated['valeur_unitaire'] = str_replace(',', '', $validated['valeur_unitaire']); // Supprime les virgules
            $validated['valeur_unitaire'] = floatval($validated['valeur_unitaire']);

            $conversionDon = $this->conversion_don_service->createConversionDon($validated);


            $getBudget = Budget::where('id', $conversionDon["budget_id"])->first();

            $getBudget->actif = "Actif";

            $getBudget->save();
            // Logique supplémentaire si nécessaire (ex: enregistrement d'autres données)

            // Si tout se passe bien, on valide la transaction
            DB::commit();

            // Retourner un message de succès avec les informations du don créé
            return redirect()->route('parametres')
                ->with('success', 'Le projet a été créé avec succès!')
                ->with('dons', $conversionDon);
        } catch (\Exception $e) {
            dd($e);
            // Si une erreur se produit, on annule la transaction
            DB::rollBack();

            // Retourner un message d'erreur
            return redirect()->route('parametres')
                ->with('error', 'Une erreur est survenue lors de la création du projet. Veuillez réessayer.')
                ->with('exception', $e->getMessage());
        }
    }
}
