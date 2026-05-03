@extends('layouts.app')

@section('title', 'AppliMaintenance | Technicien')

@section('content')
<div class="container py-5">
    {{-- Alertes stylisées --}}
    @if(session('success'))
        <div class="alert alert-custom alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon-circle bg-success text-white me-3">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <strong class="d-block">Opération réussie</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- En-tête de la carte (Style Glassmorphism) --}}
    <div class="card header-glass border-0">
        <div class="card-header bg-transparent py-4 d-flex justify-content-between align-items-center border-0">
            <div>
                <h4 class="mb-0 fw-bold text-dark tracking-tight">
                    <span class="icon-box bg-primary-soft text-primary me-2">
                        <i class="bi bi-person-fill-gear"></i>
                    </span>
                    Liste des Techniciens
                </h4>
                <p class="text-muted small mb-0 ms-5 mt-1">Gérez vos experts et leurs disponibilités</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form class="search-wrapper" role="search" action="{{ route('techniciens.index') }}" method="GET">
                    <i class="bi bi-search search-icon"></i>
                    <input class="form-control search-input" 
                        name="search" 
                        type="search" 
                        placeholder="Rechercher un expert..." 
                        value="{{ request('search') }}"/>
                </form>
                
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{route('techniciens.create')}}" class="btn btn-primary btn-add-custom shadow-sm">
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
                        <th class="ps-4">Expert Technique</th>
                        <th>Contact & Email</th>
                        <th>Genre</th>
                        <th>Statut</th>
                        <th>Spécialité</th>
                        <th class="text-center">Gestion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($techniciens as $technicien)
                        @php
                            $isMale = strtolower($technicien->sexe_techniciens) == 'masculin';
                            $isOccupied = strtolower($technicien->statut_tech) == 'occuper';
                            
                            $avatarGradient = $isMale 
                                ? 'linear-gradient(135deg, #4e73df 0%, #224abe 100%)' 
                                : 'linear-gradient(135deg, #f64f59 0%, #c471ed 100%)';
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-dynamic me-3" style="background: {{ $avatarGradient }};">
                                        <span>{{ strtoupper(substr($technicien->nom_techniciens, 0, 1) . substr($technicien->prenom_techniciens, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $technicien->nom_techniciens }} {{ $technicien->prenom_techniciens }}</div>
                                        <div class="text-primary-soft-dark small fw-medium">Expert #{{ str_pad($technicien->id_technicien, 3, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium"><i class="bi bi-telephone me-2 text-muted small"></i>{{ $technicien->telephone_technicien ?? 'N/A' }}</span>
                                    <span class="text-muted small"><i class="bi bi-envelope me-2 text-muted small"></i>{{ $technicien->email_technicien }}</span>
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
                                @if($isOccupied)
                                    <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger px-3">
                                        <i class="bi bi-dash-circle-fill me-1"></i> Occupé
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3">
                                        <i class="bi bi-check-circle-fill me-1"></i> Disponible
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-light text-dark border px-3 fw-semibold">
                                    {{ $technicien->specialite_technicien }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-stack">
                                    <a href="{{route('techniciens.show', $technicien->id_technicien)}}" class="action-btn view" title="Voir profil">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <a href="{{route('techniciens.edit', $technicien->id_technicien)}}" class="action-btn edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="action-btn delete border-0" data-bs-toggle="modal" data-bs-target="#Supprimer{{ $technicien->id_technicien }}" title="Supprimer">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de suppression --}}
                        @if(auth()->user() && auth()->user()->role === 'admin')
                        <div class="modal fade" id="Supprimer{{ $technicien->id_technicien }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-body text-center p-5">
                                        <div class="delete-warning-icon mb-4">
                                            <i class="bi bi-exclamation-triangle text-danger display-4"></i>
                                        </div>
                                        <h4 class="fw-bold mb-3">Supprimer le technicien ?</h4>
                                        <p class="text-muted">Voulez-vous retirer <strong>{{ $technicien->nom_techniciens }} {{ $technicien->prenom_techniciens }}</strong> ?<br><small>Cette action est irréversible.</small></p>
                                        <div class="d-flex gap-2 justify-content-center mt-4">
                                            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('techniciens.destroy', $technicien->id_technicien) }}" method="POST">
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
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-folder-x display-1 text-light"></i>
                                    <p class="mt-3 text-muted fw-medium">Aucun technicien trouvé.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($techniciens->hasPages())
            <div class="pagination-footer py-4 d-flex justify-content-center border-top">
                <div class="custom-pagination">
                    {{ $techniciens->appends(['search' => request('search')])->links() }}
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

    .icon-box {
        padding: 10px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* --- Barre de Recherche --- */
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
    .table-custom tbody tr:hover { background-color: #fbfcfe !important; transform: scale(1.002); }

    /* --- Avatars Dynamiques --- */
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

    /* --- Statuts Tags --- */
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

    /* --- Actions --- */
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

    .table-responsive::-webkit-scrollbar { display: none; }
    nav p.text-sm { display: none !important; }
</style>
@endsection