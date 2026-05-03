@extends('layouts.app')

@section('title', 'AppliMaintenance | Appareil')

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
                    <strong class="d-block">Succès</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- En-tête --}}
    <div class="card header-glass border-0">
        <div class="card-header bg-transparent py-4 d-flex justify-content-between align-items-center border-0">
            <div>
                <h4 class="mb-0 fw-bold text-dark tracking-tight">
                    <span class="icon-box bg-primary-soft text-primary me-2">
                        <i class="bi bi-laptop"></i>
                    </span>
                    Liste des Appareils
                </h4>
                <p class="text-muted small mb-0 ms-5 mt-1">Inventaire technique du parc informatique</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form class="search-wrapper" role="search" action="{{ route('appareils.index') }}" method="GET">
                    <i class="bi bi-search search-icon"></i>
                    <input class="form-control search-input" 
                        name="search" 
                        type="search" 
                        placeholder="Nom, Marque..." 
                        value="{{ request('search') }}"/>
                </form>
                
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{route('appareils.create')}}" class="btn btn-primary btn-add-custom shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>Nouveau 
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="card-body p-0 body-glass mt-3">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Appareil & Marque</th>
                        <th>Type</th>
                        <th>État</th>
                        <th>Couleur</th>
                        <th class="text-center">Gestion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appareils as $appareil)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-dynamic me-3" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                                        <span class="text-white fw-bold">{{ strtoupper(substr($appareil->nom_appareil, 0, 1))}}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $appareil->nom_appareil }}</div>
                                        <div class="text-primary-soft-dark small fw-medium">{{ $appareil->marque_appareil }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{-- Écriture augmentée ici --}}
                                <span class="badge bg-light text-dark border-0 px-3 py-2 fw-bold fs-6">
                                    {{ $appareil->type_appareil ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if(strtolower($appareil->etat_appareil) == 'reparer')
                                    <div class="status-tag status-ok">
                                        <span class="dot"></span> Réparé
                                    </div>
                                @else
                                    <div class="status-tag status-error">
                                        <span class="dot"></span> Endommagé
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-palette me-2 text-muted"></i>
                                    <span class="small fw-medium">{{ $appareil->couleur_appareil }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="action-stack">
                                    {{-- Paire d'yeux --}}
                                    <a href="{{route('appareils.show', $appareil->id_appareil)}}" class="action-btn view" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        {{-- Crayon --}}
                                        <a href="{{route('appareils.edit', $appareil->id_appareil)}}" class="action-btn edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="action-btn delete" data-bs-toggle="modal" data-bs-target="#Supprimer{{ $appareil->id_appareil }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de suppression --}}
                        @if(auth()->user() && auth()->user()->role === 'admin')
                        <div class="modal fade" id="Supprimer{{ $appareil->id_appareil }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-body text-center p-5">
                                        <div class="delete-warning-icon mb-4">
                                            <i class="bi bi-exclamation-octagon text-danger display-4"></i>
                                        </div>
                                        <h4 class="fw-bold mb-3">Supprimer ?</h4>
                                        <p class="text-muted small">Voulez-vous supprimer <strong>{{ $appareil->nom_appareil }}</strong> ?</p>
                                        <div class="d-flex gap-2 justify-content-center mt-4">
                                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold shadow-sm" data-bs-dismiss="modal">Non</button>
                                            <form action="{{ route('appareils.destroy', $appareil->id_appareil) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm">Oui, supprimer</button>
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
                                    <i class="bi bi-folder-x display-1 text-light"></i>
                                    <p class="mt-3 text-muted fw-medium">Aucun appareil trouvé.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($appareils->hasPages())
            <div class="pagination-footer py-4 d-flex justify-content-center border-top">
                <div class="custom-pagination">
                    {{ $appareils->appends(['search' => request('search')])->links() }}
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

    /* Cartes Glassmorphism */
    .header-glass { background: white !important; border-radius: 20px !important; box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important; }
    .body-glass { 
        background: white !important; border-radius: 20px !important; 
        box-shadow: 0 15px 40px rgba(0,0,0,0.08) !important; 
        overflow: hidden; border: 1px solid rgba(0,0,0,0.02); 
    }

    .icon-box { padding: 10px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; }
    .bg-primary-soft { background-color: var(--primary-soft); }

    /* Barre de Recherche */
    .search-wrapper { position: relative; width: 280px; }
    .search-input {
        border-radius: 50px !important; padding-left: 40px !important;
        background: var(--bg-main) !important; border: 1px solid transparent !important;
        font-size: 0.9rem;
    }
    .search-input:focus { background: white !important; border-color: var(--primary-color) !important; box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1) !important; }
    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }

    .btn-add-custom { border-radius: 50px !important; padding: 8px 20px !important; font-weight: 600; transition: transform 0.2s; }

    /* Tableau */
    .table-custom thead th {
        background: #fdfdff; color: var(--text-muted); font-size: 0.75rem;
        font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
        padding: 1.5rem 1rem; border-bottom: 1px solid #f1f1f1 !important;
    }

    .avatar-dynamic {
        width: 45px; height: 45px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Statuts */
    .status-tag { display: inline-flex; align-items: center; padding: 6px 14px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; }
    .dot { width: 8px; height: 8px; border-radius: 50%; margin-right: 8px; }
    .status-ok { background: #eafaf1; color: #27ae60; }
    .status-ok .dot { background: #27ae60; box-shadow: 0 0 8px #27ae60; }
    .status-error { background: #fff5f5; color: #e74c3c; }
    .status-error .dot { background: #e74c3c; box-shadow: 0 0 8px #e74c3c; }

    /* Actions */
    .action-stack { display: flex; gap: 8px; justify-content: center; }
    .action-btn {
        width: 38px; height: 38px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px; background: var(--bg-main);
        text-decoration: none; border: none; transition: all 0.2s;
        font-size: 1.1rem;
    }
    .action-btn.view { color: var(--primary-color); }
    .action-btn.edit { color: #f39c12; }
    .action-btn.delete { color: #e74c3c; }
    .action-btn:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); background: white; }

    /* Pagination */
    .custom-pagination .pagination { gap: 5px; }
    .custom-pagination .page-link { border-radius: 12px !important; border: none !important; background: #f8f9fc; color: var(--primary-color); font-weight: 600; }
    .custom-pagination .page-item.active .page-link { background: var(--primary-color) !important; color: white; }
    
    nav p.text-sm { display: none !important; }
    .table-responsive::-webkit-scrollbar { display: none; }
</style>
@endsection