<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Plateforme de gestion de maintenance">

    <title>AppliMaintenance | Connexion</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/AppMaint.png') }}">
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #f8f9fa, #e9ecef);
        }
        .login-card {
            border: none;
            border-radius: 1.25rem;
            transition: transform 0.3s ease;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            color: #6c757d;
        }
        .form-control {
            border-color: #e9ecef;
            padding: 0.75rem 1rem;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
        }
        /* Style spécial pour l'input group au focus */
        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
            color: #0d6efd;
        }
        .btn-login {
            padding: 0.8rem;
            border-radius: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.2);
        }
        .brand-logo {
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
    </style>
</head>

<body class="min-vh-100 d-flex align-items-center py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                
                {{-- Logo & Header --}}
                <div class="text-center mb-5">
                    <div class="mb-3">
                        <img src="{{ asset('image/AppMaint.png') }}" alt="Logo" width="80" class="brand-logo rounded-3">
                    </div>
                    <h1 class="h3 fw-bold mb-1">Bienvenue</h1>
                    <p class="text-muted">Connectez-vous à votre espace maintenance</p>
                </div>

                <div class="card login-card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Identifiant (Email) --}}
                            <div class="mb-4">
                                <label for="email" class="form-label small fw-semibold text-muted">{{ __('Adresse E-mail') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input id="email" type="email" 
                                           class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           placeholder="nom@entreprise.com"
                                           required autocomplete="email" autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Mot de passe --}}
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label small fw-semibold text-muted mb-0">{{ __('Mot de passe') }}</label>
                                    @if (Route::has('password.request'))
                                        <a class="small text-decoration-none fw-medium" href="{{ route('password.request') }}">
                                            {{ __('Oublié ?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="bi bi-shield-lock"></i>
                                    </span>
                                    <input id="password" type="password" 
                                           class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="current-password"
                                           placeholder="••••••••">
                                    <button class="input-group-text bg-transparent border-start-0" type="button" id="togglePassword">
                                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Remember Me --}}
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small text-muted" for="remember">
                                        {{ __('Rester connecté') }}
                                    </label>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-login shadow-sm">
                                    {{ __('Se connecter') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Footer --}}
                <footer class="text-center mt-5">
                    <p class="text-muted small">
                        &copy; {{ date('Y') }} <strong>{{ config('app.name') }}</strong><br>
                        <span class="opacity-50">Système de gestion technique v2.0</span>
                    </p>
                </footer>

            </div>
        </div>
    </div>

    {{-- Script pour le toggle password --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');

            togglePassword.addEventListener('click', function () {
                const isPassword = password.getAttribute('type') === 'password';
                password.setAttribute('type', isPassword ? 'text' : 'password');
                
                // Toggle l'icône
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>
</html>