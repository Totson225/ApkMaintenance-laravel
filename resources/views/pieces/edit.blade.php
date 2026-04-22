
@extends('layouts.app')

@section('content')


        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="mb-0 fw-bold text-primary">Enregistrer une piece</h4>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <form action="{{ route('pieces.update', $piece->id_PRechange) }}" method="post">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">

                                <div class="row">
                                    {{-- Nom --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="Nom" class="form-label fw-bold small text-muted">Nom</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                            <input type="text" name="Nom" id="Nom" placeholder="Disque Dur SSD 1To" 
                                                value="{{ old('Nom', $piece->Nom) }}" 
                                                class="form-control bg-light border-start-0 @error('Nom') is-invalid @enderror">
                                        </div>
                                        @error('Nom')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer un Nom' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Marque --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="Marque" class="form-label fw-bold small text-muted">Marque</label>
                                        <input type="text" name="Marque" id="Marque" placeholder="Crucial" 
                                            value="{{ old('Marque', $piece->Marque) }}"
                                             class="form-control bg-light border-start-0">
                                    </div>
                                </div>

                                    {{-- PRIX --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="Prix" class="form-label fw-bold small text-muted">PRIX</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="Prix" id="Prix" placeholder="1300F" 
                                                value="{{ old('Prix', $piece->Prix) }}" 
                                                class="form-control bg-light border-start-0 @error('Prix') is-invalid @enderror">
                                        </div>
                                        @error('Prix')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer le prix' }}</div>
                                        @enderror
                                    </div>

                                    {{-- Stock --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="Stock" class="form-label fw-bold small text-muted">STOCK</label>
                                        <input type="text" name="Stock" id="Stock" placeholder="6" 
                                            value="{{ old('Stock', $piece->Stock) }}" 
                                            class="form-control bg-light @error('Stock') is-invalid @enderror">
                                        @error('Stock')
                                            <div class="text-danger small mt-1">{{ '!!!Veillez entrer la marque' }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">

                                <div class="mb-3">
                                    <label class="form-label">Intervention associée</label>
                                    <select name="id_Intervtion" class="form-select">
                                        <option value="">-- Sélectionner une intervention --</option>
                                        @foreach($interventions as $intervention)
                                            <option value="{{ $intervention->id_Intervtion }}" 
                                                {{ (old('id_Intervtion', $piece->id_Intervtion ?? '') == $intervention->id_Intervtion) ? 'selected' : '' }}>
                                                
                                                Intervention n°{{ $intervention->id_Intervtion }} du {{ $intervention->date_intervention }} 
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-grid shadow-sm">
                                    <button class="btn btn-primary btn-lg fw-bold" id="enregistrer" type="submit">
                                        <i class="bi bi-pencil-fill me-2"></i>Modifier la piece
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

