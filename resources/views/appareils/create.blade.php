@extends('layouts.app')

@section('title', 'AppliMaintenance | Appareil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            
            {{-- Header Modernisé --}}
            <div class="d-flex align-items-center justify-content-between mb-5">
                <div class="animate__animated animate__fadeInLeft">
                    <h2 class="mb-0 fw-black text-dark display-6">Nouvel Appareil <span class="text-primary">.</span></h2>
                    <p class="text-muted">Enregistrement précis pour le suivi de maintenance</p>
                </div>
                <a href="{{ route('appareils.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>

            <div class="card border-0 shadow-soft-lg overflow-hidden position-relative" style="border-radius: 2.5rem;">
                {{-- Décoration d'arrière-plan --}}
                <div class="position-absolute top-0 end-0 p-5 opacity-10">
                    <i class="bi bi-cpu display-1 text-primary"></i>
                </div>

                <div class="card-body p-4 p-md-5 position-relative">
                    <form action="{{ route('appareils.store') }}" method="post" id="formAppareil">
                        @csrf
                        
                        {{-- Étape 1 : Identité --}}
                        <div class="section-step mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-number me-3">1</div>
                                <h5 class="fw-bold mb-0 text-dark">Identité du Matériel</h5>
                            </div>

                            <div class="row g-4 ps-md-4">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Désignation</label>
                                    <div class="input-modern-group">
                                        <i class="bi bi-laptop icon-main"></i>
                                        <input type="text" name="nom_appareil" placeholder="Ex: Dell Latitude 5330" 
                                               value="{{ old('nom_appareil') }}" 
                                               class="modern-input @error('nom_appareil') is-invalid @enderror">
                                    </div>
                                    @error('nom_appareil')
                                        <div class="invalid-feedback-custom">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">Marque / Constructeur</label>
                                    <div class="input-modern-group">
                                        <i class="bi bi-building icon-main"></i>
                                        <input type="text" name="marque_appareil" placeholder="Ex: Dell, Apple, HP..." 
                                               value="{{ old('marque_appareil') }}" 
                                               class="modern-input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Étape 2 : Spécifications --}}
                        <div class="section-step mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-number me-3">2</div>
                                <h5 class="fw-bold mb-0 text-dark">Spécifications & Look</h5>
                            </div>

                            <div class="row g-4 ps-md-4">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Catégorie Technique</label>
                                    <div class="input-modern-group">
                                        <i class="bi bi-layers icon-main"></i>
                                        <input type="text" name="type_appareil" placeholder="Ex: Ordinateur Portable" 
                                               value="{{ old('type_appareil') }}" 
                                               class="modern-input">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">Couleur / Fini</label>
                                    <div class="input-modern-group">
                                        <i class="bi bi-palette icon-main"></i>
                                        <input type="text" name="couleur_appareil" placeholder="Ex: Gris Anthracite" 
                                               value="{{ old('couleur_appareil') }}" 
                                               class="modern-input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Étape 3 : Statut & Propriété --}}
                        <div class="section-step mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-number me-3">3</div>
                                <h5 class="fw-bold mb-0 text-dark">Statut & Affectation</h5>
                            </div>

                            <div class="row g-4 ps-md-4">
                                <div class="col-md-6">
                                    <label class="form-label-custom">État de l'unité</label>
                                    <div class="input-modern-group">
                                        <i class="bi bi-activity icon-main"></i>
                                        <select class="modern-input select-custom" name="etat_appareil" required>
                                            <option selected disabled value="">Définir le statut...</option>
                                            <option value="Reparer">🟢 Prêt à l'emploi</option>
                                            <option value="Endommager">🟡 Maintenance Requise</option> 
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom">Détenteur de l'Asset</label>
                                    <div class="input-modern-group">
                                        <i class="bi bi-person-badge icon-main"></i>
                                        <select name="id_utilisateur" class="modern-input select-custom">
                                            <option selected disabled value="">Sélectionner un agent...</option>
                                            @foreach($demandeurs as $demandeur)
                                                <option value="{{ $demandeur->id_utilisateur }}">
                                                    {{ $demandeur->nom_demandeur }} {{ $demandeur->prenom_demandeur }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button class="btn btn-primary btn-submit-modern w-100 shadow-lg" type="submit">
                                <span>ENREGISTRER L'APPAREIL</span>
                                <i class="bi bi-arrow-right-short ms-2 fs-4"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');

    body { 
        background-color: #f8fafc; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
    }

    .fw-black { font-weight: 800; }

    /* Card & Shadows */
    .shadow-soft-lg {
        box-shadow: 0 40px 80px -20px rgba(0,0,0,0.08);
        background: #ffffff;
    }

    /* Stepper Design */
    .step-number {
        width: 32px;
        height: 32px;
        background: #4e73df;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.8rem;
        box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
    }

    /* Inputs Modernisés */
    .form-label-custom {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        margin-bottom: 0.75rem;
        display: block;
    }

    .input-modern-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .icon-main {
        position: absolute;
        left: 1.25rem;
        color: #4e73df;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .modern-input {
        width: 100%;
        padding: 1.1rem 1.1rem 1.1rem 3.5rem;
        background-color: #f1f5f9;
        border: 2px solid transparent;
        border-radius: 1.25rem;
        color: #1e293b;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .modern-input:focus {
        background-color: #ffffff;
        border-color: #4e73df;
        outline: none;
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
    }

    .modern-input:focus + .icon-main, 
    .input-modern-group:focus-within .icon-main {
        transform: scale(1.1);
        color: #224abe;
    }

    .select-custom {
        appearance: none;
        cursor: pointer;
    }

    /* Bouton Submit */
    .btn-submit-modern {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        border-radius: 1.25rem;
        padding: 1.25rem;
        font-weight: 800;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-submit-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(78, 115, 223, 0.4);
    }

    .bg-primary-soft { background-color: #eef2ff; }

    .invalid-feedback-custom {
        color: #ef4444;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
        padding-left: 1rem;
    }

    .btn-white {
        background: white;
        color: #64748b;
    }
</style>

<script>
    document.getElementById('formAppareil').addEventListener('submit', function() {
        const btn = this.querySelector('.btn-submit-modern');
        btn.innerHTML = '<span>SYCHRONISATION...</span><div class="spinner-border spinner-border-sm ms-2"></div>';
        btn.classList.add('opacity-75', 'disabled');
    });
</script>
@endsection