@extends('layouts.app')

@section('content')
    <div class="d-none d-print-block text-center mb-4">
        <h2>Rapport d'Intervention</h2>
        <hr>
    </div>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Détails de l'intervention
                </h5>
                <a href="{{ route('interventions.index') }}" class="btn btn-sm btn-primary">Retour</a>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="bg-light" style="width: 30%;">DATE DEMANDE</th>
                                <td>{{ $intervention->date_demande }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">DATE INTERVENTION</th>
                                <td>{{ $intervention->date_intervention }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">DESCRIPTION PANNE</th>
                                <td>{{ $intervention->descript_panne }}</td>
                            </tr>
                              <tr>
                                <th class="bg-light">SOLUTION APPORTEE</th>
                                <td>{{ $intervention->solution_apportee }}</td>
                            </tr> 
                            <tr>
                                <th class="bg-light">TYPE INTERVENTION</th>
                                <td>{{ $intervention->type_intervention }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">DEMANDEUR INTERVENTION</th>
                                <td>
                                    @if($intervention->demandeurs)
                                        <span class="fw-bold">
                                            {{ $intervention->demandeurs->nom_demandeur }}
                                            {{ $intervention->demandeurs->prenom_demandeur }}
                                        </span>
                                    @else
                                         <span class="text-danger">Aucun demandeur associé</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">APPAREIL CONCERNER</th>
                                <td>
                                    @if($intervention->demandeurs)
                                        <span class="fw-bold">
                                            {{ $intervention->appareils->nom_appareil }}
                                            {{ $intervention->appareils->marque_appareil }}
                                        </span>
                                    @else
                                         <span class="text-danger">Aucun appareil associé</span>
                                    @endif
                                </td>
                            </tr> 
                            {{-- Techniciens --}}
                            <tr>
                                <th class="bg-light">TECHNICIEN(S)</th>
                                <td>
                                    @forelse($intervention->techniciens as $tech)
                                        <span class="fw-bold">{{ $tech->nom_techniciens }} {{ $tech->prenom_techniciens }}</span>
                                    @empty
                                        <span class="text-muted">Aucun technicien assigné</span>
                                    @endforelse
                                </td>
                            </tr>

                            {{-- Pièces de Rechange --}}
                            <tr>
                                <th class="fw-bold">PIÈCE(S) DE RECHANGE</th>
                                <td>
                                    @forelse($intervention->pieces as $piece)
                                        <div>{{ $piece->Nom }} ({{ $piece->Marque }})</div>
                                    @empty
                                        <span class="text-muted">Aucune pièce utilisée</span>
                                    @endforelse
                                </td>
                            </tr>

                            {{-- Matériels--}}
                            <tr>
                                <th class="bg-light">MATÉRIEL UTILISÉ</th>
                                <td>
                                    @forelse($intervention->materiels as $mat)
                                        <div>{{ $mat->type_materiel }} ({{ $mat->marque }})</div>
                                    @empty
                                        <span class="text-muted">Matériel standard uniquement</span>
                                    @endforelse
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mb-3 no-print">
                        <button onclick="window.print()" class="btn btn-primary shadow-sm">
                            <i class="bi bi-printer-fill me-2"></i> Imprimer la fiche
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
            @media print {
        /* Masquer navigation, bouton imprimer et footer */
        .no-print, 
        nav, 
        .btn, 
        footer, 
        .sidebar {
            display: none !important;
        }
            @page {
                    margin: 1.5cm; 
                }
            
                /* fais descendre */
                body {
                background-color: white !important;
                justify-content: center;
                padding-top: 3cm; 
            }
            .container {
                width: 100% !important;
                margin: 0 auto !important;
             }

        /* Box toute la largeur */
        .card {
            border: none !important;
            box-shadow: none !important;
        }

        .table {
                border: 1px solid #dee2e6 !important;
                width: 100% !important;
            }

        .container {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Affichage couleurs  */
        body {
            -webkit-print-color-adjust: exact;
        }
    } 
    </style>
@endsection