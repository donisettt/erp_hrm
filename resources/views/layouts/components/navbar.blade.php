<nav class="navbar navbar-expand-lg topbar">
    <div class="container-fluid">

        <button class="btn btn-outline-light" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg me-2"></i>
                    Halo, {{ Auth::user()->nama }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil Saya</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                        </form>

                        <a class="dropdown-item text-danger" href="#" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
