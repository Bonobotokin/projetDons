<?php

namespace App\Domains\Budget\Controllers;

use Illuminate\Http\Request;
use App\Domains\Budget\Services\BudgetService;
use App\Domains\Budget\Models\Budget;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
    protected BudgetService $budgetService;

    public function __construct(BudgetService $budgetService)
    {
        $this->budgetService = $budgetService;
    }

    /**
     * Affiche la liste des budgets.
     */
    public function index()
    {
        $budgets = $this->budgetService->navigation();

        if ($budgets > 0) {
            return view('budget.parametres', compact('budgets'));
        }

        return view('budget.index', compact('budgets'));
    }

    /**
     * Enregistre un nouveau budget.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_projet' => 'required|string|max:255',
            'montant_total' => 'required',
        ], [
            'nom_projet.required' => 'Le nom du projet est requis.',
            'nom_projet.string' => 'Le nom du projet doit être une chaîne de caractères.',
            'montant_total.required' => 'Le montant total est requis.',
            'montant_total.numeric' => 'Le montant total doit être un nombre.',
            'montant_total.min' => 'Le montant total ne peut pas être inférieur à 0.',
        ]);

        try {
            // Nettoyer le montant_total pour supprimer les séparateurs
            $validated['montant_total'] = str_replace(',', '', $validated['montant_total']); // Supprime les virgules
            $validated['montant_total'] = floatval($validated['montant_total']);
            $budget = $this->budgetService->createBudget($validated);

            return redirect()->route('parametres')
                ->with('success', 'Le projet a été créé avec succès!')
                ->with('budget', $budget);
        } catch (\Exception $e) {
            return redirect()->route('parametres')
                ->with('error', 'Une erreur est survenue lors de la création du projet. Veuillez réessayer.');
        }
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'budget_id' => 'required|exists:budgets,id',
            'nom_projet' => 'required|string|max:255',
            'montant_total' => 'required',
            'activer' => 'string',
        ], [
            'budget_id.required' => 'L\'identifiant du budget est requis.',
            'budget_id.exists' => 'Le budget spécifié n\'existe pas.',
            // ... autres messages de validation
        ]);

        try {
            $active = null;
            if ($request->has('activer') === TRUe) {
                $active = "Actif";
            } else {
                $active = "Non actif";
            }

            $montantTotal = $validated['montant_total'];

            // Supprimer les virgules (séparateurs de milliers) de la chaîne
            $montantTotalSansVirgules = str_replace(',', '', $montantTotal);

            // Convertir la chaîne résultante en un nombre flottant
            $montantTotalFloat = (float) $montantTotalSansVirgules;

            $budget = Budget::findOrFail($validated['budget_id']);
            $budget->nom_projet = $validated['nom_projet'];
            $budget->montant_total = $montantTotalFloat;
            $budget->actif = $active;
            $budget->save();

            return redirect()->route('parametres')
                ->with('success', 'Le budget a été mis à jour avec succès!');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('parametres')
                ->with('error', 'Une erreur est survenue lors de la mise à jour du budget.');
        }
    }



    /**
     * Affiche un budget spécifique.
     */
    public function show($nom_projet)
    {
        $budget = $this->budgetService->getBudgetByName($nom_projet);


        $navigation = $this->budgetService->navigation();
        if (!$budget) {
            return redirect()->route('parametres')->with('error', 'Budget introuvable.');
        }

        return view('budget.show', compact('budget', 'navigation'));
    }

    /**
     * Page des paramètres.
     */
    public function parametres()
    {
        $budget = $this->budgetService->getAll();
        $navigation = $this->budgetService->navigation();
        return view('budget.parametres', compact('navigation', 'budget'));
    }

    /**
     * Redirection vers les paramètres.
     */
    public function redirect()
    {
        return redirect()->route('parametres')->with('success', 'Redirection effectuée.');
    }
}
