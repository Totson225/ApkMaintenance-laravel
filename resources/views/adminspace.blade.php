@extends('layouts.app')

@section('content')
    
    <header class="dashboard-header ">
        <h1 class="fw-bold">Epace Administrateur</h1>
        <p class="text-muted">Bienvenue dans votre espace de gestion des differents utilisateurs :</p>
    </header>
    <div class="container py-4">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-people-fill me-2"></i>Liste des utilisateurs
                </h5>
                    <form class="d-flex me-3" role="search" action="{{ route('adminspace') }}" method="GET">
                        <input class="form-control me-2" 
                            name="search" 
                            type="search" 
                            placeholder="Nom, Email, Role..." 
                            aria-label="Search" 
                            value="{{ request('search') }}"/>
                        <button class="btn btn-outline-primary" type="submit">Recherche</button>
                    </form>

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="bi bi-person-plus-fill me-1"></i> Créer
                            </a>
                        @endif
                    </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Utilisateur</th>
                                <th>Rôle</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px; border: 1px solid #e0e0e0;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">{{ $user->role }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Supprimer{{ $user->id }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>

                                        <div class="modal fade" id="Supprimer{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center py-4">
                                                        <i class="bi bi-exclamation-triangle text-danger display-4"></i>
                                                        <p class="mt-3">Supprimer l'utilisateur <strong>{{ $user->name }}</strong> ?</p>
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-danger">Confirmer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4">Aucun utilisateur trouvé.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $users->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    <style>
            .dashboard-header { 
                border-left: 5px solid #0d6efd; 
                padding-left: 10px; 
                margin-bottom: 40px;
                padding: 30px 2; 
                max-width: 1100px;
                margin: 0 auto; 
            }
    </style>
@endsection