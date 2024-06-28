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
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.websites.index', 'admin.websites.create'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.websites.index') }}" class="nav-link">
                                <i class="nav-icon fa-regular fa-file-lines"></i>
                                <p>
                                    Website
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
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.packagedetails.index', 'admin.packagedetails.create'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.packagedetails.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-circle-info"></i>
                                <p>
                                    Chi tiết gói
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
                        <li
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.requests.index', 'admin.requests.create'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.requests.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-invoice-dollar"></i>
                                <p>
                                    Yêu cầu nạp
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.discounts.index', 'admin.discounts.create'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.discounts.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-ticket"></i>
                                <p>
                                    Mã giảm giá
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.reports.index'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.reports.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-chart-simple"></i>
                                <p>
                                    Thống kê
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ in_array(request()->route()->getName(), ['admin.settings.index'])
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-gear"></i>
                                <p>
                                    Hệ thống
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
