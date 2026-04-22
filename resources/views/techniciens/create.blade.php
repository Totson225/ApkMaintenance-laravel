@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- En-tête --}}
            <div class="d-flex align-items-center mb-4">
                <h4 class="mb-0 fw-bold text-primary">Enregistrer un technicien</h4>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('techniciens.store') }}" method="post">
                        @csrf
                        
                        <div class="row">
                            {{-- Nom --}}
                            <div class="col-md-6 mb-3">
                                <label for="nom_techniciens" class="form-label fw-bold small text-muted">NOM</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" name="nom_techniciens" id="nom_techniciens" placeholder="Siluer" 
                                        value="{{ old('nom_techniciens') }}" 
                                        class="form-control bg-light border-start-0 @error('nom_techniciens') is-invalid @enderror">
                                </div>
                                @error('nom_techniciens')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un nom</div>
                                @enderror
                            </div>

                            {{-- Prénom --}}
                            <div class="col-md-6 mb-3">
                                <label for="prenom_techniciens" class="form-label fw-bold small text-muted">PRÉNOM(S)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="prenom_techniciens" id="prenom_techniciens" placeholder="Periguegnon Sara" 
                                        value="{{ old('prenom_techniciens') }}" 
                                        class="form-control bg-light border-start-0 @error('prenom_techniciens') is-invalid @enderror">
                                </div>
                                @error('prenom_techniciens')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un prénom</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Téléphone --}}
                            <div class="col-md-6 mb-3">
                                <label for="telephone_technicien" class="form-label fw-bold small text-muted">TÉLÉPHONE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-phone"></i></span>
                                    <input type="text" name="telephone_technicien" id="telephone_technicien" 
                                        value="{{ old('telephone_technicien') }}" 
                                        class="form-control bg-light border-start-0 @error('telephone_technicien') is-invalid @enderror">
                                </div>
                                @error('telephone_technicien')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un numéro de téléphone</div>
                                @enderror
                            </div>

                            {{-- Sexe --}}
                            <div class="col-md-6 mb-3">
                                <label for="sexe_techniciens" class="form-label fw-bold small text-muted">SEXE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select class="form-select bg-light border-start-0 @error('sexe_techniciens') is-invalid @enderror" name="sexe_techniciens" id="sexe_techniciens" required>
                                        <option selected disabled value="">Choisir...</option>
                                        <option value="Masculin" {{ old('sexe_techniciens') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                        <option value="Feminin" {{ old('sexe_techniciens') == 'Feminin' ? 'selected' : '' }}>Féminin</option>  
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Spécialité --}}
                        <div class="mb-3">
                            <label for="specialite_technicien" class="form-label fw-bold small text-muted">SPÉCIALITÉ</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-tools"></i></span>
                                <input type="text" name="specialite_technicien" id="specialite_technicien" placeholder="Réseau, Maintenance, etc." 
                                    value="{{ old('specialite_technicien') }}" 
                                    class="form-control bg-light border-start-0 @error('specialite_technicien') is-invalid @enderror">
                            </div>
                            @error('specialite_technicien')
                                <div class="text-danger small mt-1">!!! Veuillez entrer une spécialité</div>
                            @enderror
                        </div>

                        {{-- Mail --}}
                        <div class="mb-3">
                            <label for="email_technicien" class="form-label fw-bold small text-muted">EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email_technicien" id="email_technicien" placeholder="technicien@entreprise.com" 
                                    value="{{ old('email_technicien') }}" 
                                    class="form-control bg-light border-start-0 @error('email_technicien') is-invalid @enderror">
                            </div>
                            @error('email_technicien')
                                <div class="text-danger small mt-1">!!! Veuillez entrer une adresse email valide</div>
                            @enderror
                        </div>

                        {{-- Statut --}}
                        <div class="mb-4">
                            <label for="statut_tech" class="form-label fw-bold small text-muted">STATUT ACTUEL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-info-circle"></i></span>
                                <select class="form-select bg-light border-start-0 @error('statut_tech') is-invalid @enderror" name="statut_tech" id="statut_tech" required>
                                    <option selected disabled value="">Choisir la disponibilité...</option>
                                    <option value="Occuper" {{ old('statut_tech') == 'Occuper' ? 'selected' : '' }}>O (Occupé)</option>
                                    <option value="Disponible" {{ old('statut_tech') == 'Disponible' ? 'selected' : '' }}>D (Disponible)</option>  
                                </select>
                            </div>
                        </div>

                        <div class="d-grid shadow-sm">
                            <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                <i class="bi bi-save me-2"></i>Enregistrer le technicien
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection