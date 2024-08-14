<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CMS Blog</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @if (Auth::user()->role == 'admin')
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @else
        <li class="nav-item {{ request()->routeIs('dashboard.author') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.author') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    @if (Auth::user()->role == 'admin')
        <li
            class="nav-item {{ request()->routeIs('users.*') || request()->routeIs('kategory.*') || request()->routeIs('post-data.*') ? 'active' : '' }} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Master Data</span>
            </a>
            <div id="collapseTwo"
                class="collapse {{ request()->routeIs('users.*') || request()->routeIs('kategory.*') || request()->routeIs('post-data.*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master Data:</h6>
                    <a class="collapse-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">Author</a>
                    <a class="collapse-item {{ request()->routeIs('kategory.*') ? 'active' : '' }}"
                        href="{{ route('kategory.index') }}">Kategory</a>
                    <a class="collapse-item {{ request()->routeIs('post-data.*') ? 'active' : '' }}"
                        href="{{ route('post-data.index') }}">Posts</a>
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->role == 'author')
        <!-- Nav Item - post -->
        <li class="nav-item {{ request()->routeIs('posts.index') ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}"
                href="{{ route('posts.index') }}">
                <i class="far fa-newspaper"></i>
                <span>Posts</span></a>
        </li>
    @else
        <!-- Nav Item - post -->
        <li class="nav-item {{ request()->routeIs('approval-post.index') ? 'active' : '' }}">
            <a class="nav-link {{ request()->routeIs('approval-post.index') ? 'active' : '' }}"
                href="{{ route('approval-post.index') }}">
                <i class="far fa-newspaper"></i>
                <span>Approval Posts</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
