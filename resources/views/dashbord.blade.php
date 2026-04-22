@extends('layouts.app')

@section('content')
<div class="container dashboard-container">
  <header class="dashboard-header mb-5">
    <h1 class="fw-bold">Tableau de bord</h1>
    <p class="text-muted">Bienvenue dans votre espace de gestion. :</p>
  </header>

  <div class="grid-menu">

        <a href="#" class="menu-card text-primary ">
            <div class="card-info">
                <h3 class="mb-1">Interventions</h3>
                
                <div class="stats-mini d-flex flex-column">
                    <span class="text-success small">
                        <i class="bi bi-check-circle-fill"></i> <strong>{{ $achevees }}</strong> achevées
                    </span>
                    <span class="text-danger small">
                        <i class="bi bi-clock-history"></i> <strong>{{ $inachevees }}</strong> en attente
                    </span>
                </div>
            </div>
        </a>

        <a href="#" class="menu-card text-primary ">
            <div class="card-info">
                <h3 class="mb-1">Techniciens</h3>
                
                <div class="stats-mini d-flex flex-column">
                    <span class="text-danger small">
                        <i class="bi bi-clock-history"></i> <strong>{{ $occupe }}</strong> Occupé
                    </span>
                    <span class="text-success small">
                        <i class="bi bi-check-circle-fill"></i> <strong>{{ $disponible }}</strong> Libre
                    </span>
                </div>
            </div>
        </a>
        
        {{-- Appareil --}}
        <a href="#" class="menu-card text-primary ">
            <div class="card-info">
                <h3 class="mb-1">Appareil</h3>
                
                <div class="stats-mini d-flex flex-column">
                    <span class="text-success small">
                        <i class="bi bi-check-circle-fill"></i> <strong>{{ $reparer }}</strong> réparer
                    </span>
                    <span class="text-danger small">
                        <i class="bi bi-clock-history"></i> <strong>{{ $endommager }}</strong> endommager
                    </span>
                </div>
            </div>
        </a>
        
        {{-- Materiel --}}
        <a href="#" class="menu-card text-primary ">
            <div class="card-info">
                <h3 class="mb-1">Materiel</h3>
                
                <div class="stats-mini d-flex flex-column">
                    <span class="text-success small">
                        <i class="bi bi-check-circle-fill"></i> <strong>{{ $opp }}</strong> opérationnel
                    </span>
                    <span class="text-danger small">
                        <i class="bi bi-clock-history"></i> <strong>{{ $ind }}</strong> indisponible
                    </span>
                </div>
            </div>
        </a>

        {{-- piece --}}
        <a href="#" class="menu-card text-primary">
            <div class="card-info">
                <h3 class="mb-1">Stock Total des Pieces de Rechange</h3>
                <div class="stats-mini d-flex flex-column">
                    <span class="text-dark fw-bold" style="font-size: 1.2rem;">
                        <i class="bi bi-box-seam"></i> {{ $nbe }} <small class="text-muted">unités</small>
                    </span>
                </div>
            </div>
        </a>

    </div>

    {{-- Graphique --}}
    <div class="card shadow-sm border-0 rounded-3 mt-5 p-4 w-100">
    <h3 class="fw-bold mb-4 text-primary">Graphe des Interventions (Ce mois-ci)</h3>
    <div style="position: relative; height: 300px; width: 100%;">
        <canvas id="interventionsChart"></canvas>
    </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script class="card-full">
        const ctx = document.getElementById('interventionsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($jours) !!},
                datasets: [{
                    label: 'Interventions',
                    data: {!! json_encode($donneesGraphique) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
        });
    </script>
</div>

<style>

    
    .dashboard-container { 
        padding: 20px 0; 
        max-width: 1100px;
        margin: 0 auto;    
    }

    .dashboard-header { 
        border-left: 5px solid #0d6efd; 
        padding-left: 20px; 
    }

    .card-full {
        grid-column: 1 / -1;
        justify-content: center;
        background: linear-gradient(to right, #ffffff, #f8f9fa); 
        border: 2px solid #19cf0c;
    }
    
    .grid-menu {
        display: grid;
        grid-template-columns: repeat(3, 1fr); 
        gap: 25px;
        width: 100%;
    }

    @media (max-width: 992px) {
        .grid-menu { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .grid-menu { grid-template-columns: 1fr; }
    }

    option: {
        responsive: true,
        maintAspectRatio: false,
  
    }

    .card-full {
        grid-column: 1 / -1;
        justify-content: center;
        background: linear-gradient(to right, #ffffff, #f8f9fa); 
        border: 2px solid #19cf0c;
    }

    @media (max-width: 600px) {
        .card-full {
            justify-content: flex-start;
        }
    }

    .menu-card {
        display: flex;
        align-items: center;
        padding: 25px;
        background: #fff;
        border-radius: 15px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #edf2f7;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        background-color: #fcfcfc;
    }

    .card-info h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
    .card-info span { font-size: 0.8rem; color: #6c757d; }

</style>

@endsection