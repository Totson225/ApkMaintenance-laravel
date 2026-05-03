@extends('layouts.app')

@section('title', 'AppliMaintenance | Demandeur')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- En-tête avec bouton retour --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary-soft text-primary me-3">
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Nouveau Demandeur</h4>
                        <p class="text-muted small mb-0">Ajouter un agent à la base de données</p>
                    </div>
                </div>
                <a href="{{ route('demandeurs.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>

            {{-- Formulaire Card --}}
            <div class="card body-glass border-0">
                <div class="card-body p-5">
                    <form action="{{ route('demandeurs.store') }}" method="post" id="formDemandeur">
                        @csrf
                        
                        <div class="row g-4">
                            {{-- Nom --}}
                            <div class="col-md-6">
                                <label for="nom_demandeur" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Nom de famille</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" name="nom_demandeur" id="nom_demandeur" placeholder="Ex: SILUE" 
                                        value="{{ old('nom_demandeur') }}" 
                                        class="form-control border-start-0 ps-0 @error('nom_demandeur') is-invalid @enderror" required>
                                </div>
                                @error('nom_demandeur')
                                    <div class="text-danger x-small mt-1 animate__animated animate__fadeIn"><i class="bi bi-exclamation-circle me-1"></i>Veuillez entrer un nom</div>
                                @enderror
                            </div>

                            {{-- Prénom --}}
                            <div class="col-md-6">
                                <label for="prenom_demandeur" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Prénom(s)</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-person"></i></span>
                                    <input type="text" name="prenom_demandeur" id="prenom_demandeur" placeholder="Ex: Sara" 
                                        value="{{ old('prenom_demandeur') }}" 
                                        class="form-control border-start-0 ps-0 @error('prenom_demandeur') is-invalid @enderror" required>
                                </div>
                                @error('prenom_demandeur')
                                    <div class="text-danger x-small mt-1 animate__animated animate__fadeIn"><i class="bi bi-exclamation-circle me-1"></i>Veuillez entrer un prénom</div>
                                @enderror
                            </div>

                            {{-- Téléphone --}}
                            <div class="col-md-6">
                                <label for="telephone_demandeur" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Numéro de téléphone</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" name="telephone_demandeur" id="telephone_demandeur" placeholder="01 02 03 04 05"
                                        value="{{ old('telephone_demandeur') }}" 
                                        class="form-control border-start-0 ps-0 @error('telephone_demandeur') is-invalid @enderror" required>
                                </div>
                                @error('telephone_demandeur')
                                    <div class="text-danger x-small mt-1 animate__animated animate__fadeIn"><i class="bi bi-exclamation-circle me-1"></i>Numéro de téléphone requis</div>
                                @enderror
                            </div>

                            {{-- Sexe --}}
                            <div class="col-md-6">
                                <label for="sexe_demandeurs" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Genre</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select class="form-select border-start-0 ps-0 @error('sexe_demandeurs') is-invalid @enderror" name="sexe_demandeurs" id="sexe_demandeurs" required>
                                        <option selected disabled value="">Choisir...</option>
                                        <option value="Masculin" {{ old('sexe_demandeurs') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                        <option value="Feminin" {{ old('sexe_demandeurs') == 'Feminin' ? 'selected' : '' }}>Féminin</option>  
                                    </select>
                                </div>
                            </div>

                            {{-- Service --}}
                            <div class="col-12">
                                <label for="service_demandeur" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Direction / Service</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-building"></i></span>
                                    <input type="text" name="service_demandeur" id="service_demandeur" placeholder="Ex: Ressources Humaines (DRH)" 
                                        value="{{ old('service_demandeur') }}" 
                                        class="form-control border-start-0 ps-0 @error('service_demandeur') is-invalid @enderror" required>
                                </div>
                                @error('service_demandeur')
                                    <div class="text-danger x-small mt-1 animate__animated animate__fadeIn"><i class="bi bi-exclamation-circle me-1"></i>Veuillez préciser le service</div>
                                @enderror
                            </div>

                            {{-- Mail --}}
                            <div class="col-12">
                                <label for="email_demandeur" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Adresse Email professionnelle</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email_demandeur" id="email_demandeur" placeholder="nom.prenom@entreprise.ci" 
                                        value="{{ old('email_demandeur') }}" 
                                        class="form-control border-start-0 ps-0 @error('email_demandeur') is-invalid @enderror">
                                </div>
                                @error('email_demandeur')
                                    <div class="text-danger x-small mt-1 animate__animated animate__fadeIn"><i class="bi bi-exclamation-circle me-1"></i>Format email invalide</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <button class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow btn-submit" type="submit">
                                <i class="bi bi-check-circle me-2"></i>Confirmer l'enregistrement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Intégration avec ton style global existant */
    .body-glass {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        border-radius: 25px !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05) !important;
    }

    .custom-input-group {
        transition: all 0.3s ease;
    }

    .custom-input-group:focus-within {
        transform: translateY(-2px);
    }

    .custom-input-group .form-control, 
    .custom-input-group .form-select,
    .custom-input-group .input-group-text {
        border-color: #e2e8f0 !important;
        background-color: #ffffff !important;
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .custom-input-group .form-control:focus,
    .custom-input-group .form-select:focus {
        box-shadow: none !important;
        border-color: var(--primary-color) !important;
    }

    .custom-input-group:focus-within .input-group-text {
        border-color: var(--primary-color) !important;
        color: var(--primary-color) !important;
    }

    .tracking-wider { letter-spacing: 0.05em; }
    .x-small { font-size: 0.75rem; }

    .btn-submit {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-submit:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2) !important;
    }

    /* Animation d'entrée pour les erreurs */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate__fadeIn { animation: fadeIn 0.3s ease-out; }
</style>

<script>
    // Petit script pour changer l'icône du bouton lors de la soumission
    document.getElementById('formDemandeur').addEventListener('submit', function() {
        const btn = this.querySelector('.btn-submit');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enregistrement...';
        btn.classList.add('disabled');
    });
</script>
@endsection