@extends('layouts.app')


@section('content')@foreach (collect($totals)->chunk(6) as $row)
    <div class="row mb-3">
        @foreach ($row as $typeDon => $data)
            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card shadow-sm">
                    <!-- Header avec fond coloré et icône -->
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="h6 mb-0">{{ $typeDon }}</span>
                            <i class="mdi mdi-cash mdi-24px"></i>
                        </div>
                    </div>
                    <!-- Footer affichant les totaux -->
                    <div class="card-footer bg-light">
                        <div class="row text-center">
                            <div class="col-6 border-right">
                                <small class="d-block text-muted">Total Montant</small>
                                <span class="font-weight-bold text-success">
                                    {{ number_format($data['total_montant'], 2, ',', ' ') }}
                                </span>
                            </div>
                            <div class="col-6">
                                <small class="d-block text-muted">Reste Quantité</small>
                                <span class="font-weight-bold text-warning">
                                    {{ number_format($data['quantite_restante'], 2, ',', ' ') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach



<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Listes des Projets</h4>
                    <!-- Bouton Modal pour ajouter un don -->
                    <!-- Bouton pour afficher la modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createDonModal">
                        Ajouter un Don
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="createDonModal" tabindex="-1" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Ajouter un Don</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Barre de progression -->
                                    <div class="step-container d-flex justify-content-between mb-4">
                                        <div class="step-circle" id="step1">1</div>
                                        <div class="step-circle" id="step2">2</div>
                                        <div class="step-circle" id="step3">3</div>
                                    </div>

                                    <div class="progress mb-3">
                                        <div class="progress-bar" role="progressbar" style="width: 33%;"
                                            id="progressBar"></div>
                                    </div>
                                    <!-- Formulaire multi-étapes -->
                                    <form action="{{ route('dons.save') }}" id="donForm" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="budger_id" value="{{ $budget['id'] }}">
                                        <!-- Étape 1 -->
                                        <div class="step step-1">
                                            <h5>Informations Sur le Donnateur</h5>
                                            <div class="mb-3">
                                                <label for="personnes" class="form-label">Nom:</label>
                                                <input type="text" class="form-control" id="personnes"
                                                    name="personnes">
                                            </div>
                                            <div class="mb-3">
                                                <label for="telephone" class="form-label">Téléphone:</label>
                                                <input type="text" class="form-control" id="telephone"
                                                    name="telephone">
                                            </div>
                                            <button type="button" class="btn btn-primary next-step">Suivant</button>
                                        </div>

                                        <!-- Étape 2 -->
                                        <div class="step step-2 d-none">
                                            <h5>Détails du Don</h5>
                                            <div class="mb-3">
                                                <label for="type_don" class="form-label">Type de Don:</label>
                                                <select id="typeDonSelect" name="type_don" class="form-control">
                                                    <option value="" selected disabled>Choisissez un type de don
                                                    </option>
                                                    @foreach ($typeConversion as $typeDons)
                                                        <option value="{{ $typeDons['id'] }}"
                                                            data-choix="{{ $typeDons['choix'] }}"
                                                            data-quantite="{{ $typeDons['quantite'] }}"
                                                            data-valeur="{{ $typeDons['valeur_unitaire'] }}">
                                                            {{ $typeDons['type_don'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <!-- Choix du type de don (Caché par défaut) -->
                                            <div id="choixContainer" style="display:none;">
                                                @foreach ($choixDons as $choix)
                                                    <div class="form-check form-check-primary">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" disabled name="choix"
                                                                value="{{ $choix['choix'] }}"
                                                                class="form-check-input choixMateriel"
                                                                data-choix="{{ $choix['choix'] }}">
                                                            {{ $choix['choix'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- Champ Quantité (Caché par défaut) -->
                                            <div id="quantiteContainer" class="mb-3" style="display:none;">
                                                <label for="quantite" class="form-label">Quantité:</label>
                                                <input type="number" class="form-control" id="quantite"
                                                    name="quantite">
                                            </div>
                                            <!-- Champ Argent (Caché par défaut) -->
                                            <div id="moneyContainer" class="mb-3" style="display:none;">
                                                <label for="montant" class="form-label">Montant (Ar):</label>
                                                <input type="number" class="form-control" id="montant"
                                                    name="montant" step="0.01">
                                            </div>


                                            <button type="button"
                                                class="btn btn-secondary prev-step">Précédent</button>
                                            <button type="button" class="btn btn-primary next-step">Suivant</button>
                                        </div>

                                        <!-- Étape 3 -->
                                        <div class="step step-3 d-none">
                                            <h5>Confirmation</h5>
                                            <p>Veuillez vérifier les informations avant de soumettre.</p>
                                            <button type="button"
                                                class="btn btn-secondary prev-step">Précédent</button>
                                            <button type="submit" class="btn btn-success">Soumettre</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Donnateur</th>
                                <th>Type Don</th>
                                <th>Choix</th>
                                <th>Quantité</th>
                                <th>Montant</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($dons) && count($dons) > 0)
                                @foreach ($dons as $don)
                                    <tr class="ligne table-row-hover" data-bs-toggle="modal"
                                        data-bs-target="#budgetModal{{ $loop->index }}">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $don['personnes'] }}</td>
                                        <td>{{ $don['type_don'] }}</td>
                                        <td>{{ $don['choix'] }}</td>
                                        <td>{{ $don['quantite'] }}</td>
                                        <td>{{ $don['montant'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($don['date_don'])->locale('fr')->isoFormat('DD MMMM YYYY') }}
                                        </td>


                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

</div>
@endsection
