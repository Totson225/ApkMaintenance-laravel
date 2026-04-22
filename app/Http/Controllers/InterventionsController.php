<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appareils;
use App\Models\Demandeurs;
use App\Models\Interventions;
use App\Models\Materiels;
use App\Models\Techniciens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InterventionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
           $valeurParDefaut = "Aucune solution apportee";
           $inachevees = Interventions::where('solution_apportee', $valeurParDefaut)->count();
           $achevees = Interventions::where('solution_apportee', '!=', $valeurParDefaut)->count();
           $search = $request->query('search');
            
            // requete search
            $query = Interventions::query();

            // filtre recherche
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('date_demande', 'like', "%{$search}%")
                    ->orWhere('date_intervention', 'like', "%{$search}%")
                    ->orWhere('descript_panne', 'like', "%{$search}%");
                });
            }

            // pagination
            $interventions = $query->paginate(7);

            // vue retour
            return view('interventions.index', compact('interventions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $demandeurs = Demandeurs::all();
        $techniciens = Techniciens::all();
        $materiels = Materiels::all();
        $appareils = Appareils::all();
        $interventions=\App\Models\Interventions::all();
        return view('interventions.create',compact('interventions', 'techniciens', 'materiels', 'appareils','demandeurs'));  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
          'date_demande'=>'required|date',
          'date_intervention'=>'required|date',
          'descript_panne'=>'required|string',
          'solution_apportee'=>'nullable|string',
          'type_intervention'=>'required|string',
          'id_appareil'=>'required|exists:appareils,id_appareil',
          'id_utilisateur'=>'required|exists:demandeurs,id_utilisateur', 
        //   'id_technicien'=>'required|exists:techniciens,id_technicien',
        //   'Id_materiel'=>'required|exists:materiels,Id_materiel',
          
        ]);

        if (empty($validated['solution_apportee'])) {
           unset($validated['solution_apportee']);
        }

       $intervention = Interventions::create($validated);

        if ($request->has('techniciens')) {
                $intervention->techniciens()->attach($request->techniciens);
            }
            
        if ($request->has('materiels')) {
            foreach ($request->materiels as $materielId) {
                $intervention->materiels()->attach($materielId, [
                    'Deb_intervention' => now() 
                ]);
            }
        }
       return Redirect()
             ->route('interventions.index')
             ->with( 'success','Intervention enregistrer avec succès !'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Interventions $intervention)
    {
        $intervention->load(['techniciens', 'materiels', 'pieces']);
        return view('interventions.show', compact('intervention'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interventions $intervention)
    {
        $demandeurs = \App\Models\Demandeurs::all();
        $techniciens = Techniciens::all();
        $materiels = Materiels::all();
        $appareils = \App\Models\Appareils::all();  
        return view('interventions.edit', compact('demandeurs', 'techniciens', 'materiels' ,'appareils','intervention'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interventions $intervention)
    {
        $validated=$request->validate([
          'date_demande'=>'required|date',
          'date_intervention'=>'required|date',
          'descript_panne'=>'required|string',
          'solution_apportee'=>'nullable',
          'type_intervention'=>'required|string',
          'id_appareil'=>'required|exists:appareils,id_appareil',
          'id_utilisateur'=>'required|exists:demandeurs,id_utilisateur',
        //   'id_technicien'=>'required|exists:techniciens,id_technicien',
        //   'Id_materiel'=>'required|exists:materiels,Id_materiel',  
        ]);


       $intervention = Interventions::create($validated);

        if ($request->has('techniciens')) {
                $intervention->techniciens()->sync($request->techniciens);
            }
            
        if ($request->has('materiels')) {
            foreach ($request->materiels as $materielId) {
                $intervention->materiels()->sync($materielId, [
                    'Deb_intervention' => now() 
                ]);
            }
        }
       return Redirect()
             ->route('interventions.index')
             ->with( 'success','Intervention modifié avec succès !'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interventions $intervention)
    {
        $intervention->delete();
        return redirect()
            ->route('interventions.index')
            ->with('success', 'Intervention supprimé avec succès !'); 
    }
}
