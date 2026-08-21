<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">Admin</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pagini
            </li>

            <li class="sidebar-item {{ request()->routeIs('admin.show-home') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.show-home') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Acasa</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('admin.show-users') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.show-users') }}">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Utilizatori</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('admin.show-categories') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.show-categories') }}">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Categorii</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="layout"></i> <span class="align-middle">Postări</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="message-square"></i> <span class="align-middle">Mesaje de contact</span>
                </a>
            </li>
        </ul>
    </div>
</nav>