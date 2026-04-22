@extends('layouts.app')

@section('content')


        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="mb-0 fw-bold text-primary">Modifier le demandeur</h4>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <form action="{{ route('demandeurs.update', $demandeur->id_utilisateur) }}" method="post">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    {{-- Nom --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="nom_demandeur" class="form-label fw-bold small text-muted">NOM</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                            <input type="text" name="nom_demandeur" id="nom_demandeur" placeholder="Siluer" 
                                                value="{{ old('nom_demandeur', $demandeur->nom_demandeur) }}" 
                                                class="form-control bg-light border-start-0 @error('nom_demandeur') is-invalid @enderror">
                                        </div>
                                        @error('nom_demandeur')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer un nom' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Prénom --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="prenom_demandeur" class="form-label fw-bold small text-muted">PRÉNOM(S)</label>
                                        <input type="text" name="prenom_demandeur" id="prenom_demandeur" placeholder="Periguegnon Sara" 
                                            value="{{ old('prenom_demandeur', $demandeur->prenom_demandeur) }}" 
                                            class="form-control bg-light @error('prenom_demandeur') is-invalid @enderror">
                                        @error('prenom_demandeur')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer un prenom' }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Téléphone --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="telephone_demandeur" class="form-label fw-bold small text-muted">TÉLÉPHONE</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="telephone_demandeur" id="telephone_demandeur" 
                                                value="{{ old('telephone_demandeur', $demandeur->telephone_demandeur) }}" 
                                                class="form-control bg-light border-start-0 @error('telephone_demandeur') is-invalid @enderror">
                                        </div>
                                        @error('telephone_demandeur')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer un numero de telephone' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Sexe --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="sexe_demandeurs" class="form-label fw-bold small text-muted">SEXE</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-gender-ambiguous"></i> 
                                            </span>
                                        <select class="form-select bg-light border-start-0 @error('sexe_demandeurs') is-invalid @enderror" name="sexe_demandeurs" id="sexe_demandeurs" required>
                                            <option selected disabled value="">Choisir...</option>
                                            <option value="Masculin" {{ old('sexe_demandeurs', $demandeur->sexe_demandeurs) == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                            <option value="Feminin" {{ old('sexe_demandeurs', $demandeur->sexe_demandeurs) == 'Feminin' ? 'selected' : '' }}>Féminin</option>  
                                        </select>
                                    </div>
                                </div>

                                {{-- Service --}}
                                <div class="mb-3">
                                    <label for="service_demandeur" class="form-label fw-bold small text-muted">SERVICE</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-building"></i></span>
                                        <input type="text" name="service_demandeur" id="service_demandeur" placeholder="DRH" 
                                            value="{{ old('service_demandeur',$demandeur->service_demandeur) }}" 
                                            class="form-control bg-light border-start-0 @error('service_demandeur') is-invalid @enderror">
                                    </div>
                                    @error('service_demandeur')
                                        <div class="text-danger small mt-1">{{ '!!!Veillez entrer un service' }}</div>
                                    @enderror
                                </div>

                                {{-- Mail --}}
                                <div class="mb-4">
                                    <label for="email_demandeur" class="form-label fw-bold small text-muted">EMAIL</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email_demandeur" id="email_demandeur" placeholder="monemail@gmail.com" 
                                            value="{{ old('email_demandeur',$demandeur->email_demandeur) }}" 
                                            class="form-control bg-light border-start-0 @error('email_demandeur') is-invalid @enderror">
                                    </div>
                                    @error('email_demandeur')
                                        <div class="text-danger small mt-1">{{ '!!!Veillez entrer une adresse email' }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid shadow-sm">
                                    <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                        <i class="bi bi-person-plus-fill me-2"></i>Modifier le demandeur
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection