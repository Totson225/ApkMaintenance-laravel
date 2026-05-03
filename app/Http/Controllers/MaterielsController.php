<?php

namespace App\Http\Controllers;

use App\Models\Materiels;
use Illuminate\Http\Request;

class MaterielsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $valeur = "Operationnel";
        $opp = Materiels::where('etat', $valeur)->count();
        $ind = Materiels::where('etat', '!=', $valeur)->count();
        $search = $request->query('search');
            
            $query = Materiels::query();

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('type_materiel', 'like', "%{$search}%")
                    ->orWhere('marque', 'like', "%{$search}%")
                    ->orWhere('modele', 'like', "%{$search}%");
                });
            }

            // pagination
            $materiels = $query->paginate(5);

            // vue retour
            return view('materiels.index', compact('materiels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materiels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'type_materiel'=>'required|string',
            'marque'=>'required|string',
            'modele'=>'required|string',
            'numero_serie'=>'nullable',
            'date_acquisition'=>'required|string',
            'etat'=>'required|string',

        ]);

        \App\Models\Materiels::create($validated);

        return redirect()
             ->route('materiels.index')
             ->with( 'success','Matériels enregistrer avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materiels $materiel)
    {
        return view('materiels.show', compact('materiel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materiels $materiel)
    {
        return view('materiels.edit', compact('materiel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materiels $materiel)
    {
         $validated=$request->validate([
            'type_materiel'=>'required|string',
            'marque'=>'required|string',
            'modele'=>'required|string',
            'numero_serie'=>'nullable',
            'date_acquisition'=>'required|string',
            'etat'=>'required|string',

        ]);

        $materiel->update($validated);
        return redirect()
             ->route('materiels.index')
             ->with( 'success','Matériels modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materiels $materiel)
    {
        $materiel->delete();
        return redirect()
            ->route('materiels.index')
            ->with('success', 'Materiel supprimé avec succès !');
    }
}
