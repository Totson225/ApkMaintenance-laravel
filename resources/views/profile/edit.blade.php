@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="mb-5">
        <h2 class="fw-bold text-dark d-flex align-items-center">
            <i class="bi bi-person-circle me-3 text-primary"></i>
            {{ __('Paramètres du Profil') }}
        </h2>
        <p class="text-muted">Gérez vos informations personnelles et la sécurité de votre compte.</p>
        <hr class="opacity-10">
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="mb-4">
                @include('profile.partials.update-password-form')
            </div>



        </div>
    </div>
</div>
@endsection