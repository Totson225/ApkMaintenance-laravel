@extends('layouts.app')

@section('title', 'AppliMaintenance | Intervention')

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
                    <strong class="d-block">Succès !</strong>
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
                        <i class="bi bi-journals"></i>
                    </span>
                    Registre des Interventions
                </h4>
                <p class="text-muted small mb-0 ms-5 mt-1">Historique des maintenances et dépannages</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form class="search-wrapper" role="search" action="{{ route('interventions.index') }}" method="GET">
                    <i class="bi bi-search search-icon"></i>
                    <input class="form-control search-input" 
                        name="search" 
                        type="search" 
                        placeholder="Rechercher panne, date..." 
                        value="{{ request('search') }}"/>
                </form>
                
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{route('interventions.create')}}" class="btn btn-primary btn-add-custom shadow-sm">
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
                        <th class="ps-4">Dates (Demande/Action)</th>
                        <th>Description Panne</th>
                        <th>Solution Apportée</th>
                        <th>Type</th>
                        <th class="text-center">Gestion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interventions as $intervention)
                        <tr>
                            <td class="ps-4">
                                <div class="date-stack">
                                    <div class="d-flex align-items-center mb-1 text-dark fw-bold" style="font-size: 0.9rem;">
                                        <i class="bi bi-calendar-event me-2 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($intervention->date_demande)->format('d M Y') }}
                                    </div>
                                    <div class="small text-muted ps-4">
                                        <i class="bi bi-arrow-return-right me-1"></i>
                                        {{ $intervention->date_intervention ? \Carbon\Carbon::parse($intervention->date_intervention)->format('d M Y') : 'En attente' }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-wrap-custom">
                                    <span class="text-dark fw-medium">{{ Str::limit($intervention->descript_panne, 40) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-wrap-custom">
                                    <span class="text-muted small">{{ Str::limit($intervention->solution_apportee ?? 'Diagnostic en cours...', 40) }}</span>
                                </div>
                            </td>
                            <td>
                                @if(strtolower($intervention->type_intervention) == 'préventive')
                                    <span class="badge-custom status-ok">
                                        <i class="bi bi-shield-check me-1"></i> Préventive
                                    </span>
                                @else
                                    <span class="badge-custom status-empty">
                                        <i class="bi bi-lightning-charge me-1"></i> Corrective
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-stack">
                                    <a href="{{route('interventions.show', $intervention->id_Intervtion)}}" class="action-btn view" title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <a href="{{route('interventions.edit', $intervention->id_Intervtion)}}" class="action-btn edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="action-btn delete" data-bs-toggle="modal" data-bs-target="#Supprimer{{ $intervention->id_Intervtion }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de suppression --}}
                        @if(auth()->user() && auth()->user()->role === 'admin')
                        <div class="modal fade" id="Supprimer{{ $intervention->id_Intervtion }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-body text-center p-5">
                                        <i class="bi bi-exclamation-octagon text-danger display-4 mb-3"></i>
                                        <h4 class="fw-bold mb-3">Supprimer l'intervention ?</h4>
                                        <p class="text-muted small">Voulez-vous supprimer l'intervention pour la panne : <br><strong>{{ $intervention->descript_panne }}</strong> ?</p>
                                        <div class="d-flex gap-2 justify-content-center mt-4">
                                            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('interventions.destroy', $intervention->id_Intervtion) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4 rounded-pill">Supprimer</button>
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
                                <div class="empty-state py-4">
                                    <i class="bi bi-clipboard-x display-1 text-light"></i>
                                    <p class="mt-3 text-muted fw-medium">Aucun historique d'intervention trouvé.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($interventions->hasPages())
            <div class="pagination-footer py-4 d-flex justify-content-center border-top">
                <div class="custom-pagination">
                    {{ $interventions->appends(['search' => request('search')])->links() }}
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

    /* --- Architecture Glassmorphism --- */
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

    /* --- Masquage Scrollbar --- */
    .table-responsive {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .table-responsive::-webkit-scrollbar { display: none; }

    /* --- Éléments de Design --- */
    .icon-box {
        padding: 10px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .bg-primary-soft { background-color: var(--primary-soft); }

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
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .btn-add-custom {
        border-radius: 50px !important;
        padding: 8px 20px !important;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-add-custom:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3); }

    /* --- Tableau Custom --- */
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

    .table-custom tbody tr { transition: all 0.2s; border-bottom: 1px solid #f8f9fc; }
    .table-custom tbody tr:hover { background-color: #fbfcfe !important; }

    /* --- Badges et Textes --- */
    .badge-custom {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    .status-ok { background: #eafaf1; color: #27ae60; }
    .status-empty { background: #fdf2f2; color: #e74c3c; }

    .date-stack { display: flex; flex-direction: column; }

    /* --- Actions --- */
    .action-stack { display: flex; gap: 8px; justify-content: center; }
    .action-btn {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s;
        background: var(--bg-main);
        border: none;
    }
    .action-btn.view { color: var(--primary-color); }
    .action-btn.edit { color: #f39c12; }
    .action-btn.delete { color: #e74c3c; }
    .action-btn:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); background: white; }

    /* --- Pagination --- */
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
    }
    nav p.text-sm { display: none !important; }
</style>
@endsection