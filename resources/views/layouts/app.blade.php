<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>G-DONS</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->

    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>
<style>
    .fixed-right {
        position: fixed;
        /* Ajustez selon l'endroit où vous voulez que la carte commence */
        right: 20px;
        width: 300px;
        /* Correspond à la largeur de col-lg-3 */
        z-index: 9999;
        /* Assurez-vous qu'il reste au-dessus du contenu */
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        /* Optionnel: ajoute un léger ombrage */
        padding: 10px;
        background-color: white;
        /* Optionnel: vous pouvez ajuster la couleur de fond */
    }

    /* Ajoutez un espacement suffisant au contenu pour qu'il n'aille pas derrière la carte fixe */
    body {
        padding-right: 320px;
        /* Ajustez selon la largeur de votre carte */
    }

    /* Sélecteur de type de don */
    .selectdiv select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        display: block;
        width: 100%;
        max-width: 320px;
        height: 50px;
        padding: 0px 24px;
        font-size: 16px;
        line-height: 1.75;
        color: #333;
        background-color: #ffffff;
        background-image: none;
        border: 1px solid #cccccc;
        border-radius: 5px;
        /* Coins arrondis */
        margin: 5px 0;
    }

    /* Cacher les flèches natives pour IE11 */
    select::-ms-expand {
        display: none;
    }

    /* Styles de la zone de navigation des étapes */
    .step-navigation {
        position: absolute;
        bottom: 20px;
        /* Positionne la zone en bas */
        left: 0;
        right: 0;
        padding: 15px 25px;
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Boutons de navigation */
    .step-navigation .btn {
        min-width: 120px;
        font-size: 16px;
    }

    /* Marges et paddings sur les containers */

    /* Style de base pour les inputs */
    input {
        border: 1px solid #cccccc;
        /* Bordure par défaut */
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
        width: 100%;
        max-width: 320px;
        transition: all 0.3s ease;
        /* Ajoute une transition fluide pour l'effet */
    }

    /* Effet lorsque l'input est survolé (hover) */
    input:hover {
        border-color: #5bc0de;
        /* Bordure bleu clair au survol */
        box-shadow: 0 0 5px rgba(91, 192, 222, 0.5);
        /* Ombre légère au survol */
    }

    /* Effet lorsque l'input est focus (lorsque l'utilisateur clique ou navigue dans l'input) */
    input:focus {
        border-color: #2e3437 !important;
        /* Bordure plus foncée lors du focus */
        box-shadow: 0 0 8px rgba(46, 52, 55, 0.5);
        /* Ombre accentuée lors du focus */
        outline: none;
        /* Enlève le contour par défaut du focus pour ne garder que la bordure */
    }

    /* Style pour les champs de texte */
    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="password"] {
        background-color: #f8f9fa;
        /* Fond gris clair pour un contraste doux */
    }

    /* Style pour le champ de sélection (select) avec des effets de focus et hover similaires */
    .selectdiv select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 5px;
        padding: 10px 20px;
        width: 100%;
        max-width: 320px;
        border: 1px solid #cccccc;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    /* Effet lorsque le select est survolé (hover) */
    .selectdiv select:hover {
        border-color: #5bc0de;
        box-shadow: 0 0 5px rgba(91, 192, 222, 0.5);
    }

    /* Effet lorsque le select est focus */
    .selectdiv select:focus {
        border-color: #2e3437 !important;
        box-shadow: 0 0 8px rgba(46, 52, 55, 0.5);
        outline: none;
    }

    #choixContainer,
    #quantiteContainer,
    #moneyContainer {
        margin-bottom: 1.5rem;
    }

    /* Apparaître en dessous du formulaire */
    .step {
        position: relative;
        padding-bottom: 80px;
        /* Ajout d'un padding pour laisser de l'espace aux boutons */
    }


    .select-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    select {
        font-size: 16px;
        padding: 12px 20px;
        border: 2px solid #5b4caf;
        border-radius: 5px;
        background-color: white;
        color: #333;
        cursor: pointer;
        width: 200px;
        transition: all 0.3s ease;
    }

    select:focus {
        outline: none;
        border-color: #5b4caf;
        box-shadow: 0 0 8px rgba(102, 83, 181, 0.5);
    }

    option {
        padding: 10px;
    }

    /* Style pour rendre le texte d'option plus lisible */
    option:hover {
        background-color: #f1f1f1;
    }

    .logo-text {
        font-size: 40px;
        font-weight: bold;
        color: #173767 !important;
        /* ou une autre couleur souhaitée */
    }

    /* Améliorer le design du tableau */
    .table-row-hover {
        cursor: pointer;
        /* Change le curseur en pointer */
        transition: background-color 0.3s ease;
        /* Ajouter une transition douce pour la couleur de fond */
    }

    /* Survol de la ligne */
    .table-row-hover:hover {
        background-color: #f1f1f1;
        /* Changer la couleur de fond lorsqu'on survole la ligne */
    }

    /* Optionnel : Ajouter une couleur de survol plus foncée pour une meilleure visibilité */
    .table-row-hover:hover {
        background-color: #e2e2e2;
    }

    .step-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #ddd;
        text-align: center;
        line-height: 30px;
        font-weight: bold;
        border: 2px solid #007bff;
    }

    .step-circle.active {
        background-color: #007bff;
        color: white;
    }

    .choixMateriel:disabled:checked {
        background-color: #28a745 !important;
        /* Couleur verte */
        border-color: #28a745 !important;
    }

    /* Pour les navigateurs qui n'appliquent pas le background-color sur les cases à cocher */
    .choixMateriel:disabled:checked+label {
        color: #28a745;
        /* Changer la couleur du texte */
        font-weight: bold;
    }
</style>


<body>
    <div class="container-scroller">

        <!-- partial:partials/_horizontal-navbar.html -->
        @include('layouts.partials._horizontal-navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">

                <div class="content-wrapper">
                    @yield('content')
                </div>


                @include('layouts.partials._footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>


    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}

    <script src="{{ asset('assets/vendors/base/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js') }}"></script>
    <script src="{{ asset('assets/vendors/justgage/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/justgage/justgage.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#donsTable', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/fr_fr.json'
                },
                columnDefs: [{
                        targets: [0],
                        orderData: [0, 1]
                    },
                    {
                        targets: [1],
                        orderData: [1, 0]
                    },
                    {
                        targets: [4],
                        orderData: [4, 0]
                    }
                ]
            });
        });
    </script>
    {{-- 
    <!-- Script pour la navigation entre les étapes et l'affichage conditionnel -->
    <script>
        // Passage de l'étape 1 à l'étape 2
        document.getElementById('next-step-1').addEventListener('click', function() {
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
        });

        // Retour de l'étape 2 à l'étape 1
        document.getElementById('previous-step-2').addEventListener('click', function() {
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-1').style.display = 'block';
        });

        // Affichage du bloc personnalisé si l'option "Autre" est sélectionnée
        document.getElementById('type_don_2').addEventListener('change', function() {
            if (this.value === 'other') {
                document.getElementById('custom-type-don').style.display = 'block';
            } else {
                document.getElementById('custom-type-don').style.display = 'none';
            }
        });
    </script> --}}

    <script>
        // Fonction pour ajouter des séparateurs de milliers
        function addThousandsSeparator(inputElement) {
            inputElement.addEventListener('keyup', function(e) {
                var value = e.target.value;

                // Supprimer tous les caractères non numériques sauf le point décimal
                value = value.replace(/[^0-9.]/g, '');

                // Limiter à un seul point décimal
                var parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }

                // Séparer la partie entière et la décimale
                var [integer, decimal] = value.split('.');

                // Ajouter des séparateurs de milliers à la partie entière
                integer = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // Si la partie décimale existe, la remettre
                if (decimal) {
                    value = integer + '.' + decimal;
                } else {
                    value = integer;
                }

                // Mettre à jour la valeur du champ input
                e.target.value = value;
            });
        }

        // Appliquer la fonction aux éléments souhaités
    </script>
    <script>
        // Fonction pour ajouter des séparateurs de milliers
        function addThousandsSeparators(inputElement) {
            inputElement.addEventListener('keyup', function(e) {
                var value = e.target.value;

                // Supprimer tous les caractères non numériques sauf le point décimal
                value = value.replace(/[^0-9.]/g, '');

                // Limiter à un seul point décimal
                var parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }

                // Séparer la partie entière et la décimale
                var [integer, decimal] = value.split('.');

                // Ajouter des séparateurs de milliers à la partie entière
                integer = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // Si la partie décimale existe, la remettre
                if (decimal) {
                    value = integer + '.' + decimal;
                } else {
                    value = integer;
                }

                // Mettre à jour la valeur du champ input
                e.target.value = value;
            });
        }

        // Appliquer la fonction à tous les champs `valeur_unitaire` au chargement de la page
        window.addEventListener('DOMContentLoaded', function() {
            // Sélectionner tous les champs `valeur_unitaire` avec un id dynamique
            var inputFields = document.querySelectorAll('[id^="valeur_unitaire"]');
            var inputTotal = document.querySelectorAll('[id^="montant_total"]');
            inputFields.forEach(function(input) {
                addThousandsSeparators(input);
            });
            inputTotal.forEach(function(input) {
                addThousandsSeparators(input);
            });
        });

        addThousandsSeparator(document.getElementById('montant_budget'));
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const radios = document.querySelectorAll('input[name="choix"]');
            const label = document.getElementById('label_valeur');
            const input = document.getElementById('valeur');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'quantite') {
                        label.textContent = "Quantité";
                        input.placeholder = "Entrez la quantité";
                    } else {
                        label.textContent = "Montant";
                        input.placeholder = "Entrez le montant";
                    }
                });
            });
        });
    </script>

    <script>
        document.getElementById('typeDonSelect').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];

            let data = {
                id: selectedOption.value,
                type_don: selectedOption.text,
                choix: selectedOption.getAttribute('data-choix'),
                quantite: selectedOption.getAttribute('data-quantite'),
                valeur_unitaire: selectedOption.getAttribute('data-valeur')
            };

            console.log('Données sélectionnées:', data.choix);

            // Rendre visible le conteneur des choix
            document.getElementById('choixContainer').style.display = 'block';

            // Masquer `quantiteContainer` et `moneyContainer` par défaut
            document.getElementById('quantiteContainer').style.display = 'none';
            document.getElementById('moneyContainer').style.display = 'none';

            // Désactiver toutes les cases et les décocher
            document.querySelectorAll('.choixMateriel').forEach(function(checkbox) {
                checkbox.checked = false;
                checkbox.disabled = true;
            });

            // Activer et cocher uniquement la case correspondant à `data.choix`
            document.querySelectorAll('.choixMateriel').forEach(function(checkbox) {
                if (checkbox.value === data.choix) {
                    checkbox.checked = true;
                    checkbox.disabled = false;
                }
            });

            // Afficher le champ Quantité si le choix est "Matériel"
            if (data.choix === "Matériel") {
                document.getElementById('quantiteContainer').style.display = 'block';
            }

            // Afficher le champ Montant si le choix est "Argent"
            if (data.choix === "Argent") {
                document.getElementById('moneyContainer').style.display = 'block';
            }
        });
    </script>

    <script>
        var myModal = new bootstrap.Modal(document.getElementById('createDonModal'), {
            backdrop: 'static',
            keyboard: false
        });

        let currentStep = 1;

        function updateProgressBar() {
            let progress = (currentStep - 1) * 50;
            document.getElementById('progressBar').style.width = progress + '%';

            document.querySelectorAll('.step-circle').forEach((circle, index) => {
                if (index + 1 === currentStep) {
                    circle.classList.add('active');
                } else {
                    circle.classList.remove('active');
                }
            });
        }

        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelector('.step-' + currentStep).classList.add('d-none');
                currentStep++;
                document.querySelector('.step-' + currentStep).classList.remove('d-none');
                updateProgressBar();
            });
        });

        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelector('.step-' + currentStep).classList.add('d-none');
                currentStep--;
                document.querySelector('.step-' + currentStep).classList.remove('d-none');
                updateProgressBar();
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let changeView = document.getElementById("changeView");
            let rapportView = document.getElementById("rapportView");
            let listeView = document.getElementById("listeView");

            // Assurez-vous que "rapportView" est bien masqué par défaut
            rapportView.style.display = "none";
            listeView.style.display = "flex"; // Si vous voulez afficher "liste" par défaut

            // Ajout de l'événement pour changer la vue
            changeView.addEventListener("change", function() {
                let selectedValue = this.value;

                rapportView.style.display = selectedValue === "rapport" ? "flex" : "none";
                listeView.style.display = selectedValue === "liste" ? "flex" : "none";
            });
        });
    </script>

</body>

</html>
