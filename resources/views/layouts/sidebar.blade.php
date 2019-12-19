<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a class="{{ Request::is('my-projects') ? 'active' : '' }}" href="{{ route('staffs.my_projects') }}">
                        <i class="mdi mdi-database"></i>My Projects
                    </a>
                </li>
                @if (\Auth::user()->roles[0]->name === 'Scrum Master' && empty(request()->slug) && empty($ticket))
                <li>
                    <a class="{{ Request::is('roles') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="mdi mdi-database"></i>Roles
                    </a>
                </li>
                @endif

                @if (!empty(request()->slug))
                <li>
                    <a class="{{ Request::is('*/tickets/create') ? 'active' : '' }}" href="{{ route('tickets.create', request()->slug) }}">
                        <i class="mdi mdi-credit-card-plus"></i>New Ticket
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('*/overview') ? 'active' : '' }}" href="{{ route('staffs.my_projects.overview', request()->slug) }}">
                        <i class="mdi mdi-file-find"></i>Overview
                    </a>
                </li>
                @endif
                @if (!empty($ticket) && empty(request()->slug))
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

                @if (!empty(request()->slug) || !empty($ticket))
                <li>
                    <a class="{{ Request::is('*/tickets') ? 'active' : '' }}" href="{{ route('tickets.index', request()->slug ?? $ticket->project->slug) }}">
                        <i class="mdi mdi-comment-alert"></i>Tickets
                    </a>
                </li>
                @else
                <li>
                    <a class="{{ Request::is('tickets') ? 'active' : '' }}" href="{{ route('tickets.all') }}">
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

                @if (!empty(request()->slug) || !empty($ticket))
                <li>
                    <a class="{{ Request::is('*/spend-times') ? 'active' : '' }}" href="{{ route('spend_times.index', request()->slug ?? $ticket->project->slug) }}">
                        <i class="mdi mdi-timetable"></i>Spend Time
                    </a>
                </li>
                @else
                <li>
                    <a class="{{ Request::is('spend-times') ? 'active' : '' }}" href="{{ route('spend_times.all') }}">
                        <i class="mdi mdi-timetable"></i>Spend Time
                    </a>
                </li>
                @endif

                @if (!empty(request()->slug) || !empty($ticket))
                <li>
                    <a class="{{ Request::is('*/teams') ? 'active' : '' }}" href="{{ route('teams.index', request()->slug ?? $ticket->project->slug) }}">
                        <i class="mdi mdi-github-box"></i>Teams
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('*/versions') ? 'active' : '' }}" href="{{ route('versions.index', request()->slug ?? $ticket->project->slug) }}">
                        <i class="mdi mdi-git"></i>Versions
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('*/documents') ? 'active' : '' }}" href="{{ route('documents.index', request()->slug ?? $ticket->project->slug) }}">
                        <i class="mdi mdi-file-document"></i>Documents
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('*/sample-descriptions') ? 'active' : '' }}" href="{{ route('sample_descriptions.index', request()->slug ?? $ticket->project->slug) }}">
                        <i class="mdi mdi-book-open"></i>Samples
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
