<?php 
namespace App\Domains\ConversionDon\Controllers;

use App\Domains\ConversionDon\Services\ConversionDonService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  // Assurez-vous d'utiliser cette classe
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
        
        // Utiliser l'instance de la requête pour valider les données
        $validated = $request->validate([
            'budget_id' => 'required|exists:budgets,id',
            'type_don' => 'required|string|max:255',
            'valeur_unitaire' => 'required|numeric|min:0',
        ], [
            'type_don.required' => 'Le nom du projet est requis.',
            'valeur_unitaire.required' => 'Le montant total est requis.',
            'valeur_unitaire.numeric' => 'Le montant total doit être un nombre.',
            'valeur_unitaire.min' => 'Le montant total ne peut pas être inférieur à 0.',
        ]);


        try {
            
            $dons = $this->conversion_don_service->createConversionDon($validated);
            
            return redirect()->route('parametres')
                ->with('success', 'Le projet a été créé avec succès!')
                ->with('dons', $dons);
        } catch (\Exception $e) {
            return redirect()->route('parametres')
                ->with('error', 'Une erreur est survenue lors de la création du projet. Veuillez réessayer.');
        }
    }
}
