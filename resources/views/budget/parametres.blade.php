@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('budget'))
                <div class="alert alert-info">
                    <strong>Nom du projet :</strong> {{ session('budget')->nom_projet }}<br>
                    <strong>Montant Total :</strong> {{ session('budget')->montant_total }}
                </div>
            @endif
        </div>
        <div class="col-lg-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Listes des Projets</h4>
                    <div class="table-responsive">
                        <table id="" class="table table-bordered table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2">Nom</th>
                                    <th colspan="2">BUDGET</th>
                                    <th colspan="3">DONS</th>
                                    <th rowspan="2">STATUS</th>
                                    <th rowspan="2">ACTION</th>
                                </tr>
                                <tr>
                                    <th>Nom</th>
                                    <th>Somme</th>
                                    <th>Nom</th>
                                    <th>Quantité</th>
                                    <th>Somme</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($budget) && count($budget) > 0)
                                    @foreach ($budget as $budge)
                                        @php
                                            $conversions = $budge['conversions'];
                                        @endphp
                                        <tr class="ligne table-row-hover">
                                            <td>{{ $budge['nom_projet'] }}</td>
                                            <td colspan="2">
                                                <table class="table">
                                                    <tr>
                                                        <td><strong>Montant Total</strong></td>
                                                        <td>{{ number_format($budge['montant_total'], 2, '.', ',') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Montant Collecté</strong></td>
                                                        <td>{{ number_format($budge['montant_collecte'], 2, '.', ',') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Reste à Collecter</strong></td>
                                                        <td>{{ number_format($budge['reste_a_collecter'], 2, '.', ',') }}</td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <!-- Affichage des dons dans des colonnes distinctes -->
                                            <td colspan="3">
                                                <table class="table table-sm">
                                                    @foreach ($conversions as $dons)
                                                        <tr>
                                                            <td>{{ $dons['type_don'] }}</td>
                                                            <td>{{ $dons['quantite'] }}</td>
                                                            <td>{{ number_format($dons['montant_total'], 2, '.', ',') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-opacity-10 bg-{{ strtolower($budge['actif']) === 'actif' ? 'success' : 'danger' }} text-{{ strtolower($budge['actif']) === 'actif' ? 'success' : 'danger' }} d-inline-flex align-items-center py-2 px-3">
                                                    <span
                                                        class="bullet bullet-{{ strtolower($budge['actif']) === 'actif' ? 'success' : 'danger' }} bullet-sm me-2"></span>
                                                    {{ $budge['actif'] }}
                                                </span>
                                            </td>
                                            <td style="width: 20%">
                                                <div class="template-demo">
                                                    <button type="button" class="btn btn-outline-warning btn-fw"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateBudgetModal{{ $loop->index }}">Mettre à
                                                        jour</button>
                                                    <button type="button" class="btn btn-outline-primary btn-fw"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#budgetModal{{ $loop->index }}">Ajouter Type
                                                        Dons</button>

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>


                        <!-- ✅ Placer les modales en dehors de la boucle -->
                        @if (isset($budget) && count($budget) > 0)
                            @foreach ($budget as $budge)
                                <div class="modal fade" id="budgetModal{{ $loop->index }}" tabindex="-1"
                                    aria-labelledby="modalLabel{{ $loop->index }}" aria-hidden="true"
                                    data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $loop->index }}">
                                                    Enregistrer les dons de : {{ $budge['nom_projet'] }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Fermer"></button>
                                            </div>

                                            <form action="{{ route('dons.store') }}" method="POST" class="modal-body">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="budget_id" value="{{ $budge['id'] }}">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="type_don" class="form-label">Type de Don</label>
                                                            <input type="text" class="form-control" id="type_don"
                                                                name="type_don" placeholder="Type de don" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="valeur_unitaire{{ $loop->index }}"
                                                                class="form-label">Valeur
                                                                Unitaire</label>
                                                            <input type="text" class="form-control"
                                                                id="valeur_unitaire{{ $loop->index }}"
                                                                name="valeur_unitaire"
                                                                value="{{ number_format(0, 2, '.', ',') }}" required>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="quantite" class="form-label">Quantité</label>
                                                            <input type="number" class="form-control" id="quantite"
                                                                value="0" name="quantite" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="choix">Type de Don</label>
                                                            <select id="choix" name="choix" class="custom-select">
                                                                <option value="Matériel">Matériel</option>
                                                                <option value="Argent">Argent</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="updateBudgetModal{{ $loop->index }}" tabindex="-1"
                                    aria-labelledby="modalLabel{{ $loop->index }}" aria-hidden="true"
                                    data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $loop->index }}">
                                                    Mettre à jour le Budgete : {{ $budge['nom_projet'] }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Fermer"></button>
                                            </div>

                                            <form action="{{ route('update.budget') }}" method="POST"
                                                class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="budget_id" value="{{ $budge['id'] }}">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="nom_projet" class="form-label">Nom du
                                                                projet</label>
                                                            <input type="text" class="form-control" id="nom_projet"
                                                                name="nom_projet" value="{{ $budge['nom_projet'] }}"
                                                                required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="montant_total{{ $loop->index }}"
                                                                class="form-label">Budget
                                                                )
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                id="montant_total{{ $loop->index }}"
                                                                value="{{ number_format($budge['montant_total'], 2, '.', ',') }}"
                                                                name="montant_total" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <p class="mb-2">Activer</p>
                                                            <label class="toggle-switch toggle-switch-success">
                                                                <input type="checkbox"
                                                                    {{ strtolower($budge['actif']) === 'actif' ? 'checked' : '' }}
                                                                    name="activer">
                                                                <span class="toggle-slider round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 grid-margin stretch-card fixed-right">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Enregistrer Nouveaux Projets</h4>
                    <form action="{{ route('budgets.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-12">
                                <label>Nom</label>
                                <div id="the-basics">
                                    <input class="typeahead" type="text" name="nom_projet" placeholder="Ezaka Trano" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label>Budget )</label>
                                <div id="bloodhound">
                                    <input class="typeahead" id="montant_budget" type="text" name="montant_total" placeholder="0.00" value="{{ number_format(0, 2, '.', ',') }}" required>
                                </div>
                            </div>
                        </div>
                        <!-- Action pour annuler : Redirige l'utilisateur vers la liste des projets -->
                        <a href="{{ route('budgets.index') }}" class="btn btn-light">Annuler</a>
                        <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
@endsection
