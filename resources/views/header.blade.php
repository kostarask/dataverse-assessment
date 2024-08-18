<!-- Header -->
<header id="header-demo">
    <nav class="navbar navbar-expand-md bg-secondary-subtle bsb-navbar-3">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item me-3">
                    <a class="nav-link" href="#!" data-bs-toggle="offcanvas" data-bs-target="#bsbSidebar1" aria-controls="bsbSidebar1">
                        <i class="bi-filter-left fs-3 lh-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
                @can('viewAny', \App\Models\User::class)
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('user.index') }}">{{ __('Users') }}</a>
                </li>
                @endcan
                @can('viewAny', \App\Models\Role::class)
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('role.index') }}">{{ __('Roles') }}</a>
                </li>
                @endcan
                @can('viewAny', \App\Models\Permission::class)
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('permission.index') }}">{{ __('Permissions') }}</a>
                    </li>
                @endcan
            </ul>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#bsbNavbar" aria-controls="bsbNavbar" aria-label="Toggle Navigation">
                <i class="bi bi-three-dots"></i>
            </button>
            <div class="collapse navbar-collapse" id="bsbNavbar">
                <ul class="navbar-nav bsb-dropdown-menu-responsive ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle bsb-dropdown-toggle-caret-disable" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <span class="position-relative pt-1">
                            <i class="bi bi-globe"></i>
                          </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md-end bsb-dropdown-sm bsb-dropdown-animation bsb-fadeIn">
                            <div>
                                <hr class="dropdown-divider mb-0">
                            </div>
                            <div class="list-group list-group-flush">
                                @foreach(config('localization.locales') as $locale_key => $locale_name)
                                    <a href="{{ route('localization', $locale_key) }}" class="list-group-item list-group-item-action {{ session('localization', config('app.locale')) === $locale_key ? 'active' : '' }} aria-current="true">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-10">
                                                <div class="ps-3">
                                                    <div class="fs-7">{{ __($locale_name) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div>
                                <hr class="dropdown-divider mt-0">
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle bsb-dropdown-toggle-caret-disable" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="position-relative pt-1">
                            <i class="bi bi-person-circle"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-md-end bsb-dropdown-animation bsb-fadeIn">
                            @auth
                                <li>
                                    <h6 class="dropdown-header fs-7 text-center">{{ __('Welcome') . ', ' . auth()->getUser()->name }}</h6>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action=" {{ route('user.logout') }}">
                                        @csrf
                                        <a class="dropdown-item text-center" href="{{ route('user.logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                          <span>
                                            <span class="fs-7">{{ __('Log Out') }}</span>
                                          </span>
                                        </a>
                                    </form>
                                </li>
                            @endauth
                            @guest
                                <li>
                                    <a class="dropdown-item text-center" href="{{ route('login') }}">
                                          <span>
                                            <span class="fs-7">{{ __('Log In') }}</span>
                                          </span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-center" href="{{ route('user.registration') }}">
                                          <span>
                                            <span class="fs-7">{{ __('Register') }}</span>
                                          </span>
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
