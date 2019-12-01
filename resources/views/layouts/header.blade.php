<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a
                class="navbar-brand"
                @if (\Auth::user()->user_type === 'admin')
                    href="{{ route('company.index') }}"
                @else
                    href="{{ route('staffs.index') }}"
                @endif
            >
                <img src="{{ asset('img/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                <img src="{{ asset('img/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                </b>
                <span>
                    <img src="{{ asset('img/logo-text.png') }}" alt="homepage" class="dark-logo" />
                    <img src="{{ asset('img/logo-light-text.png') }}" class="light-logo" alt="homepage" />
                </span>
            </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto mt-md-0">
                <li class="nav-item">
                    <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-menu"></i>
                    </a>
                </li>
                <li class="nav-item hidden-sm-down search-box">
                    <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)">
                        <i class="ti-search"></i>
                    </a>
                    <form class="app-search">
                        <input type="text" class="form-control" placeholder="Search & enter">
                        <a class="srh-btn">
                            <i class="ti-close"></i>
                        </a>
                    </form>
                </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img
                            src="{{ \Auth::user()->media->count() ? asset(storage_url(\Auth::user()->media[0]->preview_path)) : '/img/default_avatar.jpg'}}"
                            alt="avatar"
                            class="profile-pic"
                        />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img">
                                        <img
                                            src="{{ \Auth::user()->media->count() ? asset(storage_url(\Auth::user()->media[0]->preview_path)) : '/img/default_avatar.jpg'}}"
                                            alt="avatar"
                                        >
                                    </div>
                                    <div class="u-text">
                                        <h4 title="{{ \Auth::user()->name }}">{{ str_limit(\Auth::user()->name, 15, '....') }}</h4>
                                        <p title="{{ \Auth::user()->email }}" class="text-muted">
                                            {{ str_limit(\Auth::user()->email, 15, '...') }}
                                        </p>
                                        <a href="#" class="btn btn-rounded btn-danger btn-sm">
                                            <i class="ti-settings"></i> Account Setting
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn waves-effect waves-light btn-block btn-secondary" type="submit">
                                        <i class="fa fa-power-off"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
