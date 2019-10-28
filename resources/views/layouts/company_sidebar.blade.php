<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="has-arrow" href="{{ route('staffs.index') }}" aria-expanded="false">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">Staffs Management </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('staffs.index') }}">
                                <i class="mdi mdi-account-plus"></i> List Staffs
                            </a>
                            <a href="{{ route('staffs.create') }}">
                                <i class="mdi mdi-account-plus"></i> Create New Staff
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="{{ route('roles.index') }}" aria-expanded="false">
                        <i class="mdi mdi-settings"></i>
                        <span class="hide-menu">Roles Management </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('roles.index') }}">
                                <i class="mdi mdi-account-settings-variant"></i> List Roles
                            </a>
                            <a href="{{ route('roles.create') }}">
                                <i class="mdi mdi-database-plus"></i> Create New Role
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
