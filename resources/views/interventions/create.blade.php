@extends('layouts.app')

@section('title', 'AppliMaintenance | Intervention')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- En-tête avec bouton retour --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-0">
                        <i class="bi bi-journals me-2"></i>Nouvelle Intervention
                    </h3>
                    <p class="text-muted small">Enregistrez les détails techniques de l'intervention de maintenance.</p>
                </div>
                <a href="{{ route('interventions.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>

            <form action="{{ route('interventions.store') }}" method="post">
                @csrf
                
                <div class="row g-4">
                    {{-- Section 1 : Informations Générales --}}
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3 small text-uppercase text-primary border-bottom pb-2">Planification</h5>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Date de Demande</label>
                                    <input type="date" name="date_demande" value="{{ old('date_demande', date('Y-m-d')) }}" 
                                        class="form-control @error('date_demande') is-invalid @enderror">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Date d'Intervention</label>
                                    <input type="date" name="date_intervention" value="{{ old('date_intervention', date('Y-m-d')) }}" 
                                        class="form-control @error('date_intervention') is-invalid @enderror">
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-semibold small">Type d'Intervention</label>
                                    <select class="form-select @error('type_intervention') is-invalid @enderror" name="type_intervention">
                                        <option selected disabled>Choisir...</option>
                                        <option value="Corrective" {{ old('type_intervention') == 'Corrective' ? 'selected' : '' }}>🚨 Corrective (Panne)</option>
                                        <option value="Préventive" {{ old('type_intervention') == 'Préventive' ? 'selected' : '' }}>🛠️ Préventive (Entretien)</option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2 : Acteurs & Matériel --}}
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3 small text-uppercase text-primary border-bottom pb-2">Assignation & Appareil</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold small">Demandeur</label>
                                        <select class="form-select select-search" name="id_utilisateur">
                                            <option selected disabled>Qui a demandé ?</option>
                                            @foreach($demandeurs as $demandeur)
                                                <option value="{{ $demandeur->id_utilisateur }}">
                                                    {{ $demandeur->nom_demandeur }} {{ $demandeur->prenom_demandeur }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold small">Appareil concerné</label>
                                        <select class="form-select select-search" name="id_appareil">
                                            <option selected disabled>Sélectionner l'appareil...</option>
                                            @foreach($appareils as $appareil)
                                                <option value="{{ $appareil->id_appareil }}">
                                                    {{ $appareil->nom_appareil }} {{ $appareil->type_appareil }} ({{ $appareil->marque_appareil }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-semibold small">Technicien(s) en charge</label>
                                    <select class="form-select select-multiple" name="techniciens[]" multiple>
                                        @foreach($techniciens as $tech)
                                            <option value="{{ $tech->id_technicien }}">
                                                {{ $tech->nom_techniciens }} ({{ $tech->statut_tech }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-info small"><i class="bi bi-info-circle"></i> Plusieurs choix possibles.</div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3 small text-uppercase text-primary border-bottom pb-2">Ressources utilisées</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold small">Outillage / Matériel</label>
                                        <select class="form-select select-multiple" name="materiels[]" multiple>
                                            @foreach($materiels as $mat)
                                                <option value="{{ $mat->Id_materiel }}">{{ $mat->type_materiel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold small">Pièces de rechange</label>
                                        <select class="form-select select-multiple" name="pieces[]" multiple>
                                            @foreach($pieces as $pie)
                                                <option value="{{ $pie->id_PRechange }}">{{ $pie->Nom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-text text-info small"><i class="bi bi-info-circle"></i> Plusieurs choix possibles.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3 : Détails Techniques --}}
                    <div class="col-12">
                        <div class="card shadow-sm border-0 pt-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-danger small"><i class="bi bi-bug me-1"></i>DESCRIPTION DE LA PANNE</label>
                                        <textarea name="descript_panne" rows="4" class="form-control border-danger-subtle bg-light-subtle" placeholder="Décrivez le symptôme ou le problème constaté...">{{ old('descript_panne') }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-success small"><i class="bi bi-check-circle me-1"></i>SOLUTION APPORTÉE</label>
                                        <textarea name="solution_apportee" rows="4" class="form-control border-success-subtle bg-light-subtle" placeholder="Détaillez les actions menées pour résoudre le problème...">{{ old('solution_apportee') }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-4 border-top pt-4 text-end">
                                    <button type="reset" class="btn btn-light border me-2">Effacer</button>
                                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                                        <i class="bi bi-cloud-upload me-2"></i>Finaliser l'enregistrement
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Style additionnel pour peaufiner l'apparence --}}
<style>
    .card { border-radius: 15px; transition: transform 0.2s; }
    .form-control:focus, .form-select:focus { 
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border-color: #0d6efd;
    }
    .select-multiple { min-height: 100px; }
    body { background-color: #f0f2f5; }
</style>
@endsection