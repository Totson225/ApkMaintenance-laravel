@extends('layouts.app')

@section('title', 'AppliMaintenance | Materiel')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <form action="{{ route('materiels.store') }}" method="post" class="position-relative">
                @csrf

                {{-- Header Flottant --}}
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h2 class="fw-black text-dark mb-1" style="letter-spacing: -1px;">Nouveau Materiel <span class="text-primary">.</span></h2>
                        <p class="text-muted">Indexation du parc matériel technique</p>
                    </div>
                    <div class="no-print">
                        <a href="{{ route('materiels.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    {{-- Colonne de Gauche : Identité Visuelle --}}
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-primary text-white h-100 p-4 d-flex flex-column justify-content-between" style="border-radius: 2rem;">
                            <div>
                                <i class="bi bi-cpu-fill display-1 opacity-25"></i>
                                <h4 class="mt-4 fw-bold">Identification du Matériel</h4>
                                <p class="small opacity-75">Assurez-vous que le numéro de série correspond à l'étiquette physique sur l'appareil.</p>
                            </div>
                            <div class="bg-white bg-opacity-10 p-3 rounded-4">
                                <small class="d-block mb-1 opacity-75">ID Temporaire</small>
                                <span class="font-monospace">#TMP-{{ rand(1000, 9999) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Colonne de Droite : Formulaire Dynamique --}}
                    <div class="col-md-8">
                        <div class="card border-0 shadow-lg p-4" style="border-radius: 2rem;">
                            <div class="row g-3">
                                {{-- Type & Marque sur une ligne stylisée --}}
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="type_materiel" class="form-control border-0 bg-light rounded-4 @error('type_materiel') is-invalid @enderror" id="type" placeholder="Type" value="{{ old('type_materiel') }}">
                                        <label for="type" class="text-muted"><i class="bi bi-tag me-2"></i>Catégorie</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="marque" class="form-control border-0 bg-light rounded-4 @error('marque') is-invalid @enderror" id="brand" placeholder="Marque" value="{{ old('marque') }}">
                                        <label for="brand" class="text-muted"><i class="bi bi-building me-2"></i>Marque / Constructeur</label>
                                    </div>
                                </div>

                                {{-- Modèle en plein largeur --}}
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="modele" class="form-control border-0 bg-light rounded-4 @error('modele') is-invalid @enderror" id="model" placeholder="Modèle" value="{{ old('modele') }}">
                                        <label for="model" class="text-muted"><i class="bi bi-info-circle me-2"></i>Modèle précis / Version</label>
                                    </div>
                                </div>

                                {{-- Numéro de série avec look "Industriel" --}}
                                <div class="col-12">
                                    <div class="p-3 border rounded-4 mb-3 d-flex align-items-center bg-white shadow-sm">
                                        <div class="bg-dark text-white rounded-3 p-2 me-3">
                                            <i class="bi bi-qr-code-scan fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="small fw-bold text-uppercase text-muted" style="font-size: 0.65rem;">Serial Number (S/N)</label>
                                            <input type="text" name="numero_serie" class="form-control border-0 p-0 fw-bold @error('numero_serie') is-invalid @enderror" placeholder="Entrez le code ici..." value="{{ old('numero_serie') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- Date et État --}}
                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted mb-2 ms-2">Date d'arrivée</label>
                                    <input type="date" name="date_acquisition" class="form-control border-0 bg-light rounded-4 p-3 @error('date_acquisition') is-invalid @enderror" value="{{ old('date_acquisition', date('Y-m-d')) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="small fw-bold text-muted mb-2 ms-2">Statut Initial</label>
                                    <div class="d-flex gap-2">
                                        <input type="radio" class="btn-check" name="etat" id="op" value="Operationnel" autocomplete="off" checked>
                                        <label class="btn btn-outline-success border-0 bg-light rounded-4 w-100 p-3 fw-bold" for="op">OPERATIONNEL</label>

                                        <input type="radio" class="btn-check" name="etat" id="ind" value="Indisponible" autocomplete="off">
                                        <label class="btn btn-outline-danger border-0 bg-light rounded-4 w-100 p-3 fw-bold" for="ind">INDISPONIBLE</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-black rounded-4 shadow-lg overflow-hidden position-relative btn-save">
                                    <span class="position-relative z-1">FINALISER L'ENREGISTREMENT</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    body { background-color: #f4f7fe; font-family: 'Inter', sans-serif; }
    .fw-black { font-weight: 900; }
    
    /* Animation du bouton */
    .btn-save {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        letter-spacing: 1px;
    }
    
    .btn-save:hover {
        transform: scale(1.02);
        filter: brightness(1.1);
    }

    /* Floating labels custom */
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #4e73df !important;
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    }

    /* Radio buttons custom */
    .btn-check:checked + .btn-outline-success { background-color: #d1e7dd !important; color: #0f5132 !important; box-shadow: inset 0 0 0 2px #198754; }
    .btn-check:checked + .btn-outline-danger { background-color: #f8d7da !important; color: #842029 !important; box-shadow: inset 0 0 0 2px #dc3545; }
    
    .card { transition: transform 0.3s ease; }
    
    @media (max-width: 768px) {
        .display-1 { font-size: 3rem; }
    }
</style>
@endsection