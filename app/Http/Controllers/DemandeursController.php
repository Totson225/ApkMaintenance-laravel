<?php

namespace App\Http\Controllers;

use App\Models\Demandeurs;
use Illuminate\Http\Request;

class DemandeursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
            
            // requete search
            $query = Demandeurs::query();

            // filtre recherche
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nom_demandeur', 'like', "%{$search}%")
                    ->orWhere('prenom_demandeur', 'like', "%{$search}%")
                    ->orWhere('service_demandeur', 'like', "%{$search}%");
                });
            }

            // pagination
            $demandeurs = $query->paginate(7);

            // vue retour
            return view('demandeurs.index', compact('demandeurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('demandeurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'nom_demandeur'=>'required|string',
            'prenom_demandeur'=>'required|string',
            'telephone_demandeur'=>'required|string',
            'sexe_demandeurs'=>'nullable',
            'service_demandeur'=>'required|string',
            'email_demandeur'=>'required|string',

        ]);

        \App\Models\Demandeurs::create($validated);

        return redirect()
             ->route('demandeurs.index')
             ->with( 'success','Demandeur enregistrer avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(demandeurs $demandeur)
    {
        return view('demandeurs.show', compact('demandeur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(demandeurs $demandeur)
    {
        return view('demandeurs.edit', compact('demandeur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, demandeurs $demandeur)
    {
        $validated=$request->validate([
            'nom_demandeur'=>'required|string',
            'prenom_demandeur'=>'required|string',
            'telephone_demandeur'=>'required|string',
            'sexe_demandeurs'=>'nullable',
            'service_demandeur'=>'required|string',
            'email_demandeur'=>'required|string',

        ]);

        $demandeur->update($validated);
        return redirect()
            ->route('demandeurs.index')
            ->with('success', 'Demandeur modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(demandeurs $demandeur)
    {
       $demandeur->delete();
        return redirect()
            ->route('demandeurs.index')
            ->with('success', 'Demandeur supprimé avec succès !'); 
    }
}
