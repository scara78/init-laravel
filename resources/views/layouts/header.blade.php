<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" data-toggle="sidebar-show" type="button">
        <span class="navbar-toggler-icon">
        </span>
    </button>
    <a class="navbar-brand" href="{{route('admin')}}">
        <img class="navbar-brand-full" src="{{url('/assets/img/sidebar_logo_light.png')}}">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" data-toggle="sidebar-lg-show" type="button">
        <span class="navbar-toggler-icon">
        </span>
    </button>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown mr-3">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link" data-toggle="dropdown" href="#" role="button">
                <button class="btn more-icon">
                    <i class="material-icons">more_vert</i>
                </button>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">

                    <i class="material-icons">exit_to_app</i> Logout

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </div>
        </li>
    </ul>
</header>