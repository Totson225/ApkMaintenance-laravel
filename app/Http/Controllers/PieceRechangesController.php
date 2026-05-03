<?php

namespace App\Http\Controllers;

use App\Models\Interventions;
use App\Models\PieceRechanges;
use Illuminate\Http\Request;

class PieceRechangesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nbe = PieceRechanges::sum('Stock');
        $search = $request->query('search');
            
            $query = PieceRechanges::query();
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('Nom', 'like', "%{$search}%")
                    ->orWhere('Marque', 'like', "%{$search}%")
                    ->orWhere('Prix', 'like', "%{$search}%");
                });
            }

            // pagination
            $pieceRechanges = $query->paginate(5);

            // vue retour
            return view('pieces.index', compact('pieceRechanges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $interventions = Interventions::all(); 
        return view('pieces.create', compact('interventions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nom' => 'required|string',
            'Marque' => 'nullable|string',
            'Prix'     => 'required|string',
            'Stock'  => 'required|integer',
            'id_Intervtion'   => 'nullable|exists:interventions,id_Intervtion'

        ]);

        PieceRechanges::create($validated);
        return redirect()
            ->route('pieces.index')
            ->with('success', 'Piece enregistré avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(PieceRechanges $piece)
    {
        return view('pieces.show', compact('piece'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PieceRechanges $piece)
    {
        $interventions = \App\Models\Interventions::all(); 
        return view('pieces.edit', compact('interventions', 'piece'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PieceRechanges $piece)
    {
        $validated = $request->validate([
            'Nom' => 'required|string',
            'Marque' => 'nullable|string',
            'Prix'     => 'required|string',
            'Stock'  => 'required|integer|min:1',
            'id_Intervtion'   => 'nullable|exists:interventions,id_Intervtion'

        ]);

        $piece->update($validated);
        return redirect()
            ->route('pieces.index')
            ->with('success', 'Piece modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PieceRechanges $piece)
    {
        $piece->delete();
        return redirect()
            ->route('pieces.index')
            ->with('success', 'Piece supprimé avec succès !');
    }
}
