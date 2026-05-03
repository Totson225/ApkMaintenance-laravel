@extends('layouts.app')

@section('title', 'AppliMaintenance | Piece')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
            
            {{-- Navigation & Titre --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">
                        <i class="bi bi-pencil-square text-primary me-2"></i> Modification de la Pièce
                    </h4>
                    <p class="text-muted small mb-0">Mise à jour des informations pour : <strong>{{ $piece->Nom }}</strong></p>
                </div>
                <a href="{{ route('pieces.index') }}" class="btn btn-light rounded-pill shadow-sm px-3">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    {{-- Note: Action vers 'update' avec l'ID et directive @method('PUT') --}}
                    <form action="{{ route('pieces.update', $piece) }}" method="post" id="pieceForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            {{-- Section : Identification --}}
                            <div class="col-12">
                                <div class="border-start border-primary border-4 ps-3 mb-3">
                                    <span class="fw-bold text-uppercase small text-primary">Identification</span>
                                </div>
                            </div>

                            {{-- Nom --}}
                            <div class="col-md-6">
                                <label for="Nom" class="form-label fw-semibold small text-secondary">DÉSIGNATION</label>
                                <div class="input-group border rounded-3 overflow-hidden transition-focus">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-cpu text-primary"></i></span>
                                    <input type="text" name="Nom" id="Nom" placeholder="ex: Disque Dur SSD 1To" 
                                        value="{{ old('Nom', $piece->Nom) }}" 
                                        class="form-control border-0 bg-white @error('Nom') is-invalid @enderror">
                                </div>
                                @error('Nom')
                                    <div class="invalid-feedback d-block mt-1"><i class="bi bi-exclamation-circle me-1"></i> Le nom est requis</div>
                                @enderror
                            </div>

                            {{-- Marque --}}
                            <div class="col-md-6">
                                <label for="Marque" class="form-label fw-semibold small text-secondary">MARQUE / CONSTRUCTEUR</label>
                                <div class="input-group border rounded-3 overflow-hidden transition-focus">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-patch-check text-primary"></i></span>
                                    <input type="text" name="Marque" id="Marque" placeholder="ex: Samsung, Crucial..." 
                                        value="{{ old('Marque', $piece->Marque) }}" 
                                        class="form-control border-0 bg-white @error('Marque') is-invalid @enderror">
                                </div>
                                @error('Marque')
                                    <div class="invalid-feedback d-block mt-1"><i class="bi bi-exclamation-circle me-1"></i> Précisez la marque</div>
                                @enderror
                            </div>

                            {{-- Section : Logistique --}}
                            <div class="col-12 mt-5">
                                <div class="border-start border-success border-4 ps-3 mb-3">
                                    <span class="fw-bold text-uppercase small text-success">Prix & Stock</span>
                                </div>
                            </div>

                            {{-- PRIX --}}
                            <div class="col-md-6">
                                <label for="Prix" class="form-label fw-semibold small text-secondary">PRIX UNITAIRE (FCFA)</label>
                                <div class="input-group border rounded-3 overflow-hidden transition-focus">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-cash-stack text-success"></i></span>
                                    <input type="number" step="50" name="Prix" id="Prix" placeholder="0.00" 
                                        value="{{ old('Prix', $piece->Prix) }}" 
                                        class="form-control border-0 bg-white @error('Prix') is-invalid @enderror">
                                    <span class="input-group-text bg-light border-0 fw-bold small text-muted">FCFA</span>
                                </div>
                                @error('Prix')
                                    <div class="invalid-feedback d-block mt-1"><i class="bi bi-exclamation-circle me-1"></i> Prix invalide</div>
                                @enderror
                            </div>

                            {{-- Stock --}}
                            <div class="col-md-6">
                                <label for="Stock" class="form-label fw-semibold small text-secondary">UNITÉS DISPONIBLES</label>
                                <div class="input-group border rounded-3 overflow-hidden transition-focus">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-archive text-success"></i></span>
                                    <input type="number" name="Stock" id="Stock" placeholder="Quantité" 
                                        value="{{ old('Stock', $piece->Stock) }}" 
                                        class="form-control border-0 bg-white @error('Stock') is-invalid @enderror">
                                </div>
                                @error('Stock')
                                    <div class="invalid-feedback d-block mt-1"><i class="bi bi-exclamation-circle me-1"></i> Indiquez le stock</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-5">
                            <button class="btn btn-primary w-100 btn-lg shadow fw-bold rounded-3 py-3 btn-submit" type="submit">
                                <i class="bi bi-arrow-repeat me-2"></i> Mettre à jour les informations
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    <i class="bi bi-clock-history me-1"></i> Dernière modification : {{ $piece->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Identique au create pour l'harmonie visuelle */
    .transition-focus {
        transition: all 0.3s ease-in-out;
    }
    .transition-focus:focus-within {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        transform: translateY(-2px);
    }
    
    .btn-submit {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-submit:hover {
        transform: scale(1.02);
        letter-spacing: 0.5px;
    }

    .form-control:focus {
        box-shadow: none;
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .invalid-feedback {
        font-size: 0.75rem;
        font-weight: 500;
    }
</style>
@endsection