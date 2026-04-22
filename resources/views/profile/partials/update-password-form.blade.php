<section class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h2 class="h5 mb-0 text-dark">
            {{ __('Modifier le mot de passe') }}
        </h2>
        <p class="text-muted small mb-0">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.') }}
        </p>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('profile.password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">{{ __('Ancien mot de passe') }}</label>
                <input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                    autocomplete="current-password"
                >
                @if($errors->updatePassword->has('current_password'))
                    <div class="invalid-feedback">
                        {{ $errors->updatePassword->first('current_password') }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label">{{ __('Nouveau mot de passe') }}</label>
                <input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                    autocomplete="new-password"
                >
                @if($errors->updatePassword->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->updatePassword->first('password') }}
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                <input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                    autocomplete="new-password"
                >
                @if($errors->updatePassword->has('password_confirmation'))
                    <div class="invalid-feedback">
                        {{ $errors->updatePassword->first('password_confirmation') }}
                    </div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('Sauvegarder') }}
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success small animate-fade-out">
                        <i class="bi bi-check-circle-fill me-1"></i>{{ __('Sauvegardé.') }}
                    </span>
                @endif
            </div>
        </form>
    </div>
</section>