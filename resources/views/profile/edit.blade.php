@extends('layouts.app')

@section('title', 'AppliMaintenance | Profile')

@section('content')
<div class="container py-5">
    {{-- Header Section --}}
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-black text-dark mb-1">
                        {{ __('Paramètres du Profil') }}
                    </h2>
                    <p class="text-muted mb-0">Gérez vos informations personnelles et la sécurité de votre compte.</p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                        <i class="bi bi-shield-check me-1"></i> Compte Sécurisé
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- Section : Informations Personnelles --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-shape bg-soft-primary text-primary rounded-3 me-3 p-2">
                            <i class="bi bi-person-vcard fs-4"></i>
                        </div>
                        <h4 class="mb-0 fw-bold">Informations Publiques</h4>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Section : Sécurité --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-shape bg-soft-warning text-warning rounded-3 me-3 p-2">
                            <i class="bi bi-lock fs-4"></i>
                        </div>
                        <h4 class="mb-0 fw-bold">Mot de passe</h4>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Section : Mes Interventions --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-shape bg-soft-info text-info rounded-3 me-3 p-2">
                            <i class="bi bi-tools fs-4"></i>
                        </div>
                        <h4 class="mb-0 fw-bold">Mes Interventions Assignées</h4>
                    </div>

                    @if($interventions->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard-x fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">Aucune intervention ne vous est assignée pour le moment.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Référence</th>
                                        <th>Panne</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($interventions as $intervention)
                                        <tr>
                                            <td class="fw-bold">#{{ $intervention->id_Intervtion }}</td>
                                            <td>{{ Str::limit($intervention->descript_panne, 30) }}</td>
                                            <td>{{ $intervention->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if($intervention->solution_apportee && $intervention->solution_apportee !== "Aucune solution apportee")
                                                    <span class="badge rounded-pill bg-success">Terminé</span>
                                                @else
                                                    <span class="badge rounded-pill bg-warning text-dark">En cours</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('interventions.show', $intervention->id_Intervtion) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                                    Voir détails
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Petites touches CSS pour le polish */
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .card { transition: transform 0.2s ease; }
    .fw-black { font-weight: 800; }
    hr { border-top: 1px solid #eee; }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
</style>
@endsection