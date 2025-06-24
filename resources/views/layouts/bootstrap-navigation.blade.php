<nav class="navbar navbar-expand-lg" style="background-color: #2e86de; padding: 1rem 2rem;">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="#" style="font-size: 1.4rem;">
            🏥 MUTASI BARANG RUMAH SAKIT
        </a>

        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
            @auth
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'fw-semibold' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('mutasi.index') ? 'fw-semibold' : '' }}" href="{{ route('mutasi.index') }}">
                        Data
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item">Keluar</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>
