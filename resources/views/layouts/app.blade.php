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

</body>

</html>
