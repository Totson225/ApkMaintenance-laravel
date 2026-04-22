@extends('layouts.app')

@section('content')

            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        
                        {{-- En-tête --}}
                        <div class="d-flex align-items-center mb-4">
                            <h4 class="mb-0 fw-bold text-primary">Modifier l'intervention</h4>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <form action="{{ route('interventions.update', $intervention->id_Intervtion) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        {{-- Date Demande --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="date_demande" class="form-label fw-bold small text-muted">DATE DEMANDE</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event"></i></span>
                                                <input type="date" name="date_demande" id="date_demande" 
                                                    value="{{ old('date_demande', $intervention->date_demande ? \Carbon\Carbon::parse($intervention->date_demande)->format('Y-m-d') : '') }}" 
                                                    class="form-control bg-light border-start-0 @error('date_demande') is-invalid @enderror">
                                            </div>
                                            @error('date_demande')
                                                <div class="text-danger small mt-1">{{ '!!! Veuillez choisir une date' }}</div>
                                            @enderror
                                        </div>

                                        {{-- Date Intervention --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="date_intervention" class="form-label fw-bold small text-muted">DATE INTERVENTION</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event"></i></span>
                                                <input type="date" name="date_intervention" id="date_intervention" 
                                                    value="{{ old('date_intervention', date('Y-m-d'), $intervention->date_intervention) }}" 
                                                    class="form-control bg-light border-start-0 @error('date_intervention') is-invalid @enderror">
                                            </div>
                                            @error('date_intervention')
                                                <div class="text-danger small mt-1">{{ '!!! Veuillez choisir une date' }}</div>
                                            @enderror
                                        </div>

                                        {{-- Type Intervention --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="type_intervention" class="form-label fw-bold small text-muted">TYPE D'INTERVENTION</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-gear-wide-connected"></i> 
                                                </span>
                                                <select class="form-select bg-light @error('type_intervention') is-invalid @enderror" name="type_intervention" id="type_intervention">
                                                    <option selected disabled value="">Choisir...</option>
                                                    <option value="Corrective" {{ old('type_intervention', $intervention->type_intervention) == 'Corrective' ? 'selected' : '' }}>Corrective (Panne)</option>
                                                    <option value="Préventive" {{ old('type_intervention', $intervention->type_intervention) == 'Préventive' ? 'selected' : '' }}>Préventive (Entretien)</option> 
                                                </select>
                                            </div>
                                            @error('type_intervention')
                                                <div class="text-danger small mt-1">{{ '!!! Veuillez choisir un type' }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Sélection du Demandeur--}}
                                    <div class="mb-3">
                                        <label for="id_utilisateur" class="form-label fw-bold small text-muted">DEMANDEUR</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person-check"></i>
                                            </span>
                                            <select class="form-select bg-light border-start-0 @error('id_utilisateur') is-invalid @enderror" name="id_utilisateur" id="id_utilisateur">
                                                <option selected disabled value="">Sélectionner le demandeur...</option>
                                        @foreach($demandeurs as $demandeur)
                                            <option value="{{ $demandeur->id_utilisateur }}"
                                                {{ (old('id_utilisateur', $intervention->id_utilisateur) == $demandeur->id_utilisateur) ? 'selected' : '' }}>
                                                {{ $demandeur->nom_demandeur }} {{ $demandeur->prenom_demandeur }}
                                            </option>
                                        @endforeach
                                            </select>
                                        </div>
                                        @error('id_utilisateur')
                                            <div class="text-danger small mt-1">{{ '!!! Veuillez sélectionner un demandeur' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Sélection de l'Appareil--}}
                                    <div class="mb-3">
                                        <label for="id_appareil" class="form-label fw-bold small text-muted">APPAREIL</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-laptop"></i>
                                            </span>
                                            <select class="form-select bg-light border-start-0 @error('id_appareil') is-invalid @enderror" name="id_appareil" id="id_appareil">
                                                <option selected disabled value="">Sélectionner l'appareil...</option>
                                        @foreach($appareils as $appareil)
                                            <option value="{{ $appareil->id_appareil }}"
                                                {{ (old('id_appareil', $intervention->id_appareil) == $appareil->id_appareil) ? 'selected' : '' }}>
                                                {{ $appareil->nom_appareil }} {{ $appareil->marque_appareil }}
                                            </option>
                                        @endforeach
                                            </select>
                                        </div>
                                        @error('id_appareil')
                                            <div class="text-danger small mt-1">{{ '!!! Veuillez sélectionner un appareil' }}</div>
                                        @enderror
                                    </div>

                                    {{-- technicien --}}
                                    <div class="mb-3">
                                        <label for="techniciens" class="form-label fw-bold small text-muted">TECHNICIENS ASSIGNÉ(S)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-laptop"></i>
                                            </span>
                                            <select class="form-select bg-light @error('techniciens') is-invalid @enderror" 
                                                    name="techniciens[]" id="techniciens" multiple>                                                
                                                    <option selected disabled value="">Sélectionner le technicien...</option>
                                            @foreach($techniciens as $tech)
                                                <option value="{{ $tech->id_technicien }}" 
                                                    {{ (collect(old('techniciens', $intervention->techniciens->pluck('id_technicien')->toArray()))->contains($tech->id_technicien)) ? 'selected' : '' }}>
                                                    {{ $tech->nom_techniciens }} {{ $tech->prenom_techniciens }}
                                                </option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <small class="text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs techniciens.</small>
                                        @error('id_technicien')
                                            <div class="text-danger small mt-1">{{ '!!! Veuillez sélectionner un technicien' }}</div>
                                        @enderror
                                    </div>


                                    {{-- materiel --}}
                                    <div class="mb-3">
                                        <label for="materiels" class="form-label fw-bold small text-muted">MATERIEL UTILISÉ(S)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-laptop"></i>
                                            </span>
                                            <select class="form-select bg-light @error('materiels') is-invalid @enderror" 
                                                    name="materiels[]" id="materiels" multiple>                                                
                                                    <option selected disabled value="">Sélectionner le matériel...</option>
                                                    @foreach($materiels as $mat)
                                                        <option value="{{ $mat->Id_materiel }}"
                                                            {{ (collect(old('materiels', $intervention->materiels->pluck('Id_materiel')->toArray()))->contains($mat->Id_materiel)) ? 'selected' : '' }}>
                                                            {{ $mat->type_materiel }} {{ $mat->marque }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <small class="text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs matériels.</small>
                                        @error('materiels[]')
                                            <div class="text-danger small mt-1">{{ '!!! Veuillez sélectionner un materiel' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Description de la Panne --}}
                                    <div class="mb-4">
                                        <label for="descript_panne" class="form-label fw-bold small text-muted">DESCRIPTION DE LA PANNE</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-exclamation-triangle"></i>
                                            </span>
                                            <textarea name="descript_panne" id="descript_panne" rows="3" 
                                                    placeholder="Expliquez le problème technique..." 
                                                    class="form-control bg-light border-start-0 @error('descript_panne') is-invalid @enderror">{{ old('descript_panne', $intervention->descript_panne) }}</textarea>
                                        </div>
                                        @error('descript_panne')
                                            <div class="text-danger small mt-1">{{ '!!! Veuillez décrire la panne' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Solution Apportee --}}

                                    <div class="mb-4">
                                        <label for="solution_apportee" class="form-label fw-bold small text-muted">SOLUTION APPORTEE</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-wrench-adjustable"></i>
                                            </span>
                                            <textarea name="solution_apportee" id="solution_apportee" rows="3" 
                                                    placeholder="Expliquez comment vous avez resolu le probleme..."
                                                    class="form-control bg-light border-start-0 @error('solution_apportee') is-invalid @enderror">{{ old('solution_apportee', $intervention->solution_apportee) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="d-grid shadow-sm">
                                        <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                            <i class="i bi-save me-2"></i>Modifier l'intervention
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection