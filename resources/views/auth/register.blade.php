<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AppliMaintenance') }} - Inscription</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/AppMaint.jpg') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light d-flex align-items-center min-vh-100">

    <div class="container py-5">
        <div class="row justify-content-center w-100 m-0">
            <div class="col-md-6 col-lg-5">
                
                {{-- Logo et Titre --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('image/AppMaint.jpg') }}" alt="Logo" width="70" class="rounded shadow-sm mb-2">
                    <h3 class="fw-bold text-primary">Appli <span class="text-dark">Maintenance</span></h3>
                </div>

                {{-- Carte d'inscription --}}
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-white border-0 pt-4 text-center">
                        <h4 class="fw-bold">{{ __('Créer un compte') }}</h4>
                        <p class="text-muted small">Inscrivez-vous pour accéder à la plateforme</p>
                    </div>

                    <div class="card-body p-4 pt-2">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Nom --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold small text-uppercase">{{ __('Nom Complet') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                    <input id="name" type="text" class="form-control bg-light border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Ex: Jean Dupont">
                                </div>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold small text-uppercase">{{ __('Adresse E-mail') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input id="email" type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="nom@exemple.com">
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold small text-uppercase">{{ __('Mot de passe') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                    <input id="password" type="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-bold small text-uppercase">{{ __('Confirmer le mot de passe') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-check2-circle"></i></span>
                                    <input id="password-confirm" type="password" class="form-control bg-light border-start-0" name="password_confirmation" required placeholder="••••••••">
                                </div>
                            </div>

                            {{-- Role user or Admin --}}
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="role" value="admin" id="role" {{ old('role') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="role">
                                    {{ __('Admin') }}
                                </label>
                            </div>

                            {{-- Button --}}
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2 fw-bold text-uppercase">
                                    {{ __('S\'inscrire') }}
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <span class="small text-muted">Déjà un compte ?</span>
                                <a class="btn btn-link btn-sm text-decoration-none fw-bold" href="{{ route('login') }}">
                                    {{ __('Se connecter ici') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-4 small">© 2026 AppliMaintenance - Tous droits réservés</p>
            </div>
        </div>
    </div>

</body>
</html>