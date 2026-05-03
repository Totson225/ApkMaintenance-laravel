@extends('layouts.app')

@section('title', 'AppliMaintenance | Dashbord')

@section('content')
<div class="container dashboard-container">
    {{-- Header Dynamique --}}
    <header class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 p-4 rounded-5 shadow-lg bg-white border-start border-primary border-5">
        <div>
            <h1 class="fw-black text-dark mb-0 display-6">Maintenance Hub <span class="text-primary">.</span></h1>
            <p class="text-muted mb-0 fw-medium"><i class="bi bi-geo-alt-fill text-danger"></i> Atelier Ministère de la Défense • <span class="text-success">Système Nominal</span></p>
        </div>
        <div class="d-flex gap-3 mt-3 mt-md-0">
            <div class="date-pill shadow-sm">
                <i class="bi bi-clock-history text-primary me-2"></i>
                <span id="liveClock">{{ date('H:i') }}</span>
            </div>
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <a href="{{ route('interventions.create') }}" class="btn btn-primary rounded-pill shadow-sm px-3">
                        <i class="bi bi-plus-lg me-2"></i>Nouveau
                    </a>
                @endif
        </div>
    </header>

    {{-- Grille de Stats Animée --}}
    <div class="stats-grid">
        <div class="stat-card border-bottom border-primary border-3">
            <div class="stat-icon bg-primary-soft text-primary shadow-sm"><i class="bi bi-journals me-2"></i></div>
            <div class="stat-content">
                <p class="stat-label fw-bold text-uppercase">Interventions</p>
                <div class="d-flex align-items-baseline gap-2">
                    <h3 class="fw-black mb-0">{{ $achevees + $inachevees }}</h3>
                    <span class="text-success small fw-bold"><i class="bi bi-arrow-up"></i> 12%</span>
                </div>
                <div class="progress mt-2" style="height: 6px;">
                    @php $percent = ($achevees + $inachevees) > 0 ? ($achevees / ($achevees + $inachevees)) * 100 : 0; @endphp
                    <div class="progress-bar bg-success rounded-pill" style="width: {{ $percent }}%"></div>
                </div>
            </div>
        </div>

        <div class="stat-card border-bottom border-success border-3">
            <div class="stat-icon bg-success-soft text-success shadow-sm"><i class="bi bi-person-gear"></i></div>
            <div class="stat-content">
                <p class="stat-label fw-bold text-uppercase">Techniciens</p>
                <h3 class="fw-black mb-0">{{ $disponible }} <small class="fs-6 text-muted">actifs</small></h3>
                <p class="mb-0 small text-muted">{{ $occupe }} en cours d'opération</p>
            </div>
        </div>

        <div class="stat-card border-bottom border-warning border-3">
            <div class="stat-icon bg-warning-soft text-warning shadow-sm"><i class="bi bi-cpu"></i></div>
            <div class="stat-content">
                <p class="stat-label fw-bold text-uppercase">Flux Atelier</p>
                <h3 class="fw-black mb-0">{{ $reparer + $endommager }}</h3>
                <span class="badge rounded-pill bg-warning text-dark small">Charge Haute</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        {{-- Graphique Principal --}}
        <div class="col-xl-8">
            <div class="content-card border-0 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-black mb-0">Performance Mensuelle</h5>
                        <small class="text-muted">Volume d'interventions traitées</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-pill px-3 border" type="button">Ce mois <i class="bi bi-chevron-down ms-1"></i></button>
                    </div>
                </div>
                <div style="height: 350px;">
                    <canvas id="interventionsChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Widget Stock & Activité --}}
        <div class="col-xl-4">
            <div class="row g-4 h-100">
                {{-- Carte Inventaire --}}
                <div class="col-12">
                    <div class="content-card bg-dark text-white border-0 overflow-hidden position-relative p-4 rounded-4 shadow-lg" style="min-height: 220px;">
                        <i class="bi bi-box-seam position-absolute opacity-10" style="font-size: 9rem; right: -15px; bottom: -25px; pointer-events: none;"></i>
                        <div class="position-relative">
                            <h6 class="text-uppercase fw-bold text-secondary mb-1" style="letter-spacing: 1px; font-size: 0.75rem;">Catalogue</h6>
                            <h4 class="fw-bold mb-0 text-white">Inventaire Pièces</h4>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4 position-relative">
                            <div>
                                <span class="display-3 fw-bold text-white line-height-1">{{ $nbe }}</span>
                                <p class="mb-0 ">Unités en stock</p>
                            </div>
                            <div class="pb-2">
                                <a href="{{ route('pieces.index') }}" class="btn btn-outline-primary btn-lg rounded-pill px-4 shadow-sm">
                                    Gérer <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top border-secondary opacity-75 position-relative">
                            <small class="d-flex align-items-center ">
                                <i class="bi bi-clock-history me-2 text-info"></i> 
                                Prochain inventaire bientôt
                            </small>
                        </div>
                    </div>
                </div>
                
                {{-- Carte Activité Récente --}}
                <div class="col-12">
                    <div class="content-card border-0 shadow-sm p-4 bg-white rounded-4">
                        <h6 class="fw-black text-uppercase small text-muted mb-4" style="letter-spacing: 1px;">Flux d'activité</h6>
                        <ul class="list-unstyled mb-0">
                            
                            {{-- DERNIÈRE INTERVENTION --}}
                            @if($derniereIntervention)
                            <li class="d-flex mb-4">
                                <div class="activity-dot bg-success mt-1 shadow-sm"></div>
                                <div class="ms-3">
                                     Dernier Appareil modifié :
                                    <p class="mb-0 small fw-bold text-dark">
                                        {{ $derniereIntervention->appareils->marque_appareil ?? 'Appareil' }} {{ $derniereIntervention->appareils->nom_appareil ?? '#' . $derniereIntervention->id_appareil }}
                                    </p>
                                    <small class="text-muted">
                                        <span class="text-primary fw-bold"> </span> 
                                    </small>
                                </div>
                            </li>
                            @endif

                            {{-- DERNIÈRE PIÈCE ENREGISTRÉE --}}
                            @if($dernierePiece)
                            <li class="d-flex">
                                <div class="activity-dot bg-warning mt-1 shadow-sm"></div>
                                <div class="ms-3">
                                    <p class="mb-0 small fw-bold text-dark">Nouvel arrivage : {{ $dernierePiece->Nom }}</p>
                                    <small class="text-muted">
                                        {{ $dernierePiece->Stock }} unités ajoutées 
                                    </small>
                                </div>
                            </li>
                            @else
                            <li class="text-center py-3">
                                <small class="text-muted italic">Aucun mouvement récent</small>
                            </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap');

    :root {
        --primary-soft: #f0f4ff;
        --success-soft: #ecfdf5;
        --warning-soft: #fffbeb;
        --primary-color: #4e73df;
    }

    body { 
        background-color: #f4f7fe; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fw-black { font-weight: 800; }

    /* Header */
    .dashboard-header {
        border-radius: 2rem !important;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }
    .date-pill {
        background: white;
        padding: 10px 20px;
        border-radius: 15px;
        font-weight: 700;
        color: #2d3748;
    }

    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        padding: 28px;
        border-radius: 24px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);
    }

    .stat-icon {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-right: 20px;
    }

    /* Content */
    .content-card {
        border-radius: 30px !important;
        padding: 30px;
        background: white;
    }

    .activity-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
        border: 2px solid #fff;
    }

    .bg-dark {
        background-color: #1a202c !important;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .stat-card { animation: fadeIn 0.5s ease forwards; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Horloge temps réel
        setInterval(() => {
            const now = new Date();
            document.getElementById('liveClock').innerText = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }, 1000);

        const ctx = document.getElementById('interventionsChart').getContext('2d');
        
        // Gradient pour le graphique
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.2)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($jours ?? []) !!},
                datasets: [{
                    label: 'Interventions',
                    data: {!! json_encode($donneesGraphique ?? []) !!},
                    borderColor: '#4e73df',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.45,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4e73df',
                    pointBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#f0f0f0', drawTicks: false }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection