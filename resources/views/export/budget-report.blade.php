<!DOCTYPE html>
<html>
<head>
    <title>Rapport Budget</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 10px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 10px;
            border-radius: 8px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th {
            background: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            background: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .text-success {
            color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }

        .row.mb3 {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .row.mb3 .row.mb-3 {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .col-lg-3, .col-md-4, .col-sm-6 {
            flex: 1 1 calc(25% - 15px);
            max-width: calc(25% - 15px);
        }

        @media (max-width: 992px) {
            .col-lg-3 {
                flex: 1 1 calc(33.333% - 15px);
                max-width: calc(33.333% - 15px);
            }
        }

        @media (max-width: 768px) {
            .col-md-4 {
                flex: 1 1 calc(50% - 15px);
                max-width: calc(50% - 15px);
            }
        }

        @media (max-width: 576px) {
            .col-sm-6 {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }

        /* Nouvelle page avant chaque section */
        h3.mt-4 {
            page-break-before: always;
        }
        .card {
            page-break-before: always;
        }
        h2 {
            margin: 50% 25%;
            text-align: center; /* Centre le titre */
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Rapport Budget - {{ $budget['nom_projet'] }}</h2>

        <!-- Section des Statistiques Globales -->
        <div class="card">
            <div class="card-header">Statistiques Globales</div>
            <div class="card-body">
                <p>Montant Total: {{ number_format($budget['montant_total'], 0, ',', ' ') }} Ar</p>
                <p>Montant Collecté: {{ number_format($budget['montant_collecte'], 0, ',', ' ') }} Ar</p>
                <p>Reste à Collecter: {{ number_format($budget['reste_a_collecter'], 0, ',', ' ') }} Ar</p>
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
                                <td>{{ $don['valeur_unitaire'] }} Ar</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table des Types de Don -->
        <div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Type de Don</th>
                        <th>Total Montant</th>
                        <th>Reste Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (collect($totals)->chunk(4) as $row)
                        @foreach ($row as $typeDon => $data)
                            <tr>
                                <td>{{ $typeDon }}</td>
                                <td class="text-success">
                                    {{ number_format($data['total_montant'], 2, ',', ' ') }}
                                </td>
                                <td class="text-warning">
                                    {{ number_format($data['quantite_restante'], 2, ',', ' ') }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section des Détails des Contributions -->
        <h3 class="mt-4">Détails des Contributions</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Donateur</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dons as $don)
                    <tr>
                        <td>{{ $don['personnes'] }}</td>
                        <td>{{ $don['type_don'] }}</td>
                        <td>{{ number_format($don['montant'], 0, ',', ' ') }} Ar</td>
                        <td>{{ \Carbon\Carbon::parse($don['date_don'])->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
