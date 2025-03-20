<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Décodage des données
        $data = [
            'budget' => json_decode($request->budget_data, true),
            'typeConversion' => json_decode($request->conversion_data, true),
            'totals' => json_decode($request->totals_data, true),
            'dons' => json_decode($request->dons_data, true),
        ];

        $pdf = PDF::loadView('export.budget-report', $data)
            ->setPaper('A4', 'landscape')
            ->setOptions([
                'enable_php' => true,
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->download('rapport-' . date('Y-m-d') . '.pdf');
    }

    public function exportPdf(Request $request)
    {
        $budget = json_decode($request->budget_data, true);
        $typeConversion = json_decode($request->conversion_data, true);
        $totals = json_decode($request->totals_data, true);
        $dons = json_decode($request->dons_data, true);

        $pdf = PDF::loadView('export.budget-report', compact('budget', 'typeConversion', 'totals', 'dons'));
        // return view('export.budget-report', [
        //     'budget' => $budget,
        //     'dons' => $dons,
        //     'typeConversion' => $typeConversion,
        //     'totals' => $totals,
        // ]);
        return $pdf->download('rapport_budget.pdf');
    }


    // public function certificat(Request $request)
    // {
    //     $personne = json_decode($request->personne, true);

    //     // // Charger la vue avec les données
    //     // $pdf = PDF::loadView('budget.certification', compact('personne'));

    //     // // Définir l'orientation du PDF en paysage (landscape)
    //     // $pdf->setPaper('A4', 'landscape');  // Vous pouvez aussi définir d'autres tailles comme 'A3', 'letter', etc.

    //     // Télécharger le PDF généré
    //     // return $pdf->download('certificat.pdf');
        // return view('budget.certification', compact('personne'));
    // }

    public function certificat(Request $request)
    {
        $personne = json_decode($request->personne, true);
        return view('budget.certification', compact('personne'));
        // $pdf = PDF::loadView('budget.certification', compact('personne'))
        //     ->setPaper('A4', 'landscape');

        // return $pdf->download('certificat.pdf');
    }
}
