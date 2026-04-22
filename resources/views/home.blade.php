<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppliMaintenance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/AppMaint.jpg') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="">
            <img src="{{ asset('image/AppMaint.jpg') }}" alt="Logo" width="40" height="40" class="me-2">
            <span class="fw-bold text-dark text-uppercase">
                Appli <span class="text-primary">Maintenance</span>
            </span>
        </a>

        <div class="ms-auto d-flex align-items-center">
                    <ul class="navbar-nav ms-auto">

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Enregistrer') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Mon Profil</a>
                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <a class="dropdown-item" href="{{ route('adminspace') }}">Utilisateur</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Deconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
        </div>
    </div>
</nav>
<div class="container dashboard-container">
    

    {{-- Entete Principal --}}
    <header class="dashboard-header mb-5">
        <h1 class="fw-bold">Atelier Informatique</h1>
        <p class="text-muted">Bienvenue dans votre espace de gestion. Choisissez une option ci-dessous :</p>
    </header>

    {{-- Menu --}}
    <main> 
        <div class="grid-menu">

            {{-- Intervention --}}
            <a href="{{ route('interventions.index') }}" class="menu-card color-5">
                <div class="card-icon"><i class="bi bi-journals"></i></div>
                <div class="card-info">
                    <h3>Interventions</h3>
                    <span>Gérer les dépannages</span>
                </div>
            </a>
            
            {{-- Technicien --}}
            <a href="{{ route('techniciens.index') }}" class="menu-card color-2">
                <div class="card-icon"><i class="bi bi-person-fill-gear"></i></div>
                <div class="card-info">
                    <h3>Techniciens</h3>
                    <span>Liste des intervenants</span>
                </div>
            </a>
            
            {{-- Demandeur --}}
            <a href="{{ route('demandeurs.index') }}" class="menu-card color-9">
                <div class="card-icon"><i class="bi-people"></i></div>
                <div class="card-info">
                    <h3>Demandeurs</h3>
                    <span>Clients & Services</span>
                </div>
            </a>

            {{-- Appareils --}}
            <a href="{{ route('appareils.index') }}" class="menu-card color-4">
                <div class="card-icon"><i class="bi-laptop"></i></div>
                <div class="card-info">
                    <h3>Appareils</h3>
                    <span>Gestion du parc</span>
                </div>
            </a>

            {{-- Materiel --}}
            <a href="{{ route('materiels.index') }}" class="menu-card color-1">
                <div class="card-icon"><i class="bi bi-tools"></i></div>
                <div class="card-info">
                    <h3>Matériels</h3>
                    <span>Inventaire des équipements</span>
                </div>
            </a>
            

            {{-- Piece de rechange --}}
            <a href="{{ route('pieces.index') }}" class="menu-card color-6">
                <div class="card-icon"><i class="bi-box-seam"></i></div>
                <div class="card-info">
                    <h3>Pièces Rechanges</h3>
                    <span>Inventaire des pièces</span>
                </div>
            </a>

            <a href="{{ route('dashbord') }}" class="menu-card color-7 card-full">
                <div class="card-icon"><i class="bi bi-bar-chart-steps"></i></div>
                <div class="card-info">
                    <h3>Dashboard</h3>
                    <span>Statistiques de l'atelier</span>
                </div>
            </a>
        </div>
    </main>
</div>

<style>
        /* 1. CONFIGURATION GÉNÉRALE */
        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 2. L'ANIMATION DE SWIPE (Fond de page + Navbar) */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 200%; /* Largeur double pour le mouvement */
            height: 100%;
            z-index: -1;
            /* Bleu prononcé pour être bien visible */
            background: linear-gradient(
                to right, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(13, 110, 253, 0.18) 25%, 
                rgba(255, 255, 255, 0) 50%,
                rgba(13, 110, 253, 0.18) 75%,
                rgba(255, 255, 255, 0) 100%
            );
            animation: smoothSwipe 12s linear infinite;
            will-change: transform;
        }

        @keyframes smoothSwipe {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* 3. NAVBAR (Transparente pour laisser passer le swipe) */
        .navbar {
            background: transparent !important; /* Crucial pour le swipe */
            box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
            border-bottom: 1px solid rgba(13, 110, 253, 0.1);
        }

        .nav-link.active-menu {
            border-bottom: 2px solid #0d6efd; 
            color: #0d6efd !important;   
            font-weight: bold;
        }

    .dashboard-container { 
        padding: 20px 0; 
        max-width: 1100px;
        margin: 0 auto;    
    }
    
    .grid-menu {
        display: grid;
        grid-template-columns: repeat(3, 1fr); 
        gap: 25px;
        width: 100%;
    }

        /* 4. DASHBOARD & GRID */
        .dashboard-container { 
            padding: 40px 15px; 
            max-width: 1100px;
            margin: 0 auto;    
        }

        .dashboard-header { 
            border-left: 5px solid #0d6efd; 
            padding-left: 20px; 
            margin-bottom: 40px;
        }
        

        @media (max-width: 992px) { .grid-menu { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .grid-menu { grid-template-columns: 1fr; } }

        /* 5. CARTES DU MENU */
        .menu-card {
            display: flex;
            align-items: center;
            padding: 25px;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent pour l'élégance */
            backdrop-filter: blur(5px); /* Flou derrière les cartes */
            border-radius: 15px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            border: 1px solid rgba(237, 242, 247, 0.8);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            background: #fff;
        }


        .card-full {
            grid-column: 1 / -1;
            border: 2px solid #19cf0c;
            justify-content: center;
        }

        .card-icon { font-size: 2.2rem; margin-right: 20px; min-width: 50px; text-align: center; }
        .card-info h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
        .card-info span { font-size: 0.8rem; color: #6c757d; }

        /* Couleurs des icônes */
        .color-1 .card-icon { color: #3498db; } .color-2 .card-icon { color: #e67e22; } 
        .color-4 .card-icon { color: #9b59b6; } 
        .color-5 .card-icon { color: #e74c3c; } .color-6 .card-icon { color: #ea21d6; }
        .color-7 .card-icon { color: #19cf0c; } .color-9 .card-icon { color: #f0de1c; }
</style>
</body>
</html>