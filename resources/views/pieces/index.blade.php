@extends('layouts.app')

@section('title', 'AppliMaintenance | Piece')

@section('content')
<div class="container py-5">
    {{-- Alertes stylisées --}}
    @if(session('success'))
        <div class="alert alert-custom alert-dismissible fade show border-0 shadow-sm" role="alert">
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
                        <i class="bi bi-cpu"></i>
                    </span>
                    Inventaire des Pièces
                </h4>
                <p class="text-muted small mb-0 ms-5 mt-1">Gestion du stock et maintenance</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form class="search-wrapper" role="search" action="{{ route('pieces.index') }}" method="GET">
                    <i class="bi bi-search search-icon"></i>
                    <input class="form-control search-input" 
                        name="search" 
                        type="search" 
                        placeholder="Rechercher une pièce..." 
                        value="{{ request('search') }}"/>
                </form>
                
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{route('pieces.create')}}" class="btn btn-primary btn-add-custom shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>Nouveau
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Corps du tableau (La div en dehors) --}}
    <div class="card-body p-0 body-glass mt-3">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Composant</th>
                        <th>Prix Unitaire</th>
                        <th>Disponibilité</th>
                        <th class="text-center">Gestion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pieceRechanges as $pieceRechange)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-dynamic me-3">
                                        <span>{{ strtoupper(substr($pieceRechange->Nom, 0, 1))}}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $pieceRechange->Nom }}</div>
                                        <div class="text-primary-soft-dark small fw-medium">{{ $pieceRechange->Marque }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="price-tag">
                                    <span class="amount text-dark fw-bold">{{ number_format($pieceRechange->Prix, 0, ',', ' ') }}</span>
                                    <span class="currency">FCFA</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $stock = $pieceRechange->Stock ?? 0;
                                    $statusClass = $stock > 10 ? 'status-ok' : ($stock > 0 ? 'status-low' : 'status-empty');
                                @endphp
                                <div class="stock-status {{ $statusClass }}">
                                    <span class="dot"></span>
                                    <span class="fw-bold">{{ $stock }}</span> unités
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="action-stack">
                                    <a href="{{route('pieces.show', $pieceRechange->id_PRechange)}}" class="action-btn view" title="Détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <a href="{{route('pieces.edit', $pieceRechange->id_PRechange)}}" class="action-btn edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="action-btn delete" data-bs-toggle="modal" data-bs-target="#Supprimer{{ $pieceRechange->id_PRechange }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de suppression gardé identique pour la logique --}}
                        @if(auth()->user() && auth()->user()->role === 'admin')
                        <div class="modal fade" id="Supprimer{{ $pieceRechange->id_PRechange }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-body text-center p-5">
                                        <div class="delete-warning-icon mb-4">
                                            <i class="bi bi-exclamation-octagon text-danger display-4"></i>
                                        </div>
                                        <h4 class="fw-bold mb-3">Supprimer la pièce ?</h4>
                                        <p class="text-muted">Vous êtes sur le point de retirer <strong>{{ $pieceRechange->Nom }}</strong> de l'inventaire.</p>
                                        <div class="d-flex gap-2 justify-content-center mt-4">
                                            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('pieces.destroy', $pieceRechange->id_PRechange) }}" method="POST">
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
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <img src="https://illustrations.popsy.co/blue/box.svg" alt="Vide" style="width: 150px; opacity: 0.6;">
                                    <p class="mt-3 text-muted fw-medium">Aucun résultat ne correspond à votre recherche.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pieceRechanges->hasPages())
            <div class="pagination-footer mt-4 pb-4 d-flex justify-content-center">
                <div class="custom-pagination">
                    {{ $pieceRechanges->appends(['search' => request('search')])->links() }}
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
        --success-soft: #eafaf1;
        --danger-soft: #fdf2f2;
    }

    body { background-color: var(--bg-main); font-family: 'Inter', sans-serif; }

    /* --- Architecture des Cartes --- */
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

    /* --- Éléments de Design --- */
    .icon-box {
        padding: 10px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .bg-primary-soft { background-color: var(--primary-soft); }

    /* --- Barre de Recherche --- */
    .search-wrapper { position: relative; width: 280px; }
    .search-input {
        border-radius: 50px !important;
        padding-left: 40px !important;
        background: var(--bg-main) !important;
        border: 1px solid transparent !important;
        transition: all 0.3s ease;
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

    /* --- Bouton Ajouter --- */
    .btn-add-custom {
        border-radius: 50px !important;
        padding: 8px 20px !important;
        font-weight: 600;
        transition: transform 0.2s ease;
    }
    .btn-add-custom:hover { transform: scale(1.05); }

    /* --- Tableau Custom --- */
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
    .table-custom tbody tr:hover {
        background-color: #fbfcfe !important;
        transform: scale(1.002);
    }

    /* --- Avatars et Tags --- */
    .avatar-dynamic {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
    }

    .price-tag .amount { font-size: 1.1rem; }
    .price-tag .currency { font-size: 0.7rem; color: var(--text-muted); margin-left: 3px; font-weight: 600; }

    /* --- Statuts Stock --- */
    .stock-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.85rem;
    }
    .dot { width: 8px; height: 8px; border-radius: 50%; margin-right: 8px; }
    
    .status-ok { background: #eafaf1; color: #27ae60; }
    .status-ok .dot { background: #27ae60; box-shadow: 0 0 10px #27ae60; }
    
    .status-low { background: #fff9e6; color: #f39c12; }
    .status-low .dot { background: #f39c12; }
    
    .status-empty { background: #fdf2f2; color: #e74c3c; }
    .status-empty .dot { background: #e74c3c; }

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
        border: none;
        background: var(--bg-main);
    }
    .action-btn.view { color: #4e73df; }
    .action-btn.edit { color: #f39c12; }
    .action-btn.delete { color: #e74c3c; }
    .action-btn:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

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
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
    }

    /* Masquer les labels de pagination Laravel */
        nav p.text-sm.text-gray-700.leading-5 { display: none !important; }
    /* --- Masquage de la barre de défilement --- */
    .table-responsive {
        border-radius: 0 0 20px 20px !important;
        overflow-x: auto;
        -ms-overflow-style: none;  /* Pour Internet Explorer et Edge */
        scrollbar-width: none;     /* Pour Firefox */
    }



    .table-responsive::-webkit-scrollbar {
        display: none;             /* Pour Chrome, Safari et Opera */
    }
</style>
@endsection