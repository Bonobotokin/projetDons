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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>BUDGET</th>
                                    <th>DONS</th>
                                    <th>STATUS</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($navigation) && count($navigation) > 0)
                                    @foreach ($navigation as $budge)
                                        @php
                                            $conversions = $budge['conversions'];
                                        @endphp
                                        <tr class="ligne table-row-hover" data-bs-toggle="modal"
                                            data-bs-target="#budgetModal{{ $loop->index }}">
                                            <td>{{ $budge['nom_projet'] }}</td>
                                            <td>
                                                <table class="table">
                                                    <tr>
                                                        <td><strong>Montant Total</strong></td>
                                                        <td>{{ $budge['montant_total'] }} Ar</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Montant Collecté</strong></td>
                                                        <td>{{ $budge['montant_collecte'] }} Ar</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Reste à Collecter</strong></td>
                                                        <td>{{ $budge['reste_a_collecter'] }} Ar</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            
                                            <td>
                                                <table class="table">
                                                    @foreach ($conversions as $dons)
                                                        <tr>
                                                            <td>{{ $dons['type_don'] }}</td>
                                                            <td>{{ $dons['quantite'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            
                                            <td>
                                                <span
                                                    class="badge {{ $budge['actif'] ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $budge['actif'] ? 'Actif' : 'Inactif' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>

                        <!-- ✅ Placer les modales en dehors de la boucle -->
                        @if (isset($navigation) && count($navigation) > 0)
                            @foreach ($navigation as $budge)
                                <div class="modal fade" id="budgetModal{{ $loop->index }}" tabindex="-1"
                                    aria-labelledby="modalLabel{{ $loop->index }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $loop->index }}">
                                                    Enregistrer les don de : {{ $budge['nom_projet'] }}
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
                                                            <label for="nom_projet" class="form-label">Nom du projet</label>
                                                            <input type="text" class="form-control" id="type_don" name="type_don" placeholder="Type de don" required>
                                                        </div>
                                                
                                                        <div class="mb-3">
                                                            <label for="montant_total" class="form-label">Valeur Unitaire</label>
                                                            <input type="number" class="form-control" id="valeur_unitaire" placeholder="0.00" name="valeur_unitaire" step="0.01" required>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="quantite" class="form-label">Quantité</label>
                                                            <input type="number" class="form-control" id="quantite" value="0" name="quantite" required>
                                                        </div>
                                                
                                                        <div class="form-group">
                                                            <label for="choix">Type de Don</label>
                                                            <select id="choix" name="choix" class="form-control">
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
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Enregistrer Nouveaux Projets</h4>
                    <form action="{{ route('budgets.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col">
                                <label>Nom</label>
                                <div id="the-basics">
                                    <input class="typeahead" type="text" name="nom_projet" placeholder="Ezaka Trano"
                                        required>
                                </div>
                            </div>
                            <div class="col">
                                <label>Budget (Ar)</label>
                                <div id="bloodhound">
                                    <input class="typeahead" type="number" name="montant_total" placeholder="0.00"
                                        required>
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
