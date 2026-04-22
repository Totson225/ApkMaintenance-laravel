@extends('layouts.app')

@section('content')


        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="mb-0 fw-bold text-primary">Modifier un appareil</h4>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <form action="{{ route('appareils.update', $appareil->id_appareil) }}" method="post">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    {{-- Nom --}} 
                                    <div class="col-md-6 mb-3">
                                        <label for="nom_appareil" class="form-label fw-bold small text-muted">NOM</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-cpu"></i></span>
                                            <input type="text" name="nom_appareil" id="nom_appareil" placeholder="LaserJet Pro 400" 
                                                value="{{ old('nom_appareil', $appareil->nom_appareil) }}" 
                                                class="form-control bg-light border-start-0 @error('nom_appareil') is-invalid @enderror">
                                        </div>
                                        @error('nom_appareil')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer un nom' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Marque --}} 
                                    <div class="col-md-6 mb-3">
                                        <label for="marque_appareil" class="form-label fw-bold small text-muted">MARQUE</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-patch-check"></i>
                                            </span>
                                            <input type="text" name="marque_appareil" id="marque_appareil" placeholder="HP" 
                                                value="{{ old('marque_appareil', $appareil->marque_appareil) }}" 
                                                class="form-control bg-light border-start-0 @error('marque_appareil') is-invalid @enderror">
                                            @error('marque_appareil')
                                                <div class="text-danger small mt-1">{{ '!!!Veillez entrer la marque' }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Type de l'appareil --}} 
                                    <div class="col-md-6 mb-3">
                                        <label for="type_appareil" class="form-label fw-bold small text-muted">TYPE</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-hdd-network"></i></span>
                                            <input type="text" name="type_appareil" id="type_appareil" placeholder="Imprimante" 
                                                value="{{ old('type_appareil', $appareil->type_appareil) }}" 
                                                class="form-control bg-light border-start-0 @error('type_appareil') is-invalid @enderror">
                                        </div>
                                        @error('type_appareil')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer un numero un type' }}</div>
                                        @enderror
                                    </div>

                                    {{-- ETAT --}} 
                                <div class="col-md-6 mb-3">
                                    <label for="etat_appareil" class="form-label fw-bold small text-muted">ETAT</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-shield-shaded"></i>
                                        </span>
                                        
                                        <select name="etat_appareil" id="etat_appareil" 
                                                class="form-select bg-light border-start-0 @error('etat_appareil') is-invalid @enderror">
                                            <option value="Reparer" {{ old('etat_appareil', $appareil->etat_appareil) == 'Reparer' ? 'selected' : '' }}>Réparé</option>
                                            <option value="Endommager" {{ old('etat_appareil', $appareil->etat_appareil) == 'Endommager' ? 'selected' : '' }}>Endommagé</option>
                                        </select>
                                    </div>
                                    
                                    @error('etat_appareil')
                                        <div class="text-danger small mt-1">{{ '!!! Veuillez choisir un état' }}</div>
                                    @enderror
                                </div>

                                {{-- COULEUR --}} 
                                <div class="mb-3">
                                    <label for="couleur_appareil" class="form-label fw-bold small text-muted">COULEUR</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-palette"></i></span>
                                        <input type="text" name="couleur_appareil" id="couleur_appareil" placeholder="Noir" 
                                            value="{{ old('couleur_appareil', $appareil->couleur_appareil) }}" 
                                            class="form-control bg-light border-start-0 @error('couleur_appareil') is-invalid @enderror">
                                    </div>
                                    @error('couleur_appareil')
                                        <div class="text-danger small mt-1">{{ '!!!Veillez entrer une couleur' }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">DEMANDEUR</label>
                                    <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person "></i></span>
                                    <select name="id_utilisateur" class="form-select border-start-0 bg-light">
                                        @foreach($demandeurs as $demandeur)
                                            <option value="{{ $demandeur->id_utilisateur }}" 
                                                {{ (old('id_utilisateur', $appareil->id_utilisateur) == $demandeur->id_utilisateur) ? 'selected' : '' }}>
                                                {{ $demandeur->nom_demandeur }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <div class="d-grid shadow-sm">
                                    <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                        <i class="bi bi-save me-2"></i>Modifier l'appareil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection