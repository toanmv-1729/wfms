<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a
                class="navbar-brand"
                @if (\Auth::user()->user_type === 'admin')
                    href="{{ route('company.index') }}"
                @elseif(\Auth::user()->user_type === 'company')
                    href="{{ route('staffs.index') }}"
                @else
                    href="{{ route('staffs.my_projects') }}"
                @endif
            >
                @if (!Request::is('my-projects') && (!empty($project) || !empty($ticket)))
                    <h3 style="color: #ffffff;">{{ $project->name ?? $ticket->project->name }}</h3>
                @elseif (\Auth::user()->company)
                    <h3 style="color: #ffffff;">{{ \Auth::user()->company->name }}</h3>
                @else
                    <img src="{{ asset('img/14-logo2015-05.jpg') }}" width="30%" alt="homepage"/>
                @endif
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
                            style="height: 30px;"
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
                                        @if (\Auth::user()->user_type !== 'admin')
                                        <a href="{{ route('users.profile') }}" class="btn btn-rounded btn-danger btn-sm">
                                            <i class="ti-settings"></i> Account Setting
                                        </a>
                                        @endif
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
