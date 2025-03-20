<div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <span class="logo-text text-dark">G-DONS</span>

                </div>
                {{-- <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <span class="nav-profile-name">Admin</span>
                            <span class="online-status"></span>
                            <img src="{{ asset('assets/images/faces/face28.png') }}" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="mdi mdi-settings text-primary"></i>
                                Parametre
                            </a>
                            <a class="dropdown-item">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="horizontal-menu-toggle">
                    <span class="mdi mdi-menu"></span>
                </button> --}}
            </div>
        </div>
    </nav>
    <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">

                @if (isset($navigation) && count($navigation) > 0)

                    @foreach ($navigation as $budge)
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('dons.pages', ['nom_projet' => $budge['nom_projet']]) }}">
                                <i class="mdi mdi-file-document-box menu-icon"></i>
                                <span class="menu-title">{{ $budge['nom_projet'] }}</span>
                            </a>
                        </li>
                    @endforeach
                @endif

                <li class="nav-item">
                    <a href="{{ route('parametres') }}" class="nav-link">
                        <i class="mdi mdi-settings"></i>
                        <span class="menu-title">Parametres</span>
                        <i class="menu-arrow"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

</div>
