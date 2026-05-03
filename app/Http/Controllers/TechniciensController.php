<?php

namespace App\Http\Controllers;

use App\Models\Techniciens;
use Illuminate\Http\Request;

class TechniciensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $valeur = "Occuper";
    $occupe = Techniciens::where('statut_tech', $valeur)->count();
    $disponible = Techniciens::where('statut_tech', '!=', $valeur)->count();
    $search = $request->query('search');
    $query = Techniciens::query();

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nom_techniciens', 'like', "%{$search}%")
              ->orWhere('prenom_techniciens', 'like', "%{$search}%")
              ->orWhere('specialite_technicien', 'like', "%{$search}%");
        });
    }

    $techniciens = $query->paginate(5);

    return view('techniciens.index', compact('techniciens'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('techniciens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'nom_techniciens'=>'required|string',
            'prenom_techniciens'=>'required|string',
            'telephone_technicien'=>'required|string',
            'sexe_techniciens'=>'nullable',
            'specialite_technicien'=>'required|string',
            'email_technicien'=>'required|string',
            'statut_tech'=>'required|string',

        ]);

        \App\Models\Techniciens::create($validated);

        return redirect()
             ->route('techniciens.index')
             ->with( 'success','Technicien enregistrer avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Techniciens $technicien)
    {
        return view('techniciens.show', compact('technicien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Techniciens $technicien)
    {
        return view('techniciens.edit', compact('technicien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Techniciens $technicien)
    {
        $validated=$request->validate([
            'nom_techniciens'=>'required|string',
            'prenom_techniciens'=>'required|string',
            'telephone_technicien'=>'required|string',
            'sexe_techniciens'=>'nullable',
            'specialite_technicien'=>'required|string',
            'email_technicien'=>'required|string',
            'statut_tech'=>'nullable',

        ]);

        $technicien->update($validated);

        return redirect()
             ->route('techniciens.index')
             ->with( 'success','Technicien modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Techniciens $technicien)
    {
        $technicien->delete();
        return redirect()
            ->route('techniciens.index')
            ->with('success', 'Technicien supprimé avec succès !');
    }
}
