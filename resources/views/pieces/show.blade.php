@extends('layouts.app')

@section('title', 'AppliMaintenance | Piece')

@section('content')
<div class="container py-5">
    {{-- Header de la page (Masqué à l'impression) --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('pieces.index') }}" class="text-decoration-none">Stock</a></li>
                    <li class="breadcrumb-item active">Détails pièce</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-0">Fiche Produit : <span class="text-primary">{{ $piece->Nom }}</span></h2>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pieces.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
            <button onclick="window.print()" class="btn btn-primary rounded-pill shadow-sm px-3">
                    <i class="bi bi-printer-fill me-2"></i>Imprimer la fiche
            </button>
        </div>
    </div>

    {{-- En-tête d'impression (Uniquement pour le PDF/Papier) --}}
    <div class="d-none d-print-block">
        <div class="row align-items-center mb-5">
            <div class="col-6">
                <h1 class="text-primary fw-bold mb-0">{{ config('app.name') }}</h1>
                <p class="text-muted small">Rapport Technique de Maintenance</p>
            </div>
            <div class="col-6 text-end">
                <h4 class="fw-bold">FICHE DE PIÈCE DÉTAILLÉE</h4>
                <p class="mb-0">Généré le : {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <div class="border-top border-bottom py-3 mb-4">
            <h3 class="text-center mb-0 fw-bold">{{ $piece->Nom }}</h3>
        </div>
    </div>

    <div class="row g-4">
        {{-- Colonne de gauche : Informations principales --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4 d-flex align-items-center text-dark">
                        <span class="p-2 bg-primary-subtle rounded-3 me-3 text-primary">
                            <i class="bi bi-info-circle-fill"></i>
                        </span>
                        Caractéristiques de la pièce
                    </h5>

                    <div class="row g-4">
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold">Marque / Fabricant</label>
                            <p class="h5 fw-medium">{{ $piece->Marque }}</p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <label class="text-muted small text-uppercase fw-bold">Prix Unitaire</label>
                            <p class="h5 fw-bold text-success">{{ number_format($piece->Prix, 2, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="col-12 mt-0"><hr class="opacity-50"></div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold">État du Stock</label>
                            <div class="mt-1">
                                @if($piece->Stock <= 5)
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">
                                        <i class="bi bi-exclamation-triangle me-1"></i> Stock Critique : {{ $piece->Stock }} unités
                                    </span>
                                @else
                                    <span class="badge bg-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i> En Stock : {{ $piece->Stock }} unités
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <label class="text-muted small text-uppercase fw-bold">Dernière mise à jour</label>
                            <p class="text-dark fst-italic">{{ $piece->updated_at ? $piece->updated_at->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Colonne de droite : Contexte / Intervention --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-4 text-start">Intervention associée</h5>
                    
                    @if($piece->interventions)
                        <div class="p-4 bg-white rounded-4 shadow-sm border-start border-4 border-primary">
                            <div class="mb-3">
                                <i class="bi bi-tools h1 text-primary-emphasis"></i>
                            </div>
                            <h6 class="fw-bold text-uppercase text-muted small">Intervention N°</h6>
                            <p class="h4 fw-bold">#{{ $piece->interventions->id_Intervtion }}</p>
                            
                            <hr>
                            
                            <p class="mb-1 text-muted">Planifiée le :</p>
                            <p class="fw-bold">{{ \Carbon\Carbon::parse($piece->interventions->date_intervention)->format('d F Y') }}</p>
                            
                            <a href="#" class="btn btn-sm btn-outline-primary mt-2 no-print">Voir l'intervention</a>
                        </div>
                    @else
                        <div class="p-5">
                            <i class="bi bi-slash-circle h1 text-muted opacity-50 d-block mb-3"></i>
                            <p class="text-danger fw-bold mb-0">Aucune liaison trouvée</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($piece->created_at)
        <div class="text-center mt-4 text-muted small no-print">
            Fiche créée le {{ $piece->created_at->format('d/m/Y à H:i') }}
        </div>
    @endif
</div>

<style>
    /* STYLES GÉNÉRAUX */
    body { background-color: #f4f7f6; }
    .bg-primary-subtle { background-color: #e7f1ff; }
    .card { transition: all 0.2s ease-in-out; }
    
    /* STYLES IMPRESSION */
    @media print {
        .no-print { display: none !important; }
        body { background-color: white !important; font-size: 11pt; }
        .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
        .card { 
            border: 1px solid #dee2e6 !important; 
            box-shadow: none !important; 
            border-radius: 0 !important; 
        }
        .bg-light { background-color: transparent !important; }
        .badge { 
            border: 1px solid #000; 
            color: black !important; 
            background: transparent !important; 
            padding: 2px 5px !important;
        }
        .text-primary { color: #000 !important; }
        .bg-primary-subtle { display: none !important; }
        @page { margin: 1cm; }
    }
</style>
@endsection