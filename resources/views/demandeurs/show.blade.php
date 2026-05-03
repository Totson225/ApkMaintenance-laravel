@extends('layouts.app')

@section('title', 'AppliMaintenance | Demandeur')

@section('content')
<div class="container py-5">
    {{-- En-tête avec bouton retour --}}
    <div class="d-flex align-items-center justify-content-between mb-4 no-print">
        <div class="d-flex align-items-center">
            <h4 class="mb-0 fw-bold text-dark">Fiche du Demandeur</h4>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('demandeurs.index') }}" class="btn btn-light rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
            <button onclick="window.print()" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi bi-printer-fill me-2"></i>Imprimer
            </button>
        </div>
    </div>

    {{-- Carte de profil --}}
    <div class="card body-glass border-0 shadow-lg overflow-hidden">
        {{-- Bannière décorative (masquée à l'impression) --}}
        <div class="profile-banner bg-primary no-print" style="height: 100px; background: linear-gradient(45deg, #4e73df, #224abe);"></div>

        <div class="card-body p-4 p-md-5">
            <div class="row">
                {{-- Colonne Avatar & Identité --}}
                <div class="col-lg-4 text-center border-end border-light mb-4 mb-lg-0 profile-sidebar">
                    <div class="avatar-circle mx-auto mb-3 shadow">
                        {{ strtoupper(substr($demandeur->nom_demandeur, 0, 1) . substr($demandeur->prenom_demandeur, 0, 1)) }}
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $demandeur->nom_demandeur }}</h3>
                    <p class="text-primary fw-medium mb-3">{{ $demandeur->prenom_demandeur }}</p>
                    
                    @if(strtolower($demandeur->sexe_demandeurs) == 'masculin')
                        <span class="badge rounded-pill bg-info-soft text-info px-3 py-2">
                            <i class="bi bi-gender-male me-1"></i> Masculin
                        </span>
                    @else
                        <span class="badge rounded-pill bg-danger-soft text-danger px-3 py-2">
                            <i class="bi bi-gender-female me-1"></i> Féminin
                        </span>
                    @endif

                    <div class="mt-4 pt-4 border-top no-print">
                        <small class="text-muted d-block mb-1 text-uppercase fw-bold">Date d'enregistrement</small>
                        <p class="text-dark small"><i class="bi bi-clock-history me-2"></i>{{ $demandeur->created_at->format('d M Y à H:i') }}</p>
                    </div>
                </div>

                {{-- Colonne Détails --}}
                <div class="col-lg-8 ps-lg-5">
                    <h5 class="text-muted small fw-bold text-uppercase mb-4 tracking-wider border-bottom pb-2">Informations de contact & Service</h5>
                    
                    <div class="row g-4">
                        <div class="col-md-6 info-group">
                            <label class="text-muted small d-block">Direction / Service</label>
                            <div class="d-flex align-items-center mt-1">
                                <i class="bi bi-building text-primary me-3 fs-5"></i>
                                <span class="fw-bold text-dark">{{ $demandeur->service_demandeur }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 info-group">
                            <label class="text-muted small d-block">Téléphone</label>
                            <div class="d-flex align-items-center mt-1">
                                <i class="bi bi-telephone text-primary me-3 fs-5"></i>
                                <span class="fw-bold text-dark">{{ $demandeur->telephone_demandeur }}</span>
                            </div>
                        </div>

                        <div class="col-md-12 info-group">
                            <label class="text-muted small d-block">Adresse Email</label>
                            <div class="d-flex align-items-center mt-1">
                                <i class="bi bi-envelope text-primary me-3 fs-5"></i>
                                <span class="fw-bold text-dark">{{ $demandeur->email_demandeur ?? 'Non renseigné' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Pied de page pour impression --}}
                    <div class="print-footer mt-5 pt-5 border-top d-none">
                        <div class="d-flex justify-content-between text-muted small">
                            <span>Document généré par Appli Maintenance</span>
                            <span>Signature & Cachet</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles UI */
    .bg-primary-soft { background-color: #f1f4ff; }
    .bg-info-soft { background-color: #e1f5fe; }
    .bg-danger-soft { background-color: #fce4ec; }
    
    .body-glass {
        border-radius: 25px !important;
        background: white !important;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        margin-top: -50px; /* Chevauchement bannière */
        border: 5px solid white;
    }

    .tracking-wider { letter-spacing: 0.1em; }
    
    .info-group {
        padding: 15px;
        border-radius: 15px;
        transition: background 0.2s;
    }
    .info-group:hover { background: #f8f9fc; }

    /* Impression */
/* Impression optimisée */
    @media print {
        @page { 
            size: A4; 
            margin: 1cm; /* Réduction de la marge pour gagner de l'espace */
        }

        /* Masquer les éléments inutiles */
        .no-print, .profile-banner, nav, footer { display: none !important; }
        
        /* Afficher le footer d'impression */
        .print-footer.d-none { display: block !important; visibility: visible; }

        /* Réinitialisation forcée du body et du container */
        body { 
            background: white !important; 
            margin: 0 !important; 
            padding: 0 !important; 
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
        }

        .container { 
            max-width: 100% !important; 
            width: 100% !important; 
            margin: 0 !important; 
            padding: 0 !important; 
        }

        .py-5 { padding-top: 0 !important; padding-bottom: 0 !important; }

        /* Ajustement de la carte pour l'impression */
        .card { 
            border: none !important; 
            box-shadow: none !important; 
            margin: 0 !important;
        }

        .card-body { padding: 10px !important; }

        /* Empêcher la coupure de la carte entre deux pages */
        .card, .info-group {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .avatar-circle { 
            margin-top: 20px !important; /* On annule le chevauchement négatif car la bannière est masquée */
            border: 2px solid #4e73df !important;
            background: #f8f9fc !important;
            color: #4e73df !important;
            width: 80px !important; /* Légère réduction de taille */
            height: 80px !important;
        }

        /* Amélioration visuelle des groupes d'info pour l'impression */
        .info-group { 
            border: 1px solid #eee !important;
            border-left: 4px solid #4e73df !important; 
            margin-bottom: 10px !important; 
            background: #fcfcfc !important; 
        }

        /* Forcer l'affichage du texte en noir pour la lisibilité */
        .text-muted { color: #666 !important; }
    }
</style>
@endsection