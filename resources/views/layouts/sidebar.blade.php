<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a class="{{ Request::is('my-projects') ? 'active' : '' }}" href="{{ route('staffs.my_projects') }}">
                        <i class="mdi mdi-database"></i>My Projects
                    </a>
                </li>

                @if (Request::is('my-projects/*'))
                <li>
                    <a class="{{ Request::is('my-projects/*/tickets/create') ? 'active' : '' }}" href="{{ route('tickets.create', request()->slug) }}">
                        <i class="mdi mdi-credit-card-plus"></i>New Ticket
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('my-projects/*/overview') ? 'active' : '' }}" href="{{ route('staffs.my_projects.overview', request()->slug) }}">
                        <i class="mdi mdi-file-find"></i>Overview
                    </a>
                </li>
                @endif
                @if (Request::is('tickets/*'))
                <li>
                    <a class="{{ Request::is('my-projects/*/tickets/create') ? 'active' : '' }}" href="{{ route('tickets.create', $ticket->project->slug) }}">
                        <i class="mdi mdi-credit-card-plus"></i>New Ticket
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('my-projects/*/overview') ? 'active' : '' }}" href="{{ route('staffs.my_projects.overview', $ticket->project->slug) }}">
                        <i class="mdi mdi-file-find"></i>Overview
                    </a>
                </li>
                @endif

                @if (Request::is('my-projects/*/tickets'))
                <li>
                    <a class="{{ Request::is('my-projects/*/tickets') ? 'active' : '' }}" href="#ticket1">
                        <i class="mdi mdi-comment-alert"></i>Tickets
                    </a>
                </li>
                @else
                <li>
                    <a class="{{ Request::is('tickets') ? 'active' : '' }}" href="#ticket2">
                        <i class="mdi mdi-comment-alert"></i>Tickets
                    </a>
                </li>
                @endif

                @if (Request::is('my-projects/*/activities'))
                <li>
                    <a class="{{ Request::is('my-projects/*/activities') ? 'active' : '' }}" href="#activity1">
                        <i class="mdi mdi-comment-text"></i>Activity
                    </a>
                </li>
                @else
                <li>
                    <a class="{{ Request::is('activities') ? 'active' : '' }}" href="#activity2">
                        <i class="mdi mdi-comment-text"></i>Activity
                    </a>
                </li>
                @endif

                @if (Request::is('my-projects/*/spend-time'))
                <li>
                    <a class="{{ Request::is('my-projects/*/spend-time') ? 'active' : '' }}" href="#spendtime1">
                        <i class="mdi mdi-timetable"></i>Spend Time
                    </a>
                </li>
                @else
                <li>
                    <a class="{{ Request::is('spend-time') ? 'active' : '' }}" href="#spendtime2">
                        <i class="mdi mdi-timetable"></i>Spend Time
                    </a>
                </li>
                @endif

                @if (Request::is('my-projects/*'))
                <li>
                    <a class="{{ Request::is('teams') ? 'active' : '' }}" href="#team">
                        <i class="mdi mdi-github-box"></i>Teams
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('versions') ? 'active' : '' }}" href="#version">
                        <i class="mdi mdi-git"></i>Versions
                    </a>
                </li>
                @endif
                @if (Request::is('tickets/*'))
                <li>
                    <a class="{{ Request::is('teams') ? 'active' : '' }}" href="#team">
                        <i class="mdi mdi-github-box"></i>Teams
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('versions') ? 'active' : '' }}" href="#version">
                        <i class="mdi mdi-git"></i>Versions
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
