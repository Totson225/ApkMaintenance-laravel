<?php

namespace App\Http\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class AdminspaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
            
            // requete search
            $query = User::query();

            // filtre recherche
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
                });
            }

            // pagination
            $users = $query->paginate(7);

            // vue retour
            return view('adminspace', compact('users'));
    }
    public function destroy(User $user)
    {
        if (auth()->id() === $user->user_id) {
            return back()->with('error', 'Vous ne pouvez pas vous supprimer vous-même.');
        }
        
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}