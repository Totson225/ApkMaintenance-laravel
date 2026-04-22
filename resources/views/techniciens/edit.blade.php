@extends('layouts.app')

@section('content')

            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        
                        {{-- En-tête avec bouton retour --}}
                        <div class="d-flex align-items-center mb-4">
                            <h4 class="mb-0 fw-bold text-primary">Modifier le technicien</h4>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <form action="{{ route('techniciens.update', $technicien->id_technicien) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        {{-- Nom --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="nom_techniciens" class="form-label fw-bold small text-muted">NOM</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-fill"></i></span>
                                                <input type="text" name="nom_techniciens" id="nom_techniciens" placeholder="Siluer" 
                                                    value="{{ old('nom_techniciens', $technicien->nom_techniciens) }}" 
                                                    class="form-control bg-light border-start-0 @error('nom_techniciens') is-invalid @enderror">
                                            </div>
                                            @error('nom_techniciens')
                                                <div class="text-danger small mt-1">{{ '!!!Veillez entrer un nom' }}</div>
                                            @enderror
                                        </div>

                                        {{-- Prénom --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="prenom_techniciens" class="form-label fw-bold small text-muted">PRÉNOM(S)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                                <input type="text" name="prenom_techniciens" id="prenom_techniciens" placeholder="Periguegnon Sara" 
                                                    value="{{ old('prenom_techniciens', $technicien->prenom_techniciens) }}" 
                                                    class="form-control bg-light border-start-0 @error('prenom_techniciens') is-invalid @enderror">
                                            </div>
                                            @error('prenom_techniciens')
                                                <div class="text-danger small mt-1">{{ '!!!Veillez entrer un prenom' }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- Téléphone --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="telephone_technicien" class="form-label fw-bold small text-muted">TÉLÉPHONE</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
                                                <input type="text" name="telephone_technicien" id="telephone_technicien" 
                                                    value="{{ old('telephone_technicien', $technicien->telephone_technicien) }}" 
                                                    class="form-control bg-light border-start-0 @error('telephone_technicien') is-invalid @enderror">
                                            </div>
                                            @error('telephone_technicien')
                                                <div class="text-danger small mt-1">{{ '!!!Veillez entrer un numero de telephone' }}</div>
                                            @enderror
                                        </div>

                                        {{-- Sexe --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="sexe_techniciens" class="form-label fw-bold small text-muted">SEXE</label>
                                            <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-gender-ambiguous"></i></span>
                                                    <select class="form-select bg-light border-start-0 @error('sexe_techniciens') is-invalid @enderror" name="sexe_techniciens" id="sexe_demandeurs" required>
                                                        <option selected disabled value="">Choisir...</option>
                                                        <option value="Masculin" {{ old('sexe_techniciens', $technicien->sexe_techniciens) == 'Masculin' ? 'selected' : '' }}>M (Masculin)</option>
                                                        <option value="Feminin" {{ old('sexe_techniciens', $technicien->sexe_techniciens) == 'Feminin' ? 'selected' : '' }}>F (Féminin)</option>  
                                                    </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Service --}}
                                    <div class="mb-3">
                                        <label for="specialite_technicien" class="form-label fw-bold small text-muted">SPECIALITE</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-tools"></i></span>
                                            <input type="text" name="specialite_technicien" id="specialite_technicien" placeholder="Réseau, Maintenance, etc." 
                                                value="{{ old('specialite_technicien', $technicien->specialite_technicien) }}" 
                                                class="form-control bg-light border-start-0 @error('specialite_technicien') is-invalid @enderror">
                                        </div>
                                        @error('specialite_technicien')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer un service' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Mail --}}
                                    <div class="mb-4">
                                        <label for="email_technicien" class="form-label fw-bold small text-muted">EMAIL</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="email_technicien" id="email_technicien" placeholder="monemail@gmail.com" 
                                                value="{{ old('email_technicien', $technicien->email_technicien) }}" 
                                                class="form-control bg-light border-start-0 @error('email_technicien') is-invalid @enderror">
                                        </div>
                                        @error('email_technicien')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer une adresse email' }}</div>
                                        @enderror
                                    </div>


                                        {{--Statut--}}
                                        <div class="col-md-6 mb-3">
                                            <label for="statut_tech" class="form-label fw-bold small text-muted">Statut</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-info-circle"></i></span>
                                                    <select class="form-select bg-light border-start-0 @error('statut_tech') is-invalid @enderror" name="statut_tech" id="statut_tech" required>
                                                        <option selected disabled value="">Choisir la disponibilité...</option>
                                                        <option value="Occuper" {{ old('statut_tech', $technicien->statut_tech) == 'Occuper' ? 'selected' : '' }}>O (Occuper)</option>
                                                        <option value="Disponible" {{ old('statut_tech', $technicien->statut_tech) == 'Disponible' ? 'selected' : '' }}>D (Disponible)</option>  
                                                     </select>
                                            </div>
                                        </div>

                                    <div class="d-grid shadow-sm">
                                        <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                            <i class="bi bi-person-plus-fill me-2"></i>Modifier le technicien
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection
