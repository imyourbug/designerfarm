<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        @switch(Auth::user()?->role)
            @case(1)
                <a href="{{ route('admin.index') }}" class="brand-link text-center">
                    <span class="brand-text font-weight-light">Quản lý</span>
                </a>
            @break
        @endswitch
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 d-flex">
            @switch(Auth::user()?->role)
                @case(0)
                    <div class="image">
                        <img src="{{ Auth::user()?->staff->avatar ?? '/images/default.jpg' }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                @break
            @endswitch
            <div class="info" style="text-align: center">
                @switch(Auth::user()?->role)
                    @case(1)
                        <a href="{{ route('admin.index') }}" class="d-block">{{ Auth::user()->name ?? Auth::user()->email }}</a>
                    @break
                @endswitch
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @switch(Auth::user()?->role)
                    {{-- Admin --}}
                    @case(1)
                        <li
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.accounts.index', 'admin.accounts.create'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.accounts.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-user"></i>
                                <p>
                                    Tài khoản
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.packages.index', 'admin.packages.create'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.packages.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-cube"></i>
                                <p>
                                    Gói
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.members.index', 'admin.members.create'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.members.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-people-roof"></i>
                                <p>
                                    Thành viên
                                </p>
                            </a>
                        </li>
                    @break
                @endswitch
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
