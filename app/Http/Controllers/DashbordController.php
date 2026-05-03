<?php

namespace App\Http\Controllers;

use App\Models\Appareils;
use App\Models\Interventions;
use App\Models\Materiels;
use App\Models\PieceRechanges;
use App\Models\Techniciens;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashbordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // --- Statistiques Interventions ---
        $valeurParDefaut = "Aucune solution apportee"; 
        $inachevees = Interventions::where('solution_apportee', $valeurParDefaut)->count();
        $achevees = Interventions::where('solution_apportee', '!=', $valeurParDefaut)->count();

        // --- Statistiques Techniciens ---
        $valeurTech = "Occuper"; 
        $occupe = Techniciens::where('statut_tech', $valeurTech)->count();
        $disponible = Techniciens::where('statut_tech', '!=', $valeurTech)->count();

        // --- Statistiques Appareils ---
        $valeurApp = "Reparer";
        $reparer = Appareils::where('etat_appareil', $valeurApp)->count();
        $endommager = Appareils::where('etat_appareil', '!=', $valeurApp)->count();

        // --- Statistiques Materiel ---
        $valeurMat = "Operationnel";
        $opp = Materiels::where('etat', $valeurMat)->count();
        $ind = Materiels::where('etat', '!=', $valeurMat)->count();

        // --- Statistiques Pieces ---
        $nbe = PieceRechanges::sum('Stock');

        // Dernier appareil réparé et son technicien
        $derniereIntervention = Interventions::where('solution_apportee', '!=', $valeurParDefaut)
            ->with(['appareils', 'techniciens']) 
            ->latest('updated_at')
            ->first();

        // Dernier arrivage (dernière pièce enregistrée)
        $dernierePiece = PieceRechanges::latest()->first();

        // --- Graphe ---
        $statsMois = Interventions::select(
            DB::raw('DAY(date_intervention) as jour'),
            DB::raw('count(*) as total')
        )
        ->whereMonth('date_intervention', Carbon::now()->month)
        ->whereYear('date_intervention', Carbon::now()->year)
        ->groupBy('jour')
        ->pluck('total', 'jour')
        ->all();

        $jours = range(1, Carbon::now()->daysInMonth);
        $donneesGraphique = [];
        foreach ($jours as $jour) {
            $donneesGraphique[] = $statsMois[$jour] ?? 0;
        }

        return view('dashbord', compact(
            'occupe', 'disponible',
            'achevees', 'inachevees', 
            'reparer', 'endommager',
            'opp', 'ind', 'nbe', 
            'jours','donneesGraphique',
            'derniereIntervention', 'dernierePiece' 
        ));
    }
}