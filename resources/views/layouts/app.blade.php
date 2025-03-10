<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tokin</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>
<style>
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
    <script src="{{ asset('assets/vendors/base/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js') }}"></script>
    <script src="{{ asset('assets/vendors/justgage/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/justgage/justgage.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>



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


</body>

</html>
