@extends('layouts.app')

@section('title', 'AppliMaintenance | Demandeur')

@section('content')
<div class="container py-5">
    {{-- Alertes stylisées --}}
    @if(session('success'))
        <div class="alert alert-custom alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon-circle bg-success text-white me-3">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <strong class="d-block">Opération réussie</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- En-tête de la carte --}}
    <div class="card header-glass border-0">
        <div class="card-header bg-transparent py-4 d-flex justify-content-between align-items-center border-0">
            <div>
                <h4 class="mb-0 fw-bold text-dark tracking-tight">
                    <span class="icon-box bg-primary-soft text-primary me-2">
                        <i class="bi bi-people-fill"></i>
                    </span>
                    Annuaire des Demandeurs
                </h4>
                <p class="text-muted small mb-0 ms-5 mt-1">Gérez le personnel et leurs coordonnées</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form class="search-wrapper" role="search" action="{{ route('demandeurs.index') }}" method="GET">
                    <i class="bi bi-search search-icon"></i>
                    <input class="form-control search-input" 
                        name="search" 
                        type="search" 
                        placeholder="Rechercher un collaborateur..." 
                        value="{{ request('search') }}"/>
                </form>
                
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{route('demandeurs.create')}}" class="btn btn-primary btn-add-custom shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>Nouveau
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Corps du tableau --}}
    <div class="card-body p-0 body-glass mt-3">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Identité du Demandeur</th>
                        <th>Contact & Email</th>
                        <th>Genre</th>
                        <th>Département / Service</th>
                        <th class="text-center">Gestion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandeurs as $demandeur)
                        @php
                            $isMale = strtolower($demandeur->sexe_demandeurs) == 'masculin';
                            $avatarGradient = $isMale 
                                ? 'linear-gradient(135deg, #4e73df 0%, #224abe 100%)' 
                                : 'linear-gradient(135deg, #f64f59 0%, #c471ed 100%)';
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-dynamic me-3" style="background: {{ $avatarGradient }};">
                                        <span>{{ strtoupper(substr($demandeur->nom_demandeur, 0, 1) . substr($demandeur->prenom_demandeur, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $demandeur->nom_demandeur }} {{ $demandeur->prenom_demandeur }}</div>
                                        <div class="text-primary-soft-dark small fw-medium">ID #{{ str_pad($demandeur->id_utilisateur, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium"><i class="bi bi-telephone me-2 text-muted small"></i>{{ $demandeur->telephone_demandeur ?? 'Non renseigné' }}</span>
                                    <span class="text-muted small"><i class="bi bi-envelope me-2 text-muted small"></i>{{ $demandeur->email_demandeur }}</span>
                                </div>
                            </td>
                            <td>
                                @if($isMale)
                                    <div class="status-tag status-ok">
                                        <span class="dot"></span> Masculin
                                    </div>
                                @else
                                    <div class="status-tag status-female">
                                        <span class="dot"></span> Féminin
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-light text-dark border px-3 fw-semibold">
                                    {{ $demandeur->service_demandeur }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-stack">
                                    {{-- Icône Yeux --}}
                                    <a href="{{route('demandeurs.show', $demandeur->id_utilisateur)}}" class="action-btn view" title="Voir profil">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        {{-- Icône Crayon --}}
                                        <a href="{{route('demandeurs.edit', $demandeur->id_utilisateur)}}" class="action-btn edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Bouton Delete identique --}}
                                        <button type="button" class="action-btn delete border-0" data-bs-toggle="modal" data-bs-target="#Supprimer{{ $demandeur->id_utilisateur }}" title="Supprimer">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de suppression --}}
                        @if(auth()->user() && auth()->user()->role === 'admin')
                        <div class="modal fade" id="Supprimer{{ $demandeur->id_utilisateur }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-body text-center p-5">
                                        <div class="delete-warning-icon mb-4">
                                            <i class="bi bi-person-x text-danger display-4"></i>
                                        </div>
                                        <h4 class="fw-bold mb-3">Supprimer le demandeur ?</h4>
                                        <p class="text-muted">Vous allez retirer <strong>{{ $demandeur->nom_demandeur }} {{ $demandeur->prenom_demandeur }}</strong> de la base.</p>
                                        <div class="d-flex gap-2 justify-content-center mt-4">
                                            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('demandeurs.destroy', $demandeur->id_utilisateur) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4 rounded-pill">Confirmer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-person-x display-1 text-light"></i>
                                    <p class="mt-3 text-muted fw-medium">Aucun collaborateur trouvé.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($demandeurs->hasPages())
            <div class="pagination-footer py-4 d-flex justify-content-center border-top">
                <div class="custom-pagination">
                    {{ $demandeurs->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    :root {
        --primary-color: #4e73df;
        --primary-soft: #f1f4ff;
        --bg-main: #f8f9fc;
        --text-muted: #858796;
    }

    body { background-color: var(--bg-main); font-family: 'Inter', sans-serif; }

    .header-glass {
        background: white !important;
        border-radius: 20px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important;
    }

    .body-glass {
        background: white !important;
        border-radius: 20px !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08) !important;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .icon-box {
        padding: 10px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .search-wrapper { position: relative; width: 280px; }
    .search-input {
        border-radius: 50px !important;
        padding-left: 40px !important;
        background: var(--bg-main) !important;
        border: 1px solid transparent !important;
        transition: all 0.3s ease;
    }
    .search-input:focus {
        background: white !important;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1) !important;
    }
    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }

    .btn-add-custom {
        border-radius: 50px !important;
        padding: 8px 20px !important;
        font-weight: 600;
        transition: transform 0.2s ease;
    }

    .table-custom thead th {
        background: #fdfdff;
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid #f1f1f1 !important;
        padding: 1.5rem 1rem;
    }

    .table-custom tbody tr { transition: all 0.3s ease; border-bottom: 1px solid #f8f9fc; }
    .table-custom tbody tr:hover { background-color: #fbfcfe !important; transform: scale(1.002); }

    .avatar-dynamic {
        width: 45px;
        height: 45px;
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .status-tag {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .dot { width: 8px; height: 8px; border-radius: 50%; margin-right: 8px; }
    
    .status-ok { background: #eafaf1; color: #27ae60; }
    .status-ok .dot { background: #27ae60; box-shadow: 0 0 8px #27ae60; }
    
    .status-female { background: #fef1f8; color: #d63384; }
    .status-female .dot { background: #d63384; box-shadow: 0 0 8px #d63384; }

    .action-stack { display: flex; gap: 8px; justify-content: center; }
    .action-btn {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        background: var(--bg-main);
        text-decoration: none;
        border: none;
        cursor: pointer;
        outline: none;
    }
    .action-btn.view { color: var(--primary-color); }
    .action-btn.edit { color: #f39c12; }
    .action-btn.delete { color: #e74c3c; }
    .action-btn:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); background: white; }
    .action-btn:focus { box-shadow: none; outline: none; }

    .custom-pagination .page-link {
        border-radius: 12px !important;
        margin: 0 3px;
        border: none !important;
        background: #f8f9fc;
        color: var(--primary-color);
        font-weight: 600;
    }
    .custom-pagination .page-item.active .page-link {
        background: var(--primary-color) !important;
        color: white;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
    }

    .table-responsive::-webkit-scrollbar { display: none; }
    nav p.text-sm { display: none !important; }
</style>
@endsection