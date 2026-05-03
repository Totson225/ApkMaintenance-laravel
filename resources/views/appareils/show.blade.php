@extends('layouts.app')

@section('title', 'AppliMaintenance | Appareil')

@section('content')
    {{-- En-tête pour l'impression uniquement --}}
    <div class="d-none d-print-block">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h2 class="text-primary fw-bold mb-0">Appli Maintenance</h2>
                <p class="text-muted small">Rapport Technique d'Équipement</p>
            </div>
            <div class="text-end">
                <h4 class="mb-0">FICHE D'APPAREIL</h4>
                <p class="small text-muted">ID: #{{ str_pad($appareil->id_appareil ?? $appareil->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </div>

    <div class="container py-4">
        {{-- Barre d'actions --}}
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h4 class="fw-bold text-dark mb-0">
                <i class="bi bi-display text-primary me-2"></i>Détails de l'équipement
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('appareils.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
                <button onclick="window.print()" class="btn btn-primary rounded-pill shadow-sm px-3">
                    <i class="bi bi-printer-fill me-2"></i>Imprimer
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-light text-primary border px-3 py-2 rounded-pill">
                        <i class="bi bi-info-circle me-1"></i> Caractéristiques
                    </span>
                    @if($appareil->etat_appareil == 'Reparer' || $appareil->etat_appareil == 'Réparé')
                        <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-check-circle-fill me-1"></i> Opérationnel
                        </span>
                    @else
                        <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Endommagé
                        </span>
                    @endif
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Colonne 1: Infos Techniques --}}
                    <div class="col-md-7 border-end border-light">
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted small fw-bold uppercase">NOM :</div>
                            <div class="col-sm-8 fw-bold text-dark fs-5">{{ $appareil->nom_appareil }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted small fw-bold uppercase">MARQUE :</div>
                            <div class="col-sm-8 fw-bold">{{ $appareil->marque_appareil }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted small fw-bold uppercase">TYPE :</div>
                            <div class="col-sm-8"><span class="badge bg-light text-dark border">{{ $appareil->type_appareil }}</span></div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-sm-4 text-muted small fw-bold uppercase">COULEUR :</div>
                            <div class="col-sm-8 text-secondary">{{ $appareil->couleur_appareil }}</div>
                        </div>
                    </div>

                    {{-- Colonne 2: Propriétaire --}}
                    <div class="col-md-5 ps-md-4">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <label class="text-muted small fw-bold d-block mb-2">PROPRIÉTAIRE / DEMANDEUR</label>
                            @if($appareil->demandeurs)
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $appareil->demandeurs->nom_demandeur }}</div>
                                        <div class="small text-muted">{{ $appareil->demandeurs->prenom_demandeur }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="text-danger small"><i class="bi bi-person-x me-1"></i>Aucun demandeur associé</div>
                            @endif
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="text-muted small mb-0">
                        <i class="bi bi-calendar3 me-1"></i> Enregistré le {{ $appareil->created_at->format('d/m/Y à H:i') }}
                    </p>
                    <div class="d-none d-print-block text-center mt-4">
                        <p class="small mb-0">Signature & Cachet</p>
                        <div style="height: 50px;"></div>
                        <span>_______________________</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styles pour l'écran */
        .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* Optimisation Impression */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
            .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; margin-top: 1cm; }
            .col-md-7 { width: 60% !important; float: left; }
            .col-md-5 { width: 40% !important; float: left; border-left: 1px solid #eee; }
            .bg-light { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; }
            .badge { border: 1px solid #ccc !important; color: #000 !important; }
            @page { margin: 1cm; }
        }
    </style>
@endsection