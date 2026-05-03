<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AppliMaintenance | Enregistrement</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/AppMaint.png') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #f8f9fa, #e9ecef);
        }
        .register-card {
            border: none;
            border-radius: 1.25rem;
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
        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
            color: #0d6efd;
        }
        .btn-register {
            padding: 0.8rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.2);
        }
        .role-selector {
            background-color: #f8f9fa;
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid #e9ecef;
        }
    </style>
</head>

<body class="min-vh-100 d-flex align-items-center py-5">

    <div class="container">
        <div class="row justify-content-center m-0">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                
                {{-- Logo & Header --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('image/AppMaint.png') }}" alt="Logo" width="75" class="rounded-3 shadow-sm mb-3">
                    <h1 class="h3 fw-bold mb-1">Créer un compte</h1>
                    <p class="text-muted small">Rejoignez la plateforme de gestion technique</p>
                </div>

                <div class="card register-card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                {{-- Nom --}}
                                <div class="col-12 mb-3">
                                    <label for="name" class="form-label small fw-semibold text-muted">{{ __('Nom Complet') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"><i class="bi bi-person"></i></span>
                                        <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Ex: Jean Dupont" autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-12 mb-3">
                                    <label for="email" class="form-label small fw-semibold text-muted">{{ __('Adresse E-mail') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"><i class="bi bi-envelope"></i></span>
                                        <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="nom@entreprise.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label small fw-semibold text-muted">{{ __('Mot de passe') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"><i class="bi bi-lock"></i></span>
                                        <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                                        <button class="input-group-text bg-transparent border-start-0" type="button" id="togglePassword">
                                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password-confirm" class="form-label small fw-semibold text-muted">{{ __('Confirmation') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"><i class="bi bi-check2-circle"></i></span>
                                        <input id="password-confirm" type="password" class="form-control border-start-0" name="password_confirmation" required placeholder="••••••••">
                                        <button class="input-group-text bg-transparent border-start-0" type="button" id="togglePasswordConfirm">
                                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Role Selection --}}
                            <div class="mb-4 pt-2">
                                <div class="role-selector">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="role" value="admin" id="role" {{ old('role') ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-medium text-dark" for="role">
                                            {{ __('Attribuer les privilèges Administrateur') }}
                                        </label>
                                    </div>
                                    <div class="form-text mt-1" style="font-size: 0.75rem;">
                                        Cochez cette case si vous gérez les interventions techniques.
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-register shadow-sm">
                                    {{ __('Créer un compte') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Footer --}}
                <footer class="text-center mt-5">
                    <p class="text-muted small">
                        &copy; {{ date('Y') }} <strong>AppliMaintenance</strong><br>
                        <span class="opacity-50 text-uppercase" style="letter-spacing: 1px;">Service de maintenance informatique</span>
                    </p>
                </footer>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupToggle(buttonId, inputId) {
                const btn = document.getElementById(buttonId);
                const input = document.getElementById(inputId);
                const icon = btn.querySelector('i');

                if (btn && input) {
                    btn.addEventListener('click', function() {
                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';
                        icon.classList.toggle('bi-eye');
                        icon.classList.toggle('bi-eye-slash');
                    });
                }
            }

            setupToggle('togglePassword', 'password');
            setupToggle('togglePasswordConfirm', 'password-confirm');
        });
    </script>

</body>
</html>