@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- En-tête --}}
            <div class="d-flex align-items-center mb-4">
                <h4 class="mb-0 fw-bold text-primary">Enregistrer une pièce</h4>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('pieces.store') }}" method="post">
                        @csrf
                        
                        <div class="row">
                            {{-- Nom --}}
                            <div class="col-md-6 mb-3">
                                <label for="Nom" class="form-label fw-bold small text-muted">DÉSIGNATION / NOM</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-cpu"></i></span> {{-- Icône Composant --}}
                                    <input type="text" name="Nom" id="Nom" placeholder="Disque Dur SSD 1To" 
                                        value="{{ old('Nom') }}" 
                                        class="form-control bg-light border-start-0 @error('Nom') is-invalid @enderror">
                                </div>
                                @error('Nom')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer un Nom</div>
                                @enderror
                            </div>

                            {{-- Marque --}}
                            <div class="col-md-6 mb-3">
                                <label for="Marque" class="form-label fw-bold small text-muted">MARQUE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag"></i></span>
                                    <input type="text" name="Marque" id="Marque" placeholder="Crucial" 
                                        value="{{ old('Marque') }}" 
                                        class="form-control bg-light border-start-0 @error('Marque') is-invalid @enderror">
                                </div>
                                @error('Marque')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer la marque</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- PRIX --}}
                            <div class="col-md-6 mb-3">
                                <label for="Prix" class="form-label fw-bold small text-muted">PRIX UNITAIRE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-currency-exchange"></i></span>
                                    <input type="number" step="50" name="Prix" id="Prix" placeholder="1300" 
                                        value="{{ old('Prix') }}" 
                                        class="form-control bg-light border-start-0 border-end-0 @error('Prix') is-invalid @enderror">
                                    <span class="input-group-text bg-light border-start-0 text-muted small ">FCFA</span>
                                </div>
                                @error('Prix')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer le prix</div>
                                @enderror
                            </div>

                            {{-- Stock --}}
                            <div class="col-md-6 mb-3">
                                <label for="Stock" class="form-label fw-bold small text-muted">QUANTITÉ EN STOCK</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-layers"></i></span>
                                    <input type="number" name="Stock" id="Stock" placeholder="6" 
                                        value="{{ old('Stock') }}" 
                                        class="form-control bg-light border-start-0 @error('Stock') is-invalid @enderror">
                                </div>
                                @error('Stock')
                                    <div class="text-danger small mt-1">!!! Veuillez entrer la quantité</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Intervention associée --}}
                        <div class="mb-4">
                            <label for="id_Intervtion" class="form-label fw-bold small text-muted">INTERVENTION ASSOCIÉE</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-wrench-adjustable"></i></span>
                                <select name="id_Intervtion" id="id_Intervtion" class="form-select bg-light border-start-0 @error('id_Intervtion') is-invalid @enderror">
                                    <option selected disabled value="">-- Sélectionner une intervention --</option>
                                    @foreach($interventions as $intervention)
                                        <option value="{{ $intervention->id_Intervtion }}" {{ old('id_Intervtion') == $intervention->id_Intervtion ? 'selected' : '' }}>
                                            Intervention n°{{ $intervention->id_Intervtion }} - {{ \Carbon\Carbon::parse($intervention->date_intervention)->format('d/m/Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_Intervtion')
                                <div class="text-danger small mt-1">!!! Veuillez associer une intervention</div>
                            @enderror
                        </div>

                        <div class="d-grid shadow-sm">
                            <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                <i class="bi bi-plus-circle me-2"></i>Enregistrer la pièce
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection