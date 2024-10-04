<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">RBAC</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('admin.index') }}">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('users.index') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}"
                        href="{{ route('roles.index') }}">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : '' }}"
                        href="{{ route('permissions.index') }}">Permissions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('activity_log.index') ? 'active' : '' }}"
                        href="{{ route('activity_log.index') }}">Activity Log</a>
                </li>

            </ul>


            {{-- <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> --}}

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @if (Auth::check())
                    <li class="nav-item d-flex text-center">
                        <span class="navbar-text text-white  mx-5">{{ Auth::user()->email }}</span>
                    </li>
                    <li class="nav-item bg-danger rounded">
                        <a class="nav-link text-white" href="{{ route('auth.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
                    </li>
                @endif
            </ul>

        </div>
    </div>
</nav>
