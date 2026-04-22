@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex align-items-center mb-4">
                <h4 class="mb-0 fw-bold text-primary">Enregistrer un appareil</h4>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('appareils.store') }}" method="post">
                        @csrf
                        
                        <div class="row">
                            {{-- Nom --}}
                            <div class="col-md-6 mb-3">
                                <label for="nom_appareil" class="form-label fw-bold small text-muted">NOM DE L'APPAREIL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-cpu"></i></span> 
                                    <input type="text" name="nom_appareil" id="nom_appareil" placeholder="LaserJet Pro 400" 
                                        value="{{ old('nom_appareil') }}" 
                                        class="form-control bg-light border-start-0 @error('nom_appareil') is-invalid @enderror">
                                </div>
                                @error('nom_appareil')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un nom</div>
                                @enderror
                            </div>

                            {{-- Marque --}}
                            <div class="col-md-6 mb-3">
                                <label for="marque_appareil" class="form-label fw-bold small text-muted">MARQUE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-patch-check"></i></span>
                                    <input type="text" name="marque_appareil" id="marque_appareil" placeholder="HP" 
                                        value="{{ old('marque_appareil') }}" 
                                        class="form-control bg-light border-start-0 @error('marque_appareil') is-invalid @enderror">
                                </div>
                                @error('marque_appareil')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer la marque</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Type de l'appareil --}}
                            <div class="col-md-6 mb-3">
                                <label for="type_appareil" class="form-label fw-bold small text-muted">TYPE D'APPAREIL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-hdd-network"></i></span> 
                                    <input type="text" name="type_appareil" id="type_appareil" placeholder="Imprimante" 
                                        value="{{ old('type_appareil') }}" 
                                        class="form-control bg-light border-start-0 @error('type_appareil') is-invalid @enderror">
                                </div>
                                @error('type_appareil')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un type</div>
                                @enderror
                            </div>

                            {{-- ETAT --}}
                            <div class="col-md-6 mb-3">
                                <label for="etat_appareil" class="form-label fw-bold small text-muted">ÉTAT ACTUEL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-shaded"></i></span>
                                    <select class="form-select bg-light border-start-0 @error('etat_appareil') is-invalid @enderror" name="etat_appareil" id="etat_appareil" required>
                                        <option selected disabled value="">Choisir...</option>
                                        <option value="Reparer" {{ old('etat_appareil') == 'r' ? 'selected' : '' }}>Réparé</option>
                                        <option value="Endommager" {{ old('etat_appareil') == 'e' ? 'selected' : '' }}>Endommagé</option>  
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Couleur --}}
                        <div class="mb-3">
                            <label for="couleur_appareil" class="form-label fw-bold small text-muted">COULEUR</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-palette"></i></span> 
                                <input type="text" name="couleur_appareil" id="couleur_appareil" placeholder="Noir" 
                                    value="{{ old('couleur_appareil') }}" 
                                    class="form-control bg-light border-start-0 @error('couleur_appareil') is-invalid @enderror">
                            </div>
                            @error('couleur_appareil')
                                <div class="text-danger small mt-1">!!! Veuillez entrer une couleur</div>
                            @enderror
                        </div>

                        {{-- DEMANDEUR --}}
                        <div class="mb-4">
                            <label for="id_utilisateur" class="form-label fw-bold small text-muted">DEMANDEUR</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span> 
                                <select name="id_utilisateur" id="id_utilisateur" class="form-select bg-light border-start-0">
                                    <option selected disabled value="">Assigner à un demandeur...</option>
                                    @foreach($demandeurs as $demandeur)
                                        <option value="{{ $demandeur->id_utilisateur }}" 
                                            {{ old('id_utilisateur') == $demandeur->id_utilisateur ? 'selected' : '' }}>
                                            {{ $demandeur->nom_demandeur }} {{ $demandeur->prenom_demandeur }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-grid shadow-sm">
                            <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                <i class="bi bi-save me-2"></i>Enregistrer l'appareil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection