<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppliMaintenance | Accuiel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

<style>
    :root {
        --primary: #0d6efd;
        --primary-soft: rgba(13, 110, 253, 0.1);
        --glass-bg: rgba(255, 255, 255, 0.65);
        --glass-border: rgba(255, 255, 255, 0.4);
        --card-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1);
        --swipe-gradient: linear-gradient(
            120deg, 
            rgba(255, 255, 255, 0) 0%, 
            rgba(13, 110, 253, 0.15) 35%, 
            rgba(255, 255, 255, 0) 70%
        );
        --swipe-speed: 15s;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* Animation de fond */
    body::before {
        content: "";
        position: fixed;
        top: -50%; left: -50%; 
        width: 200%; height: 200%;
        z-index: -2;
        background: var(--swipe-gradient);
        animation: smoothSwipe var(--swipe-speed) ease-in-out infinite alternate;
        pointer-events: none;
    }

    @keyframes smoothSwipe {
        from { transform: rotate(0deg) translateX(-10%); }
        to { transform: rotate(5deg) translateX(10%); }
    }

    .navbar {
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        background: rgba(255, 255, 255, 0.7);
        border-bottom: 1px solid var(--glass-border);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
    }

    .grid-menu {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    .menu-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 30px;
        display: flex;
        align-items: center;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        box-shadow: var(--card-shadow);
        text-decoration: none !important;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease backwards;
    }

    .menu-card:hover {
        transform: translateY(-12px) scale(1.02);
        background: #ffffff;
        box-shadow: 0 25px 50px -12px rgba(13, 110, 253, 0.15);
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-icon {
        width: 64px; height: 64px;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin-right: 20px;
        background: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        transition: all 0.5s ease;
    }

    .menu-card:hover .card-icon {
        transform: rotate(12deg);
        color: white !important;
        background: var(--accent-color);
    }

    .card-info h3 { 
        margin: 0; 
        font-size: 1.2rem; 
        font-weight: 800; 
        color: #1e293b;
    }
    
    .card-info span { 
        font-size: 0.9rem; 
        color: #64748b; 
    }

    .card-full {
        grid-column: 1 / -1;
        justify-content: center; 
        background: linear-gradient(90deg, rgba(16, 185, 129, 0.05), rgba(255, 255, 255, 0.7));
        border: 2px dashed rgba(16, 185, 129, 0.3);
    }

    .card-full .card-info {
        text-align: center;
    }

    .card-full .card-icon {
        margin-right: 20px; 
    }

    .dashboard-header {
        position: relative;
        padding-left: 25px;
        border-left: 6px solid var(--primary);
    }

    /* Couleurs Accent */
    .color-5 { --accent-color: #ef4444; }
    .color-2 { --accent-color: #f59e0b; }
    .color-9 { --accent-color: #eab308; }
    .color-4 { --accent-color: #8b5cf6; }
    .color-1 { --accent-color: #3b82f6; }
    .color-6 { --accent-color: #ec4899; }
    .color-7 { --accent-color: #10b981; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Délais d'apparition */
    .menu-card:nth-child(1) { animation-delay: 0.1s; }
    .menu-card:nth-child(2) { animation-delay: 0.2s; }
    .menu-card:nth-child(3) { animation-delay: 0.3s; }
    .menu-card:nth-child(4) { animation-delay: 0.4s; }
    .menu-card:nth-child(5) { animation-delay: 0.5s; }
    .menu-card:nth-child(6) { animation-delay: 0.6s; }
    .menu-card:nth-child(7) { animation-delay: 0.7s; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top py-3">
    <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="logo-container bg-white shadow-sm p-1 rounded-circle" style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('image/AppMaint.png') }}" alt="Logo" width="28" height="28">
                    </div>
                    <span class="fw-bold text-dark text-uppercase d-none d-sm-inline" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                        Appli <span class="text-primary">Maintenance</span>
                    </span>
                </a>

        <div class="ms-auto">
            <ul class="navbar-nav align-items-center">
                @guest
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-primary" href="{{ route('login') }}">Connexion</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 bg-white px-3 py-2 rounded-pill shadow-sm" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-dark fw-bold">{{ Auth::user()->name }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-2 rounded-4">
                            <a class="dropdown-item rounded-3" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Mon Profil</a>
                            @if(auth()->user()->role === 'admin')
                                <a class="dropdown-item rounded-3" href="{{ route('adminspace') }}"><i class="bi bi-shield-lock me-2"></i> Administration</a>
                            @endif
                            <hr class="dropdown-divider">
                            <a class="dropdown-item rounded-3 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                            </a>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <header class="dashboard-header mb-5">
        <h1 class="display-6 fw-800">Atelier Informatique</h1>
        <p class="text-muted fs-5">Pilotez vos opérations de maintenance en temps réel.</p>
    </header>

    <main> 
        <div class="grid-menu">
            <a href="{{ route('interventions.index') }}" class="menu-card color-5">
                <div class="card-icon"><i class="bi bi-journals"></i></div>
                <div class="card-info">
                    <h3>Interventions</h3>
                    <span>Gérer les dépannages</span>
                </div>
            </a>
            
            <a href="{{ route('techniciens.index') }}" class="menu-card color-2">
                <div class="card-icon"><i class="bi bi-person-fill-gear"></i></div>
                <div class="card-info">
                    <h3>Techniciens</h3>
                    <span>Liste des intervenants</span>
                </div>
            </a>
            
            <a href="{{ route('demandeurs.index') }}" class="menu-card color-9">
                <div class="card-icon"><i class="bi bi-people"></i></div>
                <div class="card-info">
                    <h3>Demandeurs</h3>
                    <span>Clients & Services</span>
                </div>
            </a>

            <a href="{{ route('appareils.index') }}" class="menu-card color-4">
                <div class="card-icon"><i class="bi bi-laptop"></i></div>
                <div class="card-info">
                    <h3>Appareils</h3>
                    <span>Gestion du parc</span>
                </div>
            </a>

            <a href="{{ route('materiels.index') }}" class="menu-card color-1">
                <div class="card-icon"><i class="bi bi-tools"></i></div>
                <div class="card-info">
                    <h3>Matériels</h3>
                    <span>Inventaire équipements</span>
                </div>
            </a>

            <a href="{{ route('pieces.index') }}" class="menu-card color-6">
                <div class="card-icon"><i class="bi bi-box-seam"></i></div>
                <div class="card-info">
                    <h3>Pièces Rechanges</h3>
                    <span>Suivi du stock</span>
                </div>
            </a>

            <a href="{{ route('dashbord') }}" class="menu-card color-7 card-full">
                <div class="card-icon"><i class="bi bi-bar-chart-steps"></i></div>
                <div class="card-info">
                    <h3>Dashboard</h3>
                    <span>Accéder aux statistiques avancées</span>
                </div>
            </a>
        </div>
    </main>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

</body>
</html>