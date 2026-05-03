@extends('layouts.app')

@section('title', 'AppliMaintenance | Materiel')

@section('content')
<div class="container py-5">
    {{-- Alertes stylisées --}}
    @if(session('success'))
        <div class="alert alert-custom alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon-circle bg-success text-white me-3">
                    <i class="bi bi-check2-all"></i>
                </div>
                <div>
                    <strong class="d-block">Inventaire mis à jour</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- En-tête de la carte (Design Harmonisé) --}}
    <div class="card header-glass border-0">
        <div class="card-header bg-transparent py-4 d-flex justify-content-between align-items-center border-0">
            <div>
                <h4 class="mb-0 fw-bold text-dark tracking-tight">
                    <span class="icon-box bg-primary-soft text-primary me-2">
                        <i class="bi bi-tools"></i>
                    </span>
                    Parc Marériel
                </h4>
                <p class="text-muted small mb-0 ms-5 mt-1">Suivi et gestion des équipements techniques</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form class="search-wrapper" role="search" action="{{ route('materiels.index') }}" method="GET">
                    <i class="bi bi-search search-icon"></i>
                    <input class="form-control search-input" 
                        name="search" 
                        type="search" 
                        placeholder="Rechercher un matériel..." 
                        value="{{ request('search') }}"/>
                </form>
                
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{route('materiels.create')}}" class="btn btn-primary btn-add-custom shadow-sm">
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
                        <th class="ps-4">Équipement</th>
                        <th>Modèle & S/N</th>
                        <th>Acquisition</th>
                        <th>État Actuel</th>
                        <th class="text-center">Gestion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materiels as $materiel)
                        @php
                            $type = strtolower($materiel->type_materiel);
                            $icon = 'bi-tools';
                            $gradient = 'linear-gradient(135deg, #6c757d 0%, #343a40 100%)';
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-dynamic me-3" style="background: {{ $gradient }};">
                                        <i class="bi {{ $icon }} fs-5 text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $materiel->type_materiel }}</div>
                                        <div class="text-primary-soft-dark small fw-medium">{{ $materiel->marque }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    {{-- Modèle : Augmentation de la taille et suppression du 'px-0' pour plus d'espace --}}
                                    <span class="badge bg-light text-dark border-0 fw-bold fs-6 mb-1" style="text-align: left; width: fit-content;">
                                         {{ $materiel->modele ?? 'N/A' }}
                                    </span>
                                    {{-- S/N : Remplacement de 'small' par 'fs-7' (custom) ou suppression du 'small' --}}
                                    <div class="sn-container">
                                        <span class="text-uppercase text-muted fw-medium" style="font-size: 0.85rem;">N*</span>
                                        <code class="text-dark fw-bold ms-1" style="font-size: 0.9rem; background: transparent; padding: 0;">
                                            {{ $materiel->numero_serie ?? 'Inconnu' }}
                                        </code>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i> {{ $materiel->date_acquisition }}
                                </div>
                            </td>
                            <td>
                                @if(strtolower($materiel->etat) == 'operationnel')
                                    <div class="status-tag status-ok">
                                        <span class="dot"></span> Opérationnel
                                    </div>
                                @else
                                    <div class="status-tag status-error">
                                        <span class="dot"></span> Indisponible
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-stack">
                                    <a href="{{route('materiels.show', $materiel->Id_materiel)}}" class="action-btn view" title="Détails">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <a href="{{route('materiels.edit', $materiel->Id_materiel)}}" class="action-btn edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="action-btn delete" data-bs-toggle="modal" data-bs-target="#Supprimer{{ $materiel->Id_materiel }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de suppression (Harmonisé) --}}
                        @if(auth()->user() && auth()->user()->role === 'admin')
                        <div class="modal fade" id="Supprimer{{ $materiel->Id_materiel }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-body text-center p-5">
                                        <div class="delete-warning-icon mb-4">
                                            <i class="bi bi-exclamation-octagon text-danger display-4"></i>
                                        </div>
                                        <h4 class="fw-bold mb-3">Supprimer ce matériel ?</h4>
                                        <p class="text-muted">Le retrait du matériel <strong>{{ $materiel->type_materiel }}</strong> est irréversible.</p>
                                        <div class="d-flex gap-2 justify-content-center mt-4">
                                            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('materiels.destroy', $materiel->Id_materiel) }}" method="POST">
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
                                    <i class="bi bi-pc-display display-1 text-light"></i>
                                    <p class="mt-3 text-muted fw-medium">Aucun équipement dans le parc informatique.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($materiels->hasPages())
            <div class="pagination-footer py-4 d-flex justify-content-center border-top">
                <div class="custom-pagination">
                    {{ $materiels->appends(['search' => request('search')])->links() }}
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

    /* Architecture des Cartes (Glassmorphism) */
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

    .icon-box { padding: 10px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; }
    .bg-primary-soft { background-color: var(--primary-soft); }

    /* Barre de Recherche */
    .search-wrapper { position: relative; width: 280px; }
    .search-input {
        border-radius: 50px !important;
        padding-left: 40px !important;
        background: var(--bg-main) !important;
        border: 1px solid transparent !important;
        font-size: 0.9rem;
    }
    .search-input:focus {
        background: white !important;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1) !important;
    }
    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }

    .btn-add-custom { border-radius: 50px !important; padding: 8px 20px !important; font-weight: 600; transition: transform 0.2s; }
    .btn-add-custom:hover { transform: scale(1.02); }

    /* Tableau */
    .table-custom thead th {
        background: #fdfdff;
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 1.5rem 1rem;
        border-bottom: 1px solid #f1f1f1 !important;
    }

    .avatar-dynamic {
        width: 45px; height: 45px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Statuts */
    .status-tag { display: inline-flex; align-items: center; padding: 6px 14px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; }
    .dot { width: 8px; height: 8px; border-radius: 50%; margin-right: 8px; }
    .status-ok { background: #eafaf1; color: #27ae60; }
    .status-ok .dot { background: #27ae60; box-shadow: 0 0 8px #27ae60; }
    .status-error { background: #fff5f5; color: #e74c3c; }
    .status-error .dot { background: #e74c3c; }

    /* Actions */
    .action-stack { display: flex; gap: 8px; justify-content: center; }
    .action-btn {
        width: 35px; height: 35px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px; background: var(--bg-main);
        text-decoration: none; border: none; transition: all 0.2s;
    }
    .action-btn.view { color: var(--primary-color); }
    .action-btn.edit { color: #f39c12; }
    .action-btn.delete { color: #e74c3c; }
    .action-btn:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); background: white; }

    /* Pagination */
    .custom-pagination .page-link { border-radius: 12px !important; margin: 0 3px; border: none !important; background: #f8f9fc; color: var(--primary-color); font-weight: 600; }
    .custom-pagination .page-item.active .page-link { background: var(--primary-color) !important; color: white; box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3); }

    /* Clean Laravel pagination */
    nav p.text-sm { display: none !important; }
    .table-responsive::-webkit-scrollbar { display: none; }
    .table-responsive { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection