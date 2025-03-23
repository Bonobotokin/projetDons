@extends('layouts.app')


@section('content')
    <div class="row mb-3">
        <div class="col-lg-4">
            <select id="changeView" class="">
                <option value="liste">Liste</option>
                <option value="rapport">Rapport</option>
            </select>
        </div>
        {{-- Dans la section du sélecteur de vue --}}
        <div class="col-lg-4">
            {{-- Ajoutez ce formulaire dans votre section content --}}
            <form action="{{ route('export.pdf') }}" method="POST" id="pdfForm">
                @csrf
                <input type="hidden" name="budget_data" value="{{ json_encode($budget) }}">
                <input type="hidden" name="conversion_data" value="{{ json_encode($typeConversion) }}">
                <input type="hidden" name="totals_data" value="{{ json_encode($totals) }}">
                <input type="hidden" name="dons_data" value="{{ json_encode($dons) }}">

                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="fas fa-file-pdf me-2"></i> Exporter en PDF
                </button>
            </form>
        </div>
    </div>

    <div class="row mb-3" id="rapportView"style="display:none">
        <!-- Colonne unique de 4 qui reste fixe -->
        <div class="col-lg-4 col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <span class="h6 mb-0">Rapport Budget</span>
                </div>
                <div class="card-body">
                    <p class="d-flex justify-content-between">
                        <span>Montant Atteindre :</span>
                        <span>{{ number_format($budget['montant_total'], 2, ',', ' ') }} MGA</span>
                    </p>
                    <p class="d-flex justify-content-between">
                        <span>Montant Collecté :</span>
                        <span>{{ number_format($budget['montant_collecte'], 2, ',', ' ') }} MGA</span>
                    </p>
                    <p class="d-flex justify-content-between">
                        <span>Montant Reste A Collecter :</span>
                        <span>{{ number_format($budget['reste_a_collecter'], 2, ',', ' ') }} MGA</span>
                    </p>
                    {{-- <p class="d-flex justify-content-between">
                        <span>Statut du Projet :</span> 
                        <span class="{{ $budget['actif'] === 'Actif' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold' }}">
                            {{ $budget["actif"] }}
                        </span>
                    </p> --}}

                    <table class="table">
                        <thead style="background-color: blue; color: white">
                            <tr>
                                <th>Nom</th>
                                <th>Quantite</th>
                                <th>Valeur Unitaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($typeConversion as $don)
                                <tr>
                                    <td>{{ $don['type_don'] }}</td>
                                    <td>{{ $don['quantite'] }}</td>

                                    <td>{{ number_format($don['valeur_unitaire'], 2, '.', ',') }} MGA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

        <!-- Boucle des cartes -->
        <div class="col-lg-8">
            @foreach (collect($totals)->chunk(4) as $row)
                <div class="row mb-3">
                    @foreach ($row as $typeDon => $data)
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
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
        </div>
    </div>

    <div class="row" id="listeView">
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
                            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                                        <form action="{{ route('dons.save') }}" id="donForm" method="POST"
                                            class="p-4 shadow-lg rounded">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="budger_id" value="{{ $budget['id'] }}">

                                            <!-- Étape 1 -->
                                            <div class="step step-1">
                                                <h4 class="text-primary mb-3">🧑‍🤝‍🧑 Informations sur le Donateur</h4>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label for="personnes" class="form-label">Nom :</label>
                                                        <input type="text" class="form-control" id="personnes"
                                                            name="personnes" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="telephone" class="form-label">Téléphone :</label>
                                                        <input type="text" class="form-control" id="telephone"
                                                            name="telephone" required>
                                                    </div>
                                                </div>
                                                <div class="text-end mt-3">
                                                    <button type="button" class="btn btn-primary next-step">Suivant
                                                        →</button>
                                                </div>
                                            </div>

                                            <!-- Étape 2 -->
                                            <div class="step step-2 d-none">
                                                <h4 class="text-primary mb-3">🎁 Détails du Don</h4>
                                                <div class="mb-3">
                                                    <label for="typeDonSelect" class="form-label">Type de Don :</label>
                                                    <select id="typeDonSelect" name="type_don" class="form-select">
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

                                                <div id="choixContainer" class="mb-3" style="display:none;">
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
                                                    <label for="montant" class="form-label">Montant (MGA):</label>
                                                    <input type="number" class="form-control" id="montant"
                                                        name="montant" step="0.01">
                                                </div>

                                                <!-- Navigation -->
                                                <div class="d-flex justify-content-between mt-4">
                                                    <button type="button" class="btn btn-secondary prev-step">←
                                                        Précédent</button>
                                                    <button type="button" class="btn btn-primary next-step">Suivant
                                                        →</button>
                                                </div>
                                            </div>

                                            <!-- Étape 3 -->
                                            <div class="step step-3 d-none">
                                                <h4 class="text-primary mb-3">✅ Confirmation</h4>
                                                <p>Veuillez vérifier les informations avant de soumettre.</p>
                                                <div class="d-flex justify-content-between mt-4">
                                                    <button type="button" class="btn btn-secondary prev-step">←
                                                        Précédent</button>
                                                    <button type="submit" class="btn btn-success">💾 Soumettre</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <!-- Table stylisée -->
                        <table id="donsTable" class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Donnateur</th>
                                    <th>Type Don</th>
                                    <th>Choix</th>
                                    <th>Quantité</th>
                                    <th>Montant MGA</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($dons) && count($dons) > 0)
                                @foreach ($dons as $don)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        <p>{{ $don['personnes'] }}</p>
                                        <p>{{ $don['telephone'] }}</p>
                                    </td>
                                    <td>{{ $don['type_don'] }}</td>
                                    <td>{{ $don['choix'] }}</td>
                                    <td>{{ $don['quantite'] }}</td>
                                    <td>{{ number_format($don['montant'], 2, ',', ' ') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($don['date_don'])->locale('fr')->isoFormat('DD MMMM YYYY') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('certification.pdf') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="personne" value="{{ json_encode($don['personnes'], JSON_HEX_QUOT) }}">
                                                <button type="submit" class="btn btn-info btn-sm">
                                                    <i class="fas fa-file-pdf me-1"></i> PDF
                                                </button>
                                            </form>
                                            
                                
                                            <!-- Bouton Modifier -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $loop->index }}">
                                                <i class="fas fa-edit me-1"></i> Modifier
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Modal de modification -->
                                <div class="modal fade" id="editModal{{ $loop->index }}" tabindex="-1" aria-labelledby="editModalLabel{{ $loop->index }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title" id="editModalLabel{{ $loop->index }}">Modifier le Don</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dons.update') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="budget_id" value="{{ $budgets[0]['id'] }}">
                                                    <input type="hidden" name="don_id" value="{{ $don['id'] }}">
                                
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Donnateur</label>
                                                            <input type="text" name="personnes" class="form-control" value="{{ $don['personnes'] }}" required>
                                                        </div>
                                
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Telephone</label>
                                                            <input type="text" name="telephone" class="form-control" value="{{ $don['telephone'] }}" required>
                                                        </div>
                                
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Type de Don</label>
                                                            <select id="typeDonSelect" name="type_don" class="form-select">
                                                                @if (isset($budgets) && count($budgets) > 0)
                                                                    @foreach ($budgets as $budge)
                                                                        @php
                                                                            $conversions = $budge['conversions'];
                                                                        @endphp
                                                                        @foreach ($conversions as $dons)
                                                                            <option value="{{ $dons['id'] }}"
                                                                                {{ $dons['type_don'] == $don['type_don'] ? 'selected' : '' }}
                                                                                data-choix="{{ $dons['choix'] }}"
                                                                                data-quantite="{{ $dons['quantite'] }}"
                                                                                data-valeur="{{ $dons['valeur_unitaire'] }}">
                                                                                {{ $dons['type_don'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Choix</label>
                                                            <select id="choix" name="choix" class="form-select">
                                                                <option value="Matériel" {{ $don['choix'] == 'Matériel' ? 'selected' : '' }}>Matériel</option>
                                                                <option value="Argent" {{ $don['choix'] == 'Argent' ? 'selected' : '' }}>Argent</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Quantité</label>
                                                            <input type="number" name="quantite" class="form-control" value="{{ $don['quantite'] }}" required id="quantite">
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Montant (MGA)</label>
                                                            <input type="text" class="form-control" id="montant" name="montant" value="{{ number_format($don['montant'], 2, '.', ',') }}" required>
                                                        </div>                                                                
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Date</label>
                                                            <input type="date" name="date_don" class="form-control" value="{{ \Carbon\Carbon::parse($don['date_don'])->format('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                                    </div>
                                                </form>
                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
