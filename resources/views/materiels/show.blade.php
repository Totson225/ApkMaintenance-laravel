@extends('layouts.app')

@section('title', 'AppliMaintenance | Materiel')

@section('content')
    {{-- En-tête exclusif à l'impression --}}
    <div class="d-none d-print-block">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h2 class="text-primary fw-bold mb-0">Appli Maintenance</h2>
                <p class="text-muted small">Inventaire du Matériel Informatique</p>
            </div>
            <div class="text-end">
                <h4 class="mb-0">RAPPORT DE MATÉRIEL</h4>
                <p class="small text-muted">S/N: {{ $materiel->numero_serie }}</p>
            </div>
        </div>
    </div>

    <div class="container py-4">
        {{-- Barre d'outils (masquée à l'impression) --}}
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h4 class="fw-bold text-dark mb-0">
               </i>Fiche Matériel
            </h4>
            <div class="d-flex gap-2">
                <a href="{{ route('materiels.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
                <button onclick="window.print()" class="btn btn-primary rounded-pill shadow-sm px-3">
                    <i class="bi bi-printer-fill me-2"></i>Imprimer la fiche
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-info-circle me-1"></i> Informations Générales
                    </span>
                    <div class="d-flex align-items-center">
                        <span class="text-muted small me-2">Statut :</span>
                        @php
                            $badgeClass = match($materiel->etat) {
                                'Neuf', 'Bon état' => 'bg-success',
                                'Passable' => 'bg-warning text-dark',
                                'En panne' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill shadow-sm">
                            {{ $materiel->etat }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row">
                    {{-- Section Spécifications --}}
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <tbody>
                                    <tr>
                                        <td class="text-muted py-3" style="width: 35%;">TYPE DU MATÉRIEL</td>
                                        <td class="fw-bold text-dark fs-5">{{ $materiel->type_materiel }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-3">CONSTRUCTEUR (MARQUE)</td>
                                        <td><span class="fw-bold fs-6">{{ $materiel->marque }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-3">MODÈLE / RÉFÉRENCE</td>
                                        <td class="text-primary fw-bold">{{ $materiel->modele }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-3">NUMÉRO DE SÉRIE</td>
                                        <td><code class="bg-light p-2 rounded text-dark fw-bold border">{{ $materiel->numero_serie }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-3">DATE D'ACQUISITION</td>
                                        <td><i class="bi bi-calendar-event me-2 text-muted"></i>{{ \Carbon\Carbon::parse($materiel->date_acquisition)->format('d F Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Section Visuelle / QR (Simulation) --}}
                    <div class="col-md-4 d-flex flex-column align-items-center justify-content-center border-start border-light d-none d-md-flex">
                        <div class="p-4 bg-light rounded-4 text-center">
                            <i class="bi bi-qr-code fs-1 text-dark opacity-25"></i>
                            <p class="small text-muted mt-2 mb-0">Code Inventaire Interne</p>
                            <span class="fw-bold text-uppercase small">MAT-{{ $materiel->Id_materiel }}</span>
                        </div>
                        @if($materiel->created_at)
                            <div class="mt-4 text-center">
                                <p class="text-muted small italic">
                                    Enregistré le {{ $materiel->created_at->format('d/m/Y') }}<br>
                                    à {{ $materiel->created_at->format('H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Zone de validation pour impression --}}
                <div class="d-none d-print-block mt-5 pt-5 border-top">
                    <div class="row">
                        <div class="col-6 text-center">
                            <p class="small fw-bold">Responsable Stock</p>
                            <div style="height: 60px;"></div>
                            <p class="small">_______________________</p>
                        </div>
                        <div class="col-6 text-center">
                            <p class="small fw-bold">Visa Administration</p>
                            <div style="height: 60px;"></div>
                            <p class="small">_______________________</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-soft-primary { background-color: #eef2ff; }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
            .card { border: 1px solid #eee !important; box-shadow: none !important; margin-top: 1cm; }
            .badge { border: 1px solid #ccc !important; color: black !important; background: none !important; }
            .text-primary { color: #0d6efd !important; }
            td { border-bottom: 1px solid #f8f9fa !important; }
            @page { margin: 1.5cm; }
        }
    </style>
@endsection