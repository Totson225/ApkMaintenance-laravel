<section class="card border-danger mb-4">
    <div class="card-header bg-danger text-white">
        <h2 class="h5 mb-0">{{ __('Suppression du compte') }}</h2>
    </div>

    <div class="card-body">
        <p class="text-muted small">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de procéder à la suppression, veuillez télécharger les données ou informations que vous souhaitez conserver.') }}
        </p>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
            {{ __('Supprimer mon compte') }}
        </button>
    </div>

    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="confirmUserDeletionLabel">
                            {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-secondary small">
                            {{ __('Veuillez saisir votre mot de passe pour confirmer la suppression définitive.') }}
                        </p>

                        <div class="mt-3">
                            <label for="password" class="visually-hidden">{{ __('Mot de passe') }}</label>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                placeholder="{{ __('Mot de passe') }}"
                                required
                            >

                            @if($errors->userDeletion->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->userDeletion->first('password') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Retour') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ __('Supprimer définitivement') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>