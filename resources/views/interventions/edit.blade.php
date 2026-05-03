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
                        <i class="bi bi-pencil-square me-2 text-primary"></i>Modifier l'Intervention
                    </h3>
                    <p class="text-muted small">Mise à jour des détails techniques de l'intervention #{{ $intervention->id_Intervtion }}</p>
                </div>
                <a href="{{ route('interventions.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>

            <form action="{{ route('interventions.update', $intervention->id_Intervtion) }}" method="post">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    {{-- Section 1 : Informations Générales --}}
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3 small text-uppercase text-primary border-bottom pb-2">Planification</h5>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Date de Demande</label>
                                    <input type="date" name="date_demande" 
                                        value="{{ old('date_demande', $intervention->date_demande ? \Carbon\Carbon::parse($intervention->date_demande)->format('Y-m-d') : '') }}" 
                                        class="form-control @error('date_demande') is-invalid @enderror">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Date d'Intervention</label>
                                    <input type="date" name="date_intervention" 
                                        value="{{ old('date_intervention', $intervention->date_intervention ? \Carbon\Carbon::parse($intervention->date_intervention)->format('Y-m-d') : '') }}" 
                                        class="form-control @error('date_intervention') is-invalid @enderror">
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-semibold small">Type d'Intervention</label>
                                    <select class="form-select @error('type_intervention') is-invalid @enderror" name="type_intervention">
                                        <option disabled>Choisir...</option>
                                        <option value="Corrective" {{ old('type_intervention', $intervention->type_intervention) == 'Corrective' ? 'selected' : '' }}>🚨 Corrective (Panne)</option>
                                        <option value="Préventive" {{ old('type_intervention', $intervention->type_intervention) == 'Préventive' ? 'selected' : '' }}>🛠️ Préventive (Entretien)</option> 
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
                                            @foreach($demandeurs as $demandeur)
                                                <option value="{{ $demandeur->id_utilisateur }}"
                                                    {{ old('id_utilisateur', $intervention->id_utilisateur) == $demandeur->id_utilisateur ? 'selected' : '' }}>
                                                    {{ $demandeur->nom_demandeur }} {{ $demandeur->prenom_demandeur }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold small">Appareil concerné</label>
                                        <select class="form-select select-search" name="id_appareil">
                                            @foreach($appareils as $appareil)
                                                <option value="{{ $appareil->id_appareil }}"
                                                    {{ old('id_appareil', $intervention->id_appareil) == $appareil->id_appareil ? 'selected' : '' }}>
                                                    {{ $appareil->nom_appareil }} ({{ $appareil->marque_appareil }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-semibold small">Technicien(s) en charge</label>
                                    <select class="form-select select-multiple" name="techniciens[]" multiple>
                                        @foreach($techniciens as $tech)
                                            <option value="{{ $tech->id_technicien }}"
                                                {{ collect(old('techniciens', $intervention->techniciens->pluck('id_technicien')->toArray()))->contains($tech->id_technicien) ? 'selected' : '' }}>
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
                                                <option value="{{ $mat->Id_materiel }}"
                                                    {{ collect(old('materiels', $intervention->materiels->pluck('Id_materiel')->toArray()))->contains($mat->Id_materiel) ? 'selected' : '' }}>
                                                    {{ $mat->type_materiel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold small">Pièces de rechange</label>
                                        <select class="form-select select-multiple" name="pieces[]" multiple>
                                            @foreach($pieces as $pie)
                                                <option value="{{ $pie->id_PRechange }}"
                                                    {{ collect(old('pieces', $intervention->pieces->pluck('id_PRechange')->toArray()))->contains($pie->id_PRechange) ? 'selected' : '' }}>
                                                    {{ $pie->Nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-text text-info small"><i class="bi bi-info-circle"></i> Plusieurs choix possibles.</div>
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
                                        <textarea name="descript_panne" rows="4" class="form-control border-danger-subtle bg-light-subtle">{{ old('descript_panne', $intervention->descript_panne) }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-success small"><i class="bi bi-check-circle me-1"></i>SOLUTION APPORTÉE</label>
                                        <textarea name="solution_apportee" rows="4" class="form-control border-success-subtle bg-light-subtle">{{ old('solution_apportee', $intervention->solution_apportee) }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-4 border-top pt-4 text-end">
                                    <a href="{{ route('interventions.index') }}" class="btn btn-light border me-2">Annuler</a>
                                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                                        <i class="bi bi-save me-2"></i>Mettre à jour l'intervention
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

<style>
    .card { border-radius: 15px; }
    .form-control:focus, .form-select:focus { 
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border-color: #0d6efd;
    }
    .select-multiple { min-height: 120px; }
    body { background-color: #f0f2f5; }
</style>
@endsection