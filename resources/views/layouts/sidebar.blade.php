<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">
                <span class="logo-name">Zeszyt</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="dropdown {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                        data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown {{ Request::routeIs('admin.operation-enter') ? 'active' : '' }}">
                <a href="{{ route('admin.operation-enter') }}" class="nav-link"><i data-feather="settings"></i><span>Operation Enter</span></a>
            </li>
            <li class="dropdown {{ Request::routeIs('admin.operation-history') ? 'active' : '' }}">
                <a href="{{ route('admin.operation-history') }}" class="nav-link"><i
                        data-feather="clock"></i><span>Operation History</span></a>
            </li>
            <li class="dropdown {{ Request::routeIs('admin.monthly-summary') ? 'active' : '' }}">
                <a href="{{ route('admin.monthly-summary') }}" class="nav-link"><i
                        data-feather="monitor"></i><span>Monthly Summary</span></a>
            </li>
        </ul>
    </aside>
</div>
