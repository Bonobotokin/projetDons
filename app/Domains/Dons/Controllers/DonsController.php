<?php

namespace App\Domains\Dons\Controllers;

use App\Domains\Budget\Services\BudgetService;
use App\Domains\ConversionDon\Services\ConversionDonService;
use App\Domains\Dons\Services\DonsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonsController extends Controller
{

    protected BudgetService $budgetService;
    protected DonsService $donsService;
    protected ConversionDonService $conversionDonService;

    public function __construct(
        BudgetService $budgetService,
        DonsService $donsService,
        ConversionDonService $conversionDonService
    ) {
        $this->budgetService = $budgetService;
        $this->donsService = $donsService;
        $this->conversionDonService = $conversionDonService;
    }

    public function viewDons($nom_projet)
    {
        
        $budget = $this->budgetService->getBudgetByName($nom_projet);


        if(is_null($budget))
        {
            
        return redirect()->route('parametres')->with('success', 'Redirection effectuée.');
        }

        $typeConversion = $this->conversionDonService->getDonsByIdBudget($budget["id"]);


        $getChoixDons = $this->conversionDonService->getTypeChoixDons($budget["id"]);
        
        $donsAll = $this->donsService->getDonsByIdBudget($budget["id"]);

        $navigation = $this->budgetService->navigation();
        
        $totals = $this->donsService->getDonsWithTotals($budget["id"]);

        
        return view('budget.show', [
            'budget' => $budget,
            'navigation' => $navigation,
            'dons' => $donsAll,
            'typeConversion' => $typeConversion,
            'choixDons' => $getChoixDons,
            'totals' => $totals,
        ]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $data = $request->all();
            $choix = $request['choix'];
            $budgetId = (int) $request['budger_id'];
           
            // Gestion de la conversion de don personnalisée
            // if ($request->filled('type_don_2')) {
            //     $this->handleCustomDonConversion($request, $budgetId, $data);
            // }

            // Traitement principal du don
            
            $this->processDon($choix, $data, $budgetId);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Le don a été créé avec succès!')
                ->with('budget', $budget ?? null);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error('Erreur lors de la création du don : ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création du don. Veuillez réessayer.');
        }
    }

    // private function handleCustomDonConversion(Request $request, int $budgetId, array &$data): void
    // {
    //     $requiredFields = [
    //         'custom_type_don' => $request->input('custom_type_don'),
    //         'valeur_unitaire_custom' => $request->input('valeur_unitaire_custom'),
    //         'budget_id' => $budgetId
    //     ];

    //     if (in_array(null, $requiredFields, true)) {
    //         Log::error("Données incomplètes pour la création de ConversionDon");
    //         return;
    //     }

    //     $conversionDon = $this->conversionDonService->createConversionDon([
    //         'type_don' => $requiredFields['custom_type_don'],
    //         'valeur_unitaire' => $requiredFields['valeur_unitaire_custom'],
    //         'budget_id' => $requiredFields['budget_id'],
    //     ]);

    //     $data = [
    //         "personnes" => $request["personnes"],
    //         "telephone" => $request["telephone"],
    //         "type_don_2" => $conversionDon["id"],
    //         'choix' => $request['choix'],
    //         "quantite_or_montant" => $request["quantite_or_montant"],
    //     ];
    // }

    private function processDon(string $choix, array $data, int $budgetId): void
    {
        $quantity = ((int) $data["quantite"]) ?  ((int) $data["quantite"]) :  (float) $data["montant"];
        
        $amount = ($choix === "Argent")
            ? $quantity
            : $this->conversionDonService->getTotalValue($data["type_don"], $quantity);
        
        $this->donsService->createDon($data, $amount);
        
        $this->budgetService->updateBudget($budgetId, $amount);
    }
}
