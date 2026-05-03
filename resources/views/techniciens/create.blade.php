@extends('layouts.app')

@section('title', 'AppliMaintenance | Technicien')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- En-tête avec bouton retour --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Nouveau Technicien</h4>
                        <p class="text-muted small mb-0">Ajouter un membre à l'équipe technique</p>
                    </div>
                </div>
                <a href="{{ route('techniciens.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>

            {{-- Formulaire Card --}}
            <div class="card body-glass border-0 shadow-lg">
                <div class="card-body p-5">
                    <form action="{{ route('techniciens.store') }}" method="post" id="formTechnicien">
                        @csrf
                        
                        <div class="row g-4">
                            {{-- Nom --}}
                            <div class="col-md-6">
                                <label for="nom_techniciens" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Nom de famille</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" name="nom_techniciens" id="nom_techniciens" placeholder="Ex: KOFFI" 
                                        value="{{ old('nom_techniciens') }}" 
                                        class="form-control border-start-0 ps-0 @error('nom_techniciens') is-invalid @enderror" required>
                                </div>
                                @error('nom_techniciens')
                                    <div class="text-danger x-small mt-1 animate__animated animate__fadeIn"><i class="bi bi-exclamation-circle me-1"></i>Nom requis</div>
                                @enderror
                            </div>

                            {{-- Prénom --}}
                            <div class="col-md-6">
                                <label for="prenom_techniciens" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Prénom(s)</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-person"></i></span>
                                    <input type="text" name="prenom_techniciens" id="prenom_techniciens" placeholder="Ex: Jean" 
                                        value="{{ old('prenom_techniciens') }}" 
                                        class="form-control border-start-0 ps-0 @error('prenom_techniciens') is-invalid @enderror" required>
                                </div>
                                @error('prenom_techniciens')
                                    <div class="text-danger x-small mt-1 animate__animated animate__fadeIn"><i class="bi bi-exclamation-circle me-1"></i>Prénom requis</div>
                                @enderror
                            </div>

                            {{-- Téléphone --}}
                            <div class="col-md-6">
                                <label for="telephone_technicien" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Téléphone Direct</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-phone"></i></span>
                                    <input type="tel" name="telephone_technicien" id="telephone_technicien" placeholder="07 00 00 00 00"
                                        value="{{ old('telephone_technicien') }}" 
                                        class="form-control border-start-0 ps-0 @error('telephone_technicien') is-invalid @enderror" required>
                                </div>
                            </div>

                            {{-- Sexe --}}
                            <div class="col-md-6">
                                <label for="sexe_techniciens" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Sexe</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select class="form-select border-start-0 ps-0 @error('sexe_techniciens') is-invalid @enderror" name="sexe_techniciens" id="sexe_techniciens" required>
                                        <option selected disabled value="">Choisir...</option>
                                        <option value="Masculin" {{ old('sexe_techniciens') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                        <option value="Feminin" {{ old('sexe_techniciens') == 'Feminin' ? 'selected' : '' }}>Féminin</option>  
                                    </select>
                                </div>
                            </div>

                            {{-- Spécialité --}}
                            <div class="col-12">
                                <label for="specialite_technicien" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Domaine d'expertise</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-tools"></i></span>
                                    <input type="text" name="specialite_technicien" id="specialite_technicien" placeholder="Ex: Maintenance Matérielle & Réseaux" 
                                        value="{{ old('specialite_technicien') }}" 
                                        class="form-control border-start-0 ps-0 @error('specialite_technicien') is-invalid @enderror" required>
                                </div>
                            </div>

                            {{-- Mail --}}
                            <div class="col-md-7">
                                <label for="email_technicien" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Email Professionnel</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email_technicien" id="email_technicien" placeholder="tech.nom@entreprise.ci" 
                                        value="{{ old('email_technicien') }}" 
                                        class="form-control border-start-0 ps-0 @error('email_technicien') is-invalid @enderror">
                                </div>
                            </div>

                            {{-- Statut --}}
                            <div class="col-md-5">
                                <label for="statut_tech" class="form-label fw-bold small text-uppercase tracking-wider text-muted">Disponibilité Initiale</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-activity"></i></span>
                                    <select class="form-select border-start-0 ps-0 @error('statut_tech') is-invalid @enderror" name="statut_tech" id="statut_tech" required>
                                        <option value="Disponible" {{ old('statut_tech') == 'Disponible' ? 'selected' : '' }}>🟢 Disponible</option> 
                                        <option value="Occuper" {{ old('statut_tech') == 'Occuper' ? 'selected' : '' }}>🔴 Occupé</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm btn-submit" type="submit">
                                <i class="bi bi-save2 me-2"></i>Enregistrer le Technicien
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Intégration Glassmorphism */
    .body-glass {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        border-radius: 25px !important;
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
    }

    .icon-box {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-primary-soft { background-color: #f1f4ff; }

    .custom-input-group .form-control, 
    .custom-input-group .form-select,
    .custom-input-group .input-group-text {
        border-color: #e9ecef !important;
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #ffffff !important;
    }

    .custom-input-group:focus-within {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    .custom-input-group:focus-within .input-group-text {
        color: #4e73df !important;
        border-color: #4e73df !important;
    }

    .custom-input-group .form-control:focus {
        box-shadow: none !important;
        border-color: #4e73df !important;
    }

    .tracking-wider { letter-spacing: 0.08em; }
    .x-small { font-size: 0.75rem; }

    .btn-submit {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border: none;
        transition: all 0.3s;
    }

    .btn-submit:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 20px rgba(78, 115, 223, 0.3) !important;
    }
</style>

<script>
    // Animation de chargement
    document.getElementById('formTechnicien').addEventListener('submit', function() {
        const btn = this.querySelector('.btn-submit');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Création du profil...';
        btn.classList.add('disabled');
    });
</script>
@endsection