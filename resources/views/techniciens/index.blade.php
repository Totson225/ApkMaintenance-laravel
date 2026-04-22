@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
     
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-person-fill-gear me-2"></i>Liste des Techniciens
            </h5>

            <form class="d-flex" role="search" action="{{ route('techniciens.index') }}" method="GET">
                <input class="form-control me-2" 
                    name="search" 
                    type="search" 
                    placeholder="Nom, Prenom, spécia..." 
                    aria-label="Search" 
                    value="{{ request('search') }}"/>
                <button class="btn btn-outline-primary" type="submit">Recherche</button>
            </form>

            @if(auth()->user() && auth()->user()->role === 'admin')
                  <a href="{{route('techniciens.create')}}" class="btn btn-primary btn-sm">Nouveau Technicien</a>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Nom & Prénoms</th>
                            <th>Contact</th>
                            <th>Sexe</th>
                            <th>Statut</th>
                            <th>Spécialité</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($techniciens as $technicien)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px; border: 1px solid #e0e0e0;">
                                            {{ strtoupper(substr($technicien->nom_techniciens, 0, 1) . substr($technicien->prenom_techniciens, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $technicien->nom_techniciens }} {{ $technicien->prenom_techniciens }}</div>
                                            <small class="text-muted">{{ $technicien->email_technicien }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info px-2 py-1">
                                        {{ $technicien->telephone_technicien ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if(strtolower($technicien->sexe_techniciens) == 'masculin')
                                        <span class="text-primary"><i class="bi bi-gender-male"></i> Masculin</span>
                                    @else
                                        <span class="text-danger"><i class="bi bi-gender-female"></i> Féminin</span>
                                    @endif
                                </td>
                                <td>
                                    @if(strtolower($technicien->statut_tech) == 'occuper')
                                        <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger">
                                            <i class="bi bi-dash-circle-fill me-1"></i> Occupé
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-success-subtle text-success border border-success">
                                            <i class="bi bi-check-circle-fill me-1"></i> Disponible
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $technicien->specialite_technicien }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{route('techniciens.show', $technicien->id_technicien)}}" class="btn btn-outline-light btn-sm text-black border" title="Voir"><i class="bi bi-eye"></i></a>
                                        
                                        @if(auth()->user() && auth()->user()->role === 'admin')
                                            <a href="{{route('techniciens.edit', $technicien->id_technicien)}}" class="btn btn-outline-light btn-sm text-black border" title="Modifier"><i class="bi bi-pencil"></i></a>
                                                    <button type="button" class="btn btn-outline-light btn-sm text-danger border" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#Supprimer{{ $technicien->id_technicien }}" 
                                                            title="Supprimer">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>

                                                    <div class="modal fade" id="Supprimer{{ $technicien->id_technicien }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header border-0">
                                                                    <h5 class="modal-title fw-bold">Confirmer la suppression</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center py-4">
                                                                    <i class="bi bi-exclamation-triangle text-danger display-4 mb-3"></i>
                                                                    <p class="mb-0">Voulez-vous vraiment supprimer le technicien :</p>
                                                                    <h5 class="fw-bold">{{ $technicien->nom_techniciens }} {{ $technicien->prenom_techniciens }} ?</h5>
                                                                    <small class="text-muted">Cette action est irréversible.</small>
                                                                </div>
                                                                <div class="modal-footer border-0 justify-content-center">
                                                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
                                                                    
                                                                    <form action="{{ route('pieces.destroy', $technicien->id_technicien) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger px-4">Supprimer définitivement</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-folder-x display-4"></i>
                                        <p class="mt-2">Aucun technicien trouvé.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> 

        @if($techniciens->hasPages())
            <div class="card-footer bg-white border-top-0 py-4">
                <div class="d-flex d-flex justify-content-center align-items-center flex-wrap gap-3">
                    <div class="custom-pagination">
                        {{ $techniciens->appends(['search' => request('search')])->links() }}
                    </div>
                </div>
            </div>
        @endif

</div>
<style>

    /* style pagi */
    .custom-pagination .pagination {
        margin-bottom: 0;
        gap: 5px; 
    }


    .custom-pagination .page-link {
        border: none;
        border-radius: 8px !important;
        padding: 8px 16px;
        color: #4e73df;
        background-color: #f8f9fc;
        transition: all 0.3s ease;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }


    .custom-pagination .page-link:hover {
        background-color: #4e73df;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.2);
    }


    .custom-pagination .page-item.active .page-link {
        background-color: #4e73df;
        color: white;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
    }


    .custom-pagination .page-item.disabled .page-link {
        background-color: #f1f3f9;
        color: #b7c1d1;
    }


    .custom-pagination .page-link aria-hidden {
        font-weight: bold;
    }

    /* Phrase non */
    .pagination nav .flex.items-center.justify-between div:first-child {
    display: none !important;
    }

    .custom-pagination nav div p {
        display: none !important;
    }
</style>
@endsection