<!-- Sidebar Menu -->
<nav class="mt-4">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="sidebarnav">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('account/dashboard*') ? 'active' : '' }}">
                <i class="nav-icon icon-dashboard"></i>
                <p>
                    @lang('menu.dashboard')
                </p>
            </a>
        </li>

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('read_location') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.locations.index') }}" class="nav-link {{ request()->is('account/locations*') ? 'active' : '' }}">
                <i class="nav-icon icon-map-alt"></i>
                <p>
                    @lang('menu.locations')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('read_category') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('account/categories*') ? 'active' : '' }}">
                <i class="nav-icon icon-list"></i>
                <p>
                    @lang('menu.categories')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('read_business_service') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.business-services.index') }}" class="nav-link {{ request()->is('account/business-services*') ? 'active' : '' }}">
                <i class="nav-icon icon-shopping-cart-full"></i>
                <p>
                    @lang('menu.services')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('read_business_service') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->is('account/products*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-cart-plus"></i>
                <p>@lang('menu.products')</p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('read_customer') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->is('account/customers*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-user-o"></i>
                <p>
                    @lang('menu.customers')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('read_employee') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.employee.index') }}" class="nav-link {{ request()->is('account/employee*') ? 'active' : '' }} {{ request()->is('account/employee-leaves*') ? 'active' : '' }}">
                <i class="nav-icon icon-user"></i>
                <p>
                    @lang('menu.employee')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('create_coupon') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->is('account/coupons*') ? 'active' : '' }}">
                <i class="nav-icon fa  fa-tags"></i>
                <p>
                    @lang('menu.coupons')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('create_deal') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.deals.index') }}" class="nav-link {{ request()->is('account/deals*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-handshake-o"></i>
                <p>
                    @lang('menu.deals')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('create_advertisement_banner') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.advertisements.index') }}" class="nav-link {{ request()->is('account/advertisements*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-audio-description"></i>
                <p>
                    @lang('menu.advertisement')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('create_booking') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.pos.create') }}" class="nav-link {{ request()->is('account/pos*') ? 'active' : '' }}">
                <i class="nav-icon icon-shopping-cart"></i>
                <p>
                    @lang('menu.pos')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('read_booking') || $user->roles()->withoutGlobalScopes()->latest()->first()->hasPermission('create_booking'))
        <li class="nav-item">
            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->is('account/bookings*') ? 'active' : '' }}">
                <i class="nav-icon icon-calendar"></i>
                <p>
                    @lang('menu.bookings')
                </p>
            </a>
        </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_booking') || $user->roles()->withoutGlobalScopes()->first()->hasPermission('create_booking') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.calendar') }}" class="nav-link {{ request()->is('account/calendar*') ? 'active' : '' }}">
                <i class="nav-icon icon-calendar"></i>
                <p>
                    @lang('menu.bookings')<br />
                    @lang('menu.calendar')
                </p>
            </a>
        </li>
        @endif

        @if (($user->is_admin || $user->is_employee) && !\Session::get('loginRole') && ($current_emp_role->name == 'employee' || $current_emp_role->name == 'administrator'))
        <li class="nav-item">
            <a href="{{ route('admin.todo-items.index') }}" class="nav-link {{ request()->is('account/todo-items*') ? 'active' : '' }}">
                <i class="nav-icon icon-notepad"></i>
                <p>
                    @lang('menu.todoList')
                </p>
            </a>
        </li>
        @endif

        @if (($user->is_employee) && !\Session::get('loginRole') && ($current_emp_role->name == 'employee'))
            <li class="nav-item">
                <a href="{{ route('admin.employeeLeaves') }}" class="nav-link {{ request()->is('account/employeeLeaves*') ? 'active' : '' }}">
                    <i class="nav-icon icon-rocket" style="transform: rotate(40deg);
                        display: inline-block;"></i>
                    <p>@lang('menu.leaves')</p>
                </a>
            </li>
        @endif

        @if ($user->roles()->withoutGlobalScopes()->first()->hasPermission('read_report') && !\Session::get('loginRole') || $current_emp_role->name == 'administrator')
        <li class="nav-item">
            <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->is('account/reports*') ? 'active' : '' }}">
                <i class="nav-icon icon-pie-chart"></i>
                <p>
                    @lang('menu.reports')
                </p>
            </a>
        </li>
        @endif


        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->is('account/settings*') ? 'active' : '' }}">
                <i class="nav-icon icon-settings"></i>
                <p>
                    @lang('menu.settings')
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
