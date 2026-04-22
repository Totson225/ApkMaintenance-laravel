<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AppliMaintenance</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center w-100 m-0">
            <div class="col-md-5">
                
                <div class="text-center mb-4">
                    <img src="{{ asset('image/AppMaint.jpg') }}" alt="Logo" width="70" class="rounded shadow-sm mb-2">
                    <h3 class="fw-bold text-primary">Appli <span class="text-dark">Maintenance</span></h3>
                </div>

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-white border-0 pt-4 text-center">
                        <h4 class="fw-bold">{{ __('Connexion') }}</h4>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold small text-uppercase">{{ __('Adresse E-mail') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input id="email" type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold small text-uppercase">{{ __('Mot de passe') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                    <input id="password" type="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" name="password" required>
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Remember Me --}}
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">
                                    {{ __('Se souvenir de moi') }}
                                </label>
                            </div>

                            {{-- Button --}}
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2 fw-bold text-uppercase">
                                    {{ __('Se connecter') }}
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a class="btn btn-link btn-sm text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <p class="text-center text-muted mt-4 small">© 2026 AppliMaintenance - Tous droits réservés</p>
            </div>
        </div>
    </div>

</body>
</html>