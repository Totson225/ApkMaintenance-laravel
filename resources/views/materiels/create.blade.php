@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- En-tête --}}
            <div class="d-flex align-items-center mb-4">
                <h4 class="mb-0 fw-bold text-primary">Enregistrer un matériel</h4>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('materiels.store') }}" method="post">
                        @csrf
                        
                        <div class="row">
                            {{-- Type --}}
                            <div class="col-md-6 mb-3">
                                <label for="type_materiel" class="form-label fw-bold small text-muted">TYPE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-box-seam"></i></span>
                                    <input type="text" name="type_materiel" id="type_materiel" placeholder="Testeur de câble" 
                                        value="{{ old('type_materiel') }}" 
                                        class="form-control bg-light border-start-0 @error('type_materiel') is-invalid @enderror">
                                </div>
                                @error('type_materiel')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un type</div>
                                @enderror
                            </div>

                            {{-- Marque --}}
                            <div class="col-md-6 mb-3">
                                <label for="marque" class="form-label fw-bold small text-muted">MARQUE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-patch-check"></i></span> 
                                    <input type="text" name="marque" id="marque" placeholder="iFixit" 
                                        value="{{ old('marque') }}" 
                                        class="form-control bg-light border-start-0 @error('marque') is-invalid @enderror">
                                </div>
                                @error('marque')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer une marque</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Modele --}}
                            <div class="col-md-6 mb-3">
                                <label for="modele" class="form-label fw-bold small text-muted">MODÈLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash"></i></span> {{-- Icône Référence/Numéro --}}
                                    <input type="text" name="modele" id="modele" placeholder="Pro Tech Toolkit"
                                        value="{{ old('modele') }}" 
                                        class="form-control bg-light border-start-0 @error('modele') is-invalid @enderror">
                                </div>
                                @error('modele')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un modèle</div>
                                @enderror
                            </div>

                            {{-- Numero de serie --}}
                            <div class="col-md-6 mb-3">
                                <label for="numero_serie" class="form-label fw-bold small text-muted">NUMÉRO DE SÉRIE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-qr-code-scan"></i></span> {{-- Icône Scan/Série --}}
                                    <input type="text" name="numero_serie" id="numero_serie" placeholder="SN-12345..."
                                        value="{{ old('numero_serie') }}" 
                                        class="form-control bg-light border-start-0 @error('numero_serie') is-invalid @enderror">
                                </div>
                                @error('numero_serie')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un numéro de série</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Date Acquisition --}}
                            <div class="col-md-6 mb-3">
                                <label for="date_acquisition" class="form-label fw-bold small text-muted">DATE D'AQUISITION</label>
                                    <input type="date" name="date_acquisition" id="date_acquisition" 
                                        value="{{ old('date_acquisition', date('Y-m-d')) }}" 
                                        class="form-control bg-light border-start-0 @error('date_acquisition') is-invalid @enderror">
                                @error('date_acquisition')
                                    <div class="text-danger small mt-1">!!! Veuillez choisir une date</div>
                                @enderror
                            </div>

                            {{-- ETAT --}}
                            <div class="col-md-6 mb-3">
                                <label for="etat" class="form-label fw-bold small text-muted">ÉTAT</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-activity"></i></span> {{-- Icône État/Santé --}}
                                    <select class="form-select bg-light border-start-0 @error('etat') is-invalid @enderror" name="etat" id="etat">
                                        <option selected disabled value="">Choisir...</option>
                                        <option value="Operationnel" {{ old('etat') == 'Operationnel' ? 'selected' : '' }}>Opérationnel</option>
                                        <option value="Indisponible" {{ old('etat') == 'Indisponible' ? 'selected' : '' }}>Indisponible</option>  
                                    </select>
                                </div>
                                @error('etat')
                                    <div class="text-danger small mt-1">!!! Veuillez choisir l'état</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid shadow-sm mt-3">
                            <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                <i class="bi bi-tools me-2"></i>Enregistrer le matériel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection