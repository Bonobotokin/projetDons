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
        $budgets = $this->budgetService->getAll();

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
            'montant_total' => 'required|numeric|min:0',
        ], [
            'nom_projet.required' => 'Le nom du projet est requis.',
            'nom_projet.string' => 'Le nom du projet doit être une chaîne de caractères.',
            'montant_total.required' => 'Le montant total est requis.',
            'montant_total.numeric' => 'Le montant total doit être un nombre.',
            'montant_total.min' => 'Le montant total ne peut pas être inférieur à 0.',
        ]);

        try {
            $budget = $this->budgetService->createBudget($validated);

            return redirect()->route('parametres')
                ->with('success', 'Le projet a été créé avec succès!')
                ->with('budget', $budget);
        } catch (\Exception $e) {
            return redirect()->route('parametres')
                ->with('error', 'Une erreur est survenue lors de la création du projet. Veuillez réessayer.');
        }
    }

    /**
     * Affiche un budget spécifique.
     */
    public function show($nom_projet)
    {
        $budget = $this->budgetService->getBudgetByName($nom_projet);

        $navigation = $this->budgetService->getAll();
        if (!$budget) {
            return redirect()->route('parametres')->with('error', 'Budget introuvable.');
        }

        return view('budget.show', compact('budget','navigation'));
    }

    /**
     * Page des paramètres.
     */
    public function parametres()
    {
        $navigation = $this->budgetService->getAll();
        
        return view('budget.parametres', compact('navigation'));
    }

    /**
     * Redirection vers les paramètres.
     */
    public function redirect()
    {
        return redirect()->route('parametres')->with('success', 'Redirection effectuée.');
    }
}
