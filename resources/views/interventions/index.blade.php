@extends('layouts.app')

@section('content')


<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary fw-bold ">
                <i class="bi bi-journals me-2"></i>Liste des Interventions
            </h5>
            <form class="d-flex" role="search" action="{{ route('interventions.index') }}" method="GET">
                <input class="form-control me-2" 
                    name="search" 
                    type="search" 
                    placeholder="Date Demande, Pan..." 
                    aria-label="Search" 
                    value="{{ request('search') }}"/>
                <button class="btn btn-outline-primary" type="submit">Recherche</button>
            </form>
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{route('interventions.create')}}" class="btn btn-primary btn-sm">Nouvelle Intervention</a>
            @endif
        </div>
    </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Date Demande</th>
                            <th>Date Intervention</th>
                            <th>Description Panne</th>
                            <th>Solution Apportée</th>
                            <th>Type</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($interventions as $intervention)
                        <tr>
                            <td class="ps-4">
                                {{ $intervention->date_demande }}
                            </td>
                            <td>{{ $intervention->date_intervention ?? 'En attente' }}</td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                    {{ $intervention->descript_panne }}
                                </span>
                            </td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                    {{ $intervention->solution_apportee ?? 'Aucune solution apportee' }}
                                </span>
                            </td>
                            <td> 
                                @if(strtolower($intervention->type_intervention) == 'préventive')
                                    {{-- Type Préventive --}}
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success">
                                        <i class="bi bi-shield-check me-1"></i> Préventive
                                    </span>
                                @else
                                    {{-- Type Corrective --}}
                                    <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Corrective
                                    </span>
                                @endif
                            </td>
                            </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{route('interventions.show', $intervention->id_Intervtion)}}" class="btn btn-outline-light btn-sm text-black border" title="Voir">
                                           <i class="bi bi-eye"></i>
                                        </a>
                                         @if(auth()->user() && auth()->user()->role === 'admin')
                                             <a href="{{route('interventions.edit', $intervention->id_Intervtion)}}" class="btn btn-outline-light btn-sm text-black border" title="Modifier">
                                                  <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('interventions.destroy', $intervention->id_Intervtion) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-outline-light btn-sm text-danger border" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#Supprimer{{ $intervention->id_Intervtion }}" 
                                                            title="Supprimer">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>

                                                    <div class="modal fade" id="Supprimer{{ $intervention->id_Intervtion }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header border-0">
                                                                    <h5 class="modal-title fw-bold">Confirmer la suppression</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center py-4">
                                                                    <i class="bi bi-exclamation-triangle text-danger display-4 mb-3"></i>
                                                                    <p class="mb-0">Voulez-vous vraiment supprimer l'intervention du :</p>
                                                                    <h5 class="fw-bold">{{ $intervention->date_intervention }} ({{ $intervention->descript_panne }}) ?</h5>
                                                                    <small class="text-muted">Cette action est irréversible.</small>
                                                                </div>
                                                                <div class="modal-footer border-0 justify-content-center">
                                                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
                                                                    
                                                                    <form action="{{ route('interventions.destroy', $intervention->id_Intervtion) }}" method="POST">
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
                            <td colspan="6" class="text-center py-4 text-muted">
                                <div class="text-muted">
                                 <i class="bi bi-folder-x display-4"></i>
                                 <p class="mt-2">Aucune intervention enregistrée.</p>
                                </div>      
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($interventions->hasPages())
            <div class="card-footer bg-white border-top-0 py-4">
                <div class="d-flex d-flex justify-content-center align-items-center flex-wrap gap-3">
                    <div class="custom-pagination">
                        {{ $interventions->appends(['search' => request('search')])->links() }}
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
