@extends('layouts.app')

@section('title', 'AppliMaintenance | Intervention')

@section('content')
<div class="container py-5">
    {{-- Boutons d'action (masqués à l'impression) --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('interventions.index') }}" class="btn btn-light rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
            <button onclick="window.print()" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi bi-printer-fill me-2"></i>Imprimer
            </button>
    </div>

    {{-- Début du Rapport --}}
    <div class="card border-0 shadow-sm print-border-0">
        {{-- En-tête du Rapport --}}
        <div class="card-header bg-primary text-white p-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0 fw-bold">RAPPORT D'INTERVENTION</h2>
                <small class="opacity-75">Référence : #INT-{{ str_pad($intervention->id_Intervtion, 5, '0', STR_PAD_LEFT) }}</small>
            </div>
            <div class="text-end">
                <h5 class="mb-0">Système de Maintenance </h5>
                <small class="opacity-75">Date d'édition : {{ date('d/m/Y') }}</small>
            </div>
        </div>

        <div class="card-body p-4 p-md-5">
            {{-- Section 1 : Informations Générales --}}
            <div class="row mb-5">
                <div class="col-6">
                    <h6 class="text-uppercase text-muted fw-bold small border-bottom pb-2">Planification</h6>
                    <p class="mb-1"><strong>Demandé le :</strong> {{ \Carbon\Carbon::parse($intervention->date_demande)->format('d/m/Y') }}</p>
                    <p class="mb-1"><strong>Intervenu le :</strong> {{ \Carbon\Carbon::parse($intervention->date_intervention)->format('d/m/Y') }}</p>
                    <p class="mb-0">
                        <strong>Type :</strong> 
                        <span class="badge {{ $intervention->type_intervention == 'Corrective' ? 'bg-danger' : 'bg-success' }}">
                            {{ strtoupper($intervention->type_intervention) }}
                        </span>
                    </p>
                </div>
                <div class="col-6 border-start ps-4">
                    <h6 class="text-uppercase text-muted fw-bold small border-bottom pb-2">Bénéficiaire & Appareil</h6>
                    <p class="mb-1 text-primary fw-bold">
                        <i class="bi bi-person"></i> {{ $intervention->demandeurs->nom_demandeur ?? 'N/A' }} {{ $intervention->demandeurs->prenom_demandeur ?? '' }}
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-laptop"></i> {{ $intervention->appareils->nom_appareil ?? 'Appareil inconnu' }} 
                        <span class="text-muted">({{ $intervention->appareils->marque_appareil ?? '' }})</span>
                    </p>
                </div>
            </div>

            {{-- Section 2 : Diagnostic et Solution --}}
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border-start border-danger border-4 h-100">
                        <h6 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Panne constatée</h6>
                        <p class="mb-0 italic">{{ $intervention->descript_panne }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border-start border-success border-4 h-100">
                        <h6 class="fw-bold text-success"><i class="bi bi-check-circle-fill"></i> Solution apportée</h6>
                        <p class="mb-0">{{ $intervention->solution_apportee }}</p>
                    </div>
                </div>
            </div>

            {{-- Section 3 : Ressources (Tableaux) --}}
            <div class="row g-4">
                <div class="col-md-4">
                    <h6 class="fw-bold border-bottom pb-2">Techniciens</h6>
                    <ul class="list-unstyled">
                        @forelse($intervention->techniciens as $tech)
                            <li><i class="bi bi-person-badge me-2"></i>{{ $tech->nom_techniciens }} {{ $tech->prenom_techniciens }}</li>
                        @empty
                            <li class="text-muted small">Aucun assigné</li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold border-bottom pb-2">Pièces installées</h6>
                    <ul class="list-unstyled small">
                        @forelse($intervention->pieces as $piece)
                            <li><i class="bi bi-cpu me-2"></i>{{ $piece->Nom }} ({{ $piece->Marque }})</li>
                        @empty
                            <li class="text-muted">Aucune pièce</li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold border-bottom pb-2">Matériel utilisé</h6>
                    <ul class="list-unstyled small">
                        @forelse($intervention->materiels as $mat)
                            <li><i class="bi bi-tools me-2"></i>{{ $mat->type_materiel }}</li>
                        @empty
                            <li class="text-muted">Matériel standard</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Bloc Signature (Visible uniquement à l'impression) --}}
            <div class="mt-5 pt-5 d-none d-print-block">
                <div class="row text-center">
                    <div class="col-6">
                        <p class="fw-bold border-bottom mx-5 pb-2">Le Technicien</p>
                        <div style="height: 80px;"></div>
                        <small class="text-muted">(Nom et Signature)</small>
                    </div>
                    <div class="col-6">
                        <p class="fw-bold border-bottom mx-5 pb-2">Le Bénéficiaire</p>
                        <div style="height: 80px;"></div>
                        <small class="text-muted">(Bon pour accord)</small>
                    </div>
                </div>
            </div>
            {{-- <div class="d-flex justify-content-end">
                <button onclick="window.print()" class="btn btn-primary shadow-sm">
                    <i class="bi bi-printer-fill me-2"></i> Imprimer le Rapport
                </button>
            </div> --}}

        </div>

        {{-- Footer du Rapport --}}
        <div class="card-footer bg-white text-center py-3 border-top-0 d-none d-print-block">
            <small class="text-muted">Ce document atteste de la réalisation des travaux de maintenance cités ci-dessus.</small>
        </div>
    </div>
</div>

<style>
    /* Style Web */
    body { background-color: #f8f9fa; }
    .card { border-radius: 12px; }
    .badge { padding: 8px 12px; }

    /* Style Impression Optimisé */
    @media print {
        @page { size: portrait; margin: 1cm; }
        nav, .no-print, .sidebar, footer, .btn { display: none !important; }
        body { background-color: white !important; padding-top: 0 !important; }
        .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; }
        .card-header { background-color: #0d6efd !important; color: white !important; -webkit-print-color-adjust: exact; }
        .bg-light { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; }
        .border-start { border-left: 4px solid !important; -webkit-print-color-adjust: exact; }
        .text-primary { color: #0d6efd !important; }
    }
</style>
@endsection