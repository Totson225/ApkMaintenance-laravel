<section class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h2 class="h5 mb-0 text-dark">
            {{ __('Informations du profil') }}
        </h2>
        <p class="text-muted small mb-0">
            {{ __("Mettez à jour les informations de profil et l'adresse e-mail de votre compte.") }}
        </p>
    </div>

    <div class="card-body">

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Nom') }}</label>
                <input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name', $user->name) }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                >
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email', $user->email) }}" 
                    required 
                    autocomplete="username"
                >
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 p-2 border rounded bg-light">
                        <p class="text-sm text-dark mb-1">
                            {{ __("Votre adresse e-mail n'est pas vérifiée.") }}
                        </p>
                        <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-none">
                            {{ __("Cliquez ici pour renvoyer l'e-mail de vérification.") }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <div class="mt-2 text-success small fw-bold">
                                {{ __('Un nouveau lien de vérification a été envoyé.') }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('Sauvegarder') }}
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success small">
                        <i class="bi bi-check-lg"></i> {{ __('Sauvegardé.') }}
                    </span>
                @endif
            </div>
        </form>
    </div>
</section>