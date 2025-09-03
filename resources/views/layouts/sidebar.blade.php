<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo">
                <img width="180px" src="{{ asset(\App\Helpers\Helper::getLogoLight()) }}" alt="{{env('APP_NAME')}}">
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bold">{{\App\Helpers\Helper::getCompanyName()}}</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>
    @role('vendor')
        <div class="user_info d-flex align-items-center text-start border-bottom px-3 py-2">
            <div class="avatar avatar-sm me-3">
                <span class="avatar-initial rounded-circle bg-label-primary fs-3">
                    <i class="ti ti-user"></i>
                </span>
            </div>
            <div class="overflow-hidden">
                <h6 class="mb-0 fw-bold">{{ Auth::user()->userShop->shop_name }}</h6>
                <small class="text-muted d-block text-truncate" style="max-width: 150px;">
                    {{ Auth::user()->email }}
                </small>
            </div>
        </div>
    @endrole

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon gradient-icon tf-icons ti ti-smart-home gradient-icon"></i>
                <div>{{__('Dashboard')}}</div>
            </a>
        </li>

        <!-- Apps & Pages -->
        <li class="menu-header small">
            <span class="menu-header-text">{{__('Apps & Pages')}}</span>
        </li>
        @role('vendor')
            @can(['view product'])
                <li class="menu-item {{ request()->routeIs('dashboard.products.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.products.index') }}" class="menu-link">
                        <i class="menu-icon gradient-icon tf-icons ti ti-building-warehouse"></i>
                        <div>{{__('Warehouse')}}</div>
                    </a>
                </li>
            @endcan
            @can(['view warehouse'])
                <li class="menu-item {{ request()->routeIs('dashboard.warehouse.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.warehouse.index') }}" class="menu-link">
                        <i class="menu-icon gradient-icon tf-icons ti ti-package"></i>
                        <div>{{__('Products')}}</div>
                    </a>
                </li>
            @endcan
        @else
            @can(['view product'])
                <li class="menu-item {{ request()->routeIs('dashboard.products.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.products.index') }}" class="menu-link">
                        <i class="menu-icon gradient-icon tf-icons ti ti-package"></i>
                        <div>{{__('Products')}}</div>
                    </a>
                </li>
            @endcan
            @can(['view warehouse'])
                <li class="menu-item {{ request()->routeIs('dashboard.warehouse.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.warehouse.index') }}" class="menu-link">
                        <i class="menu-icon gradient-icon tf-icons ti ti-building-warehouse"></i>
                        <div>{{__('Warehouse')}}</div>
                    </a>
                </li>
            @endcan
        @endrole
        @can(['view order'])
            <li class="menu-item {{ request()->routeIs('dashboard.orders.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.orders.index') }}" class="menu-link">
                    <i class="menu-icon gradient-icon tf-icons ti ti-shopping-cart"></i>
                    <div>{{__('Orders')}}</div>
                    @if (\App\Helpers\Helper::getVendorOrders() > 0)
                        <div class="badge text-bg-danger rounded-pill ms-auto">{{ \App\Helpers\Helper::getVendorOrders() }}</div>
                    @endif
                </a>
            </li>
        @endcan
        @role('vendor')
            @can(['view wallet'])
                <li class="menu-item {{ request()->routeIs('dashboard.wallet.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.wallet.index') }}" class="menu-link">
                        <i class="menu-icon gradient-icon tf-icons ti ti-wallet"></i>
                        <div>{{__('Wallet')}}</div>
                    </a>
                </li>
            @endcan
        @endrole
        @can(['view withdraw request'])
            <li class="menu-item {{ request()->routeIs('dashboard.withdraw-requests.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.withdraw-requests.index') }}" class="menu-link">
                    <i class="menu-icon gradient-icon tf-icons ti ti-wallet"></i>
                    <div>{{__('Withdraw Requests')}}</div>
                    @if (\App\Helpers\Helper::getWithdrawRequests() > 0)
                        <div class="badge text-bg-danger rounded-pill ms-auto">{{ \App\Helpers\Helper::getWithdrawRequests() }}</div>
                    @endif
                </a>
            </li>
        @endcan
        @can(['view contact'])
            <li class="menu-item {{ request()->routeIs('dashboard.contacts.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.contacts.index') }}" class="menu-link">
                    <i class="menu-icon gradient-icon tf-icons ti ti-phone"></i>
                    <div>{{__('Contacts')}}</div>
                </a>
            </li>
        @endcan
        @canany(['view user', 'view archived user', 'vendor'])
            <li class="menu-item {{ request()->routeIs('dashboard.user.*') || request()->routeIs('dashboard.archived-user.*')  || request()->routeIs('dashboard.vendors.*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon gradient-icon tf-icons ti ti-users"></i>
                    <div>{{__('Users')}}</div>
                </a>
                <ul class="menu-sub">
                    @can(['view user'])
                        <li class="menu-item {{ request()->routeIs('dashboard.user.*') ? 'active' : '' }}">
                            <a href="{{route('dashboard.user.index')}}" class="menu-link">
                                <div>{{__('All Users')}}</div>
                            </a>
                        </li>
                    @endcan
                    @can(['view vendor'])
                        <li class="menu-item {{ request()->routeIs('dashboard.vendors.*') ? 'active' : '' }}">
                            <a href="{{route('dashboard.vendors.index')}}" class="menu-link">
                                <div>{{__('Vendors')}}</div>
                            </a>
                        </li>
                    @endcan
                    @can(['view archived user'])
                        <li class="menu-item {{ request()->routeIs('dashboard.archived-user.*') ? 'active' : '' }}">
                            <a href="{{route('dashboard.archived-user.index')}}" class="menu-link">
                                <div>{{__('Archived Users')}}</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @canany(['view role', 'view permission'])
            <li class="menu-item {{ request()->routeIs('dashboard.roles.*') || request()->routeIs('dashboard.permissions.*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon gradient-icon tf-icons ti ti-settings"></i> --}}
                    <i class="menu-icon gradient-icon tf-icons ti ti-shield-lock"></i>
                    <div>{{__('Roles & Permissions')}}</div>
                </a>
                <ul class="menu-sub">
                    @can(['view role'])
                        <li class="menu-item {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                            <a href="{{route('dashboard.roles.index')}}" class="menu-link">
                                <div>{{__('Roles')}}</div>
                            </a>
                        </li>
                    @endcan
                    @can(['view permission'])
                        <li class="menu-item {{ request()->routeIs('dashboard.permissions.*') ? 'active' : '' }}">
                            <a href="{{route('dashboard.permissions.index')}}" class="menu-link">
                                <div>{{__('Permissions')}}</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can(['view setting'])
            <li class="menu-item {{ request()->routeIs('dashboard.setting.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.setting.index') }}" class="menu-link">
                    <i class="menu-icon gradient-icon tf-icons ti ti-settings"></i>
                    <div>{{__('Settings')}}</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
