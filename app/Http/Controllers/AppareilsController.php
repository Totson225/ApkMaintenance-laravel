<?php

namespace App\Http\Controllers;

use App\Models\Appareils;
use Illuminate\Http\Request;

class AppareilsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $valeur = "Reparer";
        $reparer = Appareils::where('etat_appareil', $valeur)->count();
        $endommager = Appareils::where('etat_appareil', '!=', $valeur)->count();
        $search = $request->query('search');
            $query = Appareils::query();
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nom_appareil', 'like', "%{$search}%")
                    ->orWhere('marque_appareil', 'like', "%{$search}%")
                    ->orWhere('type_appareil', 'like', "%{$search}%");
                });
            }

            // pagination
            $appareils = $query->paginate(7);

            // vue retour
            return view('appareils.index', compact('appareils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $demandeurs = \App\Models\Demandeurs::all(); 
        return view('appareils.create', compact('demandeurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nom_appareil'     => 'nullable|string',
            'marque_appareil'  => 'required|string',
            'type_appareil'    => 'required|string',
            'etat_appareil'    => 'required|string',
            'couleur_appareil' => 'required|string',
            'id_utilisateur'   => 'required|exists:demandeurs,id_utilisateur'

        ]);

        // Création
        Appareils::create($validated);
        return redirect()
            ->route('appareils.index')
            ->with('success', 'Appareil enregistré avec succès !');
    }

    /**
     * Display the specified resource.mkdir resources/views/concerners
     */
    public function show(Appareils $appareil)
    {
        return view('appareils.show', compact('appareil'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appareils $appareil)
    {
        $demandeurs = \App\Models\Demandeurs::all(); 
        return view('appareils.edit', compact('demandeurs', 'appareil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appareils $appareil)
    {
        $validated = $request->validate([
            'nom_appareil'     => 'nullable|string',
            'marque_appareil'  => 'required|string',
            'type_appareil'    => 'required|string',
            'etat_appareil'    => 'required|string',
            'couleur_appareil' => 'required|string',
            'id_utilisateur'   => 'required|exists:demandeurs,id_utilisateur'

        ]);

        // Création
         $appareil->update($validated);
        return redirect()
            ->route('appareils.index')
            ->with('success', 'Appareil modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appareils $appareil)
    {
        $appareil->delete();
        return redirect()
            ->route('appareils.index')
            ->with('success', 'Appareil supprimé avec succès !'); 
    }
}
