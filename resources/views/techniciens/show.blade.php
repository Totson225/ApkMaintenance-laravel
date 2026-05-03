@extends('layouts.app')

@section('title', 'AppliMaintenance | Technicien')

@section('content')
    {{-- En-tête pour l'impression uniquement --}}
    <div class="d-none d-print-block">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h2 class="text-primary fw-bold mb-0">Appli Maintenance</h2>
                <p class="text-muted small">Système de Gestion des Interventions</p>
            </div>
            <div class="text-end">
                <h4 class="mb-0">FICHE TECHNIQUE</h4>
                <p class="small text-muted">Généré le {{ date('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="container py-4">
        {{-- Barre d'actions (masquée à l'impression) --}}
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h4 class="fw-bold text-dark mb-0">
                </i>Détails de l'Expert
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('techniciens.index') }}" class="btn btn-light rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
                <button onclick="window.print()" class="btn btn-primary rounded-pill shadow-sm">
                    <i class="bi bi-printer-fill me-2"></i>Imprimer le rapport
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
            <div class="row g-0">
                {{-- Volet Gauche : Identité --}}
                <div class="col-md-4 bg-primary text-white p-4 p-lg-5 text-center d-flex flex-column justify-content-center">
                    <div class="avatar-placeholder mx-auto mb-3 shadow-lg d-flex align-items-center justify-content-center">
                        <span class="display-4 fw-bold">{{ strtoupper(substr($technicien->nom_techniciens, 0, 1)) }}</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $technicien->nom_techniciens }}</h3>
                    <p class="lead opacity-75 mb-3">{{ $technicien->prenom_techniciens }}</p>
                    
                    <div class="mt-2">
                        @if($technicien->statut_tech == 'Disponible')
                            <span class="badge bg-success py-2 px-4 rounded-pill shadow-sm">
                                <i class="bi bi-check-circle-fill me-2"></i>Disponible
                            </span>
                        @else
                            <span class="badge bg-warning text-dark py-2 px-4 rounded-pill shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>En intervention
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Volet Droit : Détails Techniques --}}
                <div class="col-md-8 p-4 p-lg-5 bg-white">
                    <h5 class="text-muted small fw-bold text-uppercase border-bottom pb-2 mb-4">Informations Professionnelles</h5>
                    
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Spécialité</label>
                            <span class="fw-bold text-dark fs-5"><i class="bi bi-gear-wide-connected text-primary me-2"></i>{{ $technicien->specialite_technicien }}</span>
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Contact Téléphonique</label>
                            <span class="fw-bold text-dark fs-5"><i class="bi bi-telephone-fill text-primary me-2"></i>{{ $technicien->telephone_technicien }}</span>
                        </div>

                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Genre</label>
                            <span class="fw-bold text-dark fs-6">{{ $technicien->sexe_techniciens }}</span>
                        </div>

                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Adresse Email</label>
                            <span class="fw-bold text-dark fs-6 text-break">{{ $technicien->email_technicien ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="mt-5 p-3 bg-light rounded-3 d-flex align-items-center">
                        <i class="bi bi-calendar-check text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">Membre de l'équipe depuis le</small>
                            <span class="fw-bold">{{ $technicien->created_at ? $technicien->created_at->format('d F Y') : 'Date inconnue' }}</span>
                        </div>
                    </div>

                    {{-- Pied de page pour impression --}}
                    <div class="d-none d-print-block mt-5 pt-5 border-top">
                        <div class="row text-center">
                            <div class="col-6">
                                <p class="small text-muted">Signature du Technicien</p>
                                <div style="height: 60px;"></div>
                                <p class="small">_______________________</p>
                            </div>
                            <div class="col-6">
                                <p class="small text-muted">Cachet de la Direction</p>
                                <div style="height: 60px;"></div>
                                <p class="small">_______________________</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-placeholder {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border: 4px solid white;
            border-radius: 30px;
        }

        /* Optimisation Impression */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding-top: 0 !important; }
            .container { max-width: 100% !important; width: 100% !important; }
            .card { border: 1px solid #eee !important; box-shadow: none !important; }
            .bg-primary { 
                background-color: #f8f9fa !important; 
                color: black !important; 
                border-right: 1px solid #eee !important;
            }
            .avatar-placeholder { border-color: #ccc !important; color: #333 !important; }
            .text-white { color: black !important; }
            .opacity-75 { opacity: 1 !important; }
            
            /* Forcer les couleurs de fond pour les badges */
            .badge { border: 1px solid #ccc !important; color: black !important; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
@endsection