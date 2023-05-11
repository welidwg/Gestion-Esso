<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-dark p-0 toggled">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-icon rotate-n-15">
                {{-- <i class="fas fa-laugh-wink"></i> --}}
            </div>
            <div class="sidebar-brand-text mx-3">
                <span>Esso</span>
            </div>

        </a>
        <hr class="sidebar-divider my-0" />
        <ul id="accordionSidebar" class="navbar-nav text-light">

            @if (Auth::user()->role == 0)
                <li class="nav-item">
                    <a class="nav-link   {{ Route::currentRouteName() == 'view.main' ? 'active' : '' }}"
                        href="/main"><i class="fas fa-tachometer-alt"></i><span>Tableau de bord</span></a>

                </li>
                <li class="nav-item">
                    <a class="nav-link   {{ Route::currentRouteName() == 'stats' ? 'active' : '' }}"
                        href="/stats/moyenne"><i class="fas fa-tachometer-alt"></i><span>Moyenne de
                            consommation</span></a>

                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'carburant.index' ? 'active' : '' }}"
                        href="{{ route('carburant.index') }}"><i class="fas fa-box-full"></i><span>Carburants</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'cigarette.index' ? 'active' : '' }}"
                        href="{{ route('cigarette.index') }}">
                        <i class="fas fa-smoking "></i>
                        <span>Cigarettes</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'releve.index' ? 'active' : '' }}"
                        href="{{ route('releve.index') }}"><i class="fas fa-file-chart-pie "></i><span>Journal
                            caisse</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'facture.create' ? 'active' : '' }}"
                        href="{{ route('facture.create') }}"><i class="fas fa-file-plus"></i><span>Ajouter
                            facture</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'facture.index' ? 'active' : '' }}"
                        href="{{ route('facture.index') }}"><i class="far fa-file-invoice"></i><span>Historique
                            factures</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ Route::currentRouteName() == 'user.caissier' ? 'active' : '' }}"
                        href="{{ route('user.caissier') }}"><i class="fas fa-users"></i><span>
                            Caissiers</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'view.add_user' ? 'active' : '' }}"
                        href="{{ route('view.add_user') }}"><i class="fas fa-user-plus"></i><span>Ajouter
                            utilisteur</span></a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link   {{ Route::currentRouteName() == 'releve.create' ? 'active' : '' }}"
                        href="{{ route('releve.create') }}"><i
                            class="fas fa-tachometer-alt"></i><span>Relevé</span></a>

                </li>
                <li class="nav-item">
                    <a class="nav-link   {{ Route::currentRouteName() == 'factureCaissier.create' ? 'active' : '' }}"
                        href="{{ route('factureCaissier.create') }}"><i class="fas fa-tachometer-alt"></i><span>Mise
                            à
                            jour stock</span></a>

                </li>
                <li class="nav-item">
                    <a class="nav-link   {{ Route::currentRouteName() == 'cigarette.achat' ? 'active' : '' }}"
                        href="{{ route('cigarette.achat') }}"><i class="fas fa-smoking"></i><span>Achat
                            cigarettes</span></a>

                </li>
                <li class="nav-item">
                    <a class="nav-link   {{ Route::currentRouteName() == 'caissier.releves' ? 'active' : '' }}"
                        href="{{ route('caissier.releves') }}"><i class="fas fa-file"></i><span>Vos
                            relevés</span></a>

                </li>
            @endif
        </ul>
        {{-- <div class="text-center d-none d-md-inline">
            <button id="sidebarToggle" class="btn rounded-circle border-0" type="button"></button>
        </div> --}}
    </div>
</nav>
