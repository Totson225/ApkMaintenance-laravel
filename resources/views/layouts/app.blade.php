<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/AppMaint.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

<style>
    :root {
        --primary-color: #0d6efd;
        --primary-light: #e7f1ff;
        --navbar-height: 70px;
        --transition-speed: 0.3s;
        --glass-border: rgba(255, 255, 255, 0.3);
        --swipe-gradient: linear-gradient(
            90deg, 
            rgba(255, 255, 255, 0) 0%, 
            rgba(13, 110, 253, 0.15) 25%, 
            rgba(255, 255, 255, 0) 50%,
            rgba(13, 110, 253, 0.15) 75%,
            rgba(255, 255, 255, 0) 100%
        );
        --swipe-speed: 12s;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
        color: #1e293b;
        margin: 0;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* FOND ANIMÉ */
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0; width: 200%; height: 100%;
        z-index: -10;
        background: var(--swipe-gradient);
        animation: smoothSwipe var(--swipe-speed) linear infinite;
        pointer-events: none;
    }

    @keyframes smoothSwipe {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

    /* NAVBAR STYLISÉE */
    .navbar {
        height: var(--navbar-height);
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-bottom: 1px solid var(--glass-border);
        padding: 0 1rem;
        z-index: 1000;
    }

    .navbar::after {
        content: "";
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 30%; 
        background: linear-gradient(90deg, rgba(13, 110, 253, 0.05) 0%, rgba(13, 110, 253, 0.15) 100%);
        z-index: -1;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-link {
        padding: 0.5rem 1.2rem !important;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569 !important;
        transition: all var(--transition-speed);
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: 10px;
    }

    .nav-link:hover {
        color: var(--primary-color) !important;
    }

    .nav-link.active-menu {
        color: var(--primary-color) !important;
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* BLOC UTILISATEUR */
    .auth-nav-item {
        background: white;
        border-radius: 50px;
        padding: 4px 16px 4px 6px !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-left: 20px;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 12px;
        padding: 0.5rem;
        margin-top: 10px;
    }

    main {
        padding-top: 2.5rem;
    }

    @media (max-width: 991px) {
        .navbar { height: auto; padding: 1rem; }
        .navbar::after { display: none; }
    }
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container-fluid">
                {{-- Logo --}}
                <a class="navbar-brand" href="{{ url('home') }}">
                    <div class="logo-container bg-white shadow-sm p-1 rounded-circle" style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('image/AppMaint.png') }}" alt="Logo" width="28" height="28">
                    </div>
                    <span class="fw-bold text-dark text-uppercase d-none d-sm-inline" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                        Appli <span class="text-primary">Maintenance</span>
                    </span>
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="bi bi-list fs-1"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto gap-1">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('interventions.*') ? 'active-menu' : '' }}" href="{{ route('interventions.index') }}">
                                <i class="bi bi-calendar-check"></i> Interventions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('demandeurs.*') ? 'active-menu' : '' }}" href="{{ route('demandeurs.index') }}">
                                <i class="bi bi-people-fill"></i> Demandeurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('techniciens.*') ? 'active-menu' : '' }}" href="{{ route('techniciens.index') }}">
                                <i class="bi bi-person-gear"></i> Techniciens
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('appareils.*') ? 'active-menu' : '' }}" href="{{ route('appareils.index') }}">
                                <i class="bi bi-laptop"></i> Appareils
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('materiels.*') ? 'active-menu' : '' }}" href="{{ route('materiels.index') }}">
                                <i class="bi bi-tools"></i> Matériels
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('pieces.*') ? 'active-menu' : '' }}" href="{{ route('pieces.index') }}">
                                <i class="bi bi-box-seam"></i> Pièces
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link fw-bold text-primary" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown auth-nav-item">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-0" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="text-dark fw-semibold" style="font-size: 0.85rem;">{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end border-0">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person me-2"></i> Mon Profil
                                    </a>
                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <a class="dropdown-item" href="{{ route('adminspace') }}">
                                            <i class="bi bi-shield-lock me-2"></i> Administration
                                        </a>
                                    @endif
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Déconnexion') }}
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

        <main class="container">
            @yield('content')
        </main>
    </div>
</body>
</html>