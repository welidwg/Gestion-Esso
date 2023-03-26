<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-dark p-0">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-icon rotate-n-15">
                {{-- <i class="fas fa-laugh-wink"></i> --}}
            </div>
            <div class="sidebar-brand-text mx-3">
                <span>Brand</span>
            </div>

        </a>
        <hr class="sidebar-divider my-0" />
        <ul id="accordionSidebar" class="navbar-nav text-light">
            <li class="nav-item">
                <a class="nav-link   {{ Route::currentRouteName() == 'view.main' ? 'active' : '' }}"
                    href="index.html"><i class="fas fa-tachometer-alt"></i><span>Tableau de bord</span></a>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.html"><i class="fas fa-user"></i><span>Profile</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="table.html"><i class="fas fa-table"></i><span>Table</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.html"><i class="far fa-user-circle"></i><span>Login</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.html"><i class="fas fa-user-circle"></i><span>Register</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="blank.html"><i class="fas fa-window-maximize"></i><span>Blank
                        Page</span></a>
            </li>
        </ul>
        <div class="text-center d-none d-md-inline">
            <button id="sidebarToggle" class="btn rounded-circle border-0" type="button"></button>
        </div>
    </div>
</nav>
