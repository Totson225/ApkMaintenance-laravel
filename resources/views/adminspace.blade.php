@extends('layouts.app')

@section('title', 'AppliMaintenance | AdminSpace')

@section('content')
<div class="container-fluid py-4 px-lg-5">
    
    {{-- Header avec Statistiques --}}
    <header class="row align-items-center mb-5 mt-2">
        <div class="col-md-6">
            <h1 class="fw-black text-dark tracking-tight mb-1">
                Espace <span class="text-primary text-gradient">Administrateur</span>
            </h1>
            <p class="text-muted mb-0">Pilotez les accès et supervisez la communauté.</p>
        </div>
        <div class="col-md-6 d-flex justify-content-md-end mt-3 mt-md-0 gap-3">
            <div class="stat-card px-4 py-2 border-end">
                <span class="d-block text-muted small text-uppercase fw-bold">Total</span>
                <span class="h4 fw-bold mb-0 text-dark">{{ $users->total() }}</span>
            </div>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('register') }}" class="btn btn-primary shadow-sm rounded-pill px-4 d-flex align-items-center">
                    <i class="bi bi-person-plus-fill me-2 fs-5"></i> Nouveau Membre
                </a>
            @endif
        </div>
    </header>

    {{-- Alertes --}}
    @if(session('success'))
        <div class="alert alert-soft-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @elseif (session('status'))
        <div class="alert alert-soft-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>{{ session('status') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Dashboard Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-4 px-4">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="fw-bold mb-0">Répertoire des comptes</h5>
                </div>
                <div class="col-auto">
                    <form action="{{ route('adminspace') }}" method="GET" class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="search" name="search" class="form-control ps-5 rounded-pill border-light bg-light" 
                               placeholder="Chercher un profil..." value="{{ request('search') }}">
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-subtle border-bottom">
                    <tr>
                        <th class="ps-4 py-3 fw-bold text-muted small text-uppercase">Identité</th>
                        <th class="py-3 fw-bold text-muted small text-uppercase">Rôle & Permissions</th>
                        <th class="py-3 fw-bold text-muted small text-uppercase">Date d'inscription</th>
                        <th class="py-3 text-end pe-4 fw-bold text-muted small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="user-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-container me-3">
                                        <div class="avatar-initials rounded-circle shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(strtolower($user->role) == 'admin')
                                    <span class="badge-role admin">
                                        <i class="bi bi-shield-check me-1"></i> Administrateur
                                    </span>
                                @else
                                    <span class="badge-role user">
                                        <i class="bi bi-person me-1"></i> Utilisateur
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $user->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                    <button class="btn btn-white btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#Supprimer{{ $user->id }}" title="Supprimer">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>

                                {{-- Modal de confirmation optimisé --}}

                                <div class="modal fade" id="Supprimer{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                            <div class="modal-body text-center p-5">
                                                <div class="delete-warning-icon mb-4">
                                                    <i class="bi bi-exclamation-triangle text-danger display-4"></i>
                                                </div>
                                                <h4 class="text-muted mb-3">Voulez-vous supprimer le compte de <strong> {{ $user->name }} </strong>?</h4>
                                                <p><small>!!! Cette action est irréversible.</small></p>
                                                <div class="d-flex gap-2 justify-content-center mt-4">
                                                    <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger px-4 rounded-pill">Confirmer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/gray/fogg-no-messages.png" alt="Vide" style="width: 150px;" class="mb-3">
                                    <p class="text-muted">Aucun utilisateur ne correspond à votre recherche.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <div class="card-footer bg-light-subtle border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted">Affichage de {{ $users->count() }} sur {{ $users->total() }}</span>
                <div>{{ $users->appends(request()->input())->links() }}</div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Typographie & Couleurs */
    .fw-black { font-weight: 900; letter-spacing: -1px; }
    .text-gradient { background: linear-gradient(45deg, #0d6efd, #0dcaf0); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .bg-light-subtle { background-color: #f8f9fa !important; }
    
    /* Avatars */
    .avatar-container { position: relative; }
    .avatar-initials { 
        width: 42px; height: 42px; display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: white; font-weight: bold;
    }
    .status-indicator {
        position: absolute; bottom: 0; right: 0; width: 12px; height: 12px; border-radius: 50%;
    }

    /* Badges de Rôles modernisés */
    .badge-role {
        padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600;
    }
    .badge-role.admin { background-color: #e0f2fe; color: #0369a1; }
    .badge-role.user { background-color: #f3f4f6; color: #4b5563; }

    /* Table Effects */
    .user-row { transition: all 0.2s ease; }
    .user-row:hover { background-color: #fcfcfd !important; }
    .btn-white { background: white; border: 1px solid #edf2f7; }
    .btn-white:hover { background: #f8f9fa; }

    /* Alertes Soft */
    .alert-soft-success { background-color: #dcfce7; color: #166534; }

    /* Pagination Customization */
    .pagination { margin-bottom: 0; gap: 5px; }
    .page-link { border-radius: 8px !important; border: none; color: #4b5563; }
    .page-item.active .page-link { background-color: #0d6efd; box-shadow: 0 4px 6px -1px rgba(13, 110, 253, 0.4); }
</style>
@endsection