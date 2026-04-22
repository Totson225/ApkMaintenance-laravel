<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AppMaintenance</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/AppMaint.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
       .nav-link.active-menu {
            border-bottom: 2px solid #0d6efd; 
            color: #0d6efd !important;   
            border-radius: 5px;
        }
        
        .nav-item {
            margin-left: 5px;
        }

        .nav-link:hover:not(.active-menu) {
            background-color: #e9ecef;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg shadow-sm">
            <div class="container-fluid d-flex ">
                <a class="navbar-brand" href="{{ url('home') }}">
                    <img src="{{ asset('image/AppMaint.jpg') }}" alt="Logo" width="40" height="40">
                    <span class="fw-bold text-dark text-uppercase" style="letter-spacing: 0.2px;">
                    Appli <span class="text-primary">Maintenance</span>          
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        {{-- Intervention --}}
                        <li class="nav-item">
                        <a class="nav-link fw-bold text-uppercase {{ Route::is('interventions.*') ? 'active-menu' : 'text-dark' }}" 
                            href="{{ route('interventions.index') }}">
                            <i class=" bi bi-journals"></i> Interventions
                        </a>
                        </li>

                        <li class="nav-item">
                        <a class="nav-link fw-bold text-uppercase {{ Route::is('demandeurs.*') ? 'active-menu' : 'text-dark' }}" 
                                href="{{ route('demandeurs.index') }}">
                                <i class=" bi bi-people"></i> Demandeurs
                            </a>
                        </li>

                        {{-- Technicien --}}
                        <li class="nav-item">
                        <a class="nav-link fw-bold text-uppercase {{ Route::is('techniciens.*') ? 'active-menu' : 'text-dark' }}"
                            href="{{ route('techniciens.index') }}">
                            <i class=" bi bi-person-fill-gear"></i> Techniciens
                        </a>
                        </li>

                        {{-- appareil --}}
                        <li class="nav-item">
                        <a class="nav-link fw-bold text-uppercase {{ Route::is('appareils.*') ? 'active-menu' : 'text-dark' }}"
                            href="{{ route('appareils.index') }}">
                            <i class=" bi-laptop"></i> appareils
                        </a>
                        </li>

                        {{-- materiel --}}
                        <li class="nav-item">
                        <a class="nav-link fw-bold text-uppercase {{ Route::is('materiels.*') ? 'active-menu' : 'text-dark' }}"
                            href="{{ route('materiels.index') }}">
                            <i class="bi bi-tools"></i> materiels
                        </a>
                        </li>

                        {{-- piece de rechange --}}
                        <li class="nav-item">
                        <a class="nav-link fw-bold text-uppercase {{ Route::is('pieces.*') ? 'active-menu' : 'text-dark' }}"
                            href="{{ route('pieces.index') }}">
                            <i class="bi-box-seam"></i> Piece de rechange
                        </a>
                        </li>
                        
                    </ul>



                    <!-- Right Side Of Navbar -->
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<style>
    body {
        margin: 0;
        min-height: 100vh;
        overflow-x: hidden; /* Empêche le scroll horizontal dû à l'animation */
        position: relative;
        background-color: #ffffff;
    }

    /* Le calque qui contient le dégradé bleuté, couvrant TOUTE la page */
    body::before {
        content: "";
        position: fixed; /* Reste fixe par rapport à l'écran, même au scroll */
        top: 0;
        left: 0;
        width: 200%; /* Largeur doublée pour l'effet de glisse */
        height: 100vh; /* Couvre toute la hauteur visible */
        z-index: -1; /* Reste derrière TOUT le contenu, incluant la navbar */
        
        /* --- Bleu AUGMENTÉ ici --- */
        /* Opacité passée de 0.08 à 0.20 pour une meilleure visibilité */
        background: linear-gradient(
            to right, 
            rgba(255, 255, 255, 0) 0%, 
            rgba(13, 110, 253, 0.20) 25%, /* <--- Bleu plus prononcé */
            rgba(255, 255, 255, 0) 50%,
            rgba(13, 110, 253, 0.20) 75%, /* <--- Bleu plus prononcé */
            rgba(255, 255, 255, 0) 100%
        );

        /* Animation ultra-fluide */
        animation: smoothSwipe 15s linear infinite;
        will-change: transform; /* Optimisation pour mobile */
    }

    @keyframes smoothSwipe {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%); /* Glisse de la moitié pour boucler parfaitement */
        }
    }

    /* --- Style pour la Navbar --- */
    .navbar {
        /* On retire ton dégradé fixe et on met un fond transparent */
        background: transparent !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Petite ligne subtile pour séparer */
    }

    /* Style pour les liens de la navbar pour qu'ils restent lisibles */
    .nav-link {
        color: rgba(0, 0, 0, 0.7) !important;
    }

    .nav-link.active-menu {
        border-bottom: 2px solid #065cde; 
        color: #065cde !important;   
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.5); /* Léger fond pour l'item actif */
    }
    
    .nav-item {
        margin-left: 5px;
    }

    .nav-link:hover:not(.active-menu) {
        background-color: rgba(233, 236, 239, 0.7); /* Fond au survol légèrement transparent */
        border-radius: 5px;
    }
</style>
</html>
