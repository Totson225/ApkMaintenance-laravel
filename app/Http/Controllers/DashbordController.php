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
        // Interventions
        $valeurParDefaut = "Aucune solution apportee"; 
        $inachevees = Interventions::where('solution_apportee', $valeurParDefaut)->count();
        $achevees = Interventions::where('solution_apportee', '!=', $valeurParDefaut)->count();

        // Techniciens
        $valeur = "Occuper"; 
        $occupe = Techniciens::where('statut_tech', $valeur)->count();
        $disponible = Techniciens::where('statut_tech', '!=', $valeur)->count();

        // Appareils
        $valeur = "Reparer";
        $reparer = Appareils::where('etat_appareil', $valeur)->count();
        $endommager = Appareils::where('etat_appareil', '!=', $valeur)->count();

        // Materiel
        $valeur = "Operationnel";
        $opp = Materiels::where('etat', $valeur)->count();
        $ind = Materiels::where('etat', '!=', $valeur)->count();

        // Pieces
        $nbe = PieceRechanges::sum('Stock');


        // Graphe
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

        return view('dashbord', compact(  'occupe', 'disponible',
                                          'achevees', 'inachevees', 
                                          'reparer', 'endommager',
                                          'opp', 'ind', 'nbe', 
                                          'jours','donneesGraphique'
                                        )
                    );
    }
}