@extends('layouts.app')

@section('content')
    <div class="d-none d-print-block text-center mb-4">
        <h2>Rapport du technicien</h2>
        <hr>
    </div>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Détails du technicien
                </h5>
                <a href="{{ route('interventions.index') }}" class="btn btn-sm btn-primary">Retour</a>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="bg-light" style="width: 30%;">NOM TECHNICIEN</th>
                                <td>{{ $technicien->nom_techniciens }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">PRENOM TECHNICIEN</th>
                                <td>{{ $technicien->prenom_techniciens }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">TELEPHONE TECHNICIEN</th>
                                <td>{{ $technicien->telephone_technicien }}</td>
                            </tr>
                              <tr>
                                <th class="bg-light">SEXE TECHNICIEN</th>
                                <td>{{ $technicien->sexe_techniciens }}</td>
                            </tr> 
                            <tr>
                                <th class="bg-light">SPECIALITEE TECHNICIEN</th>
                                <td>{{ $technicien->specialite_technicien }}</td>
                            </tr>
                              <tr>
                                <th class="bg-light">EMAIL TECHNICIEN</th>
                                <td>{{ $technicien->email_technicien }}</td>
                            </tr> 
                              <tr>
                                <th class="bg-light">STATUT TECHNICIEN</th>
                                <td>{{ $technicien->statut_tech }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if($technicien->created_at)
                        <div class="mt-3">
                            <p class="text-muted fst-italic">
                                Enregistré le : {{ $technicien->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                    @endif
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