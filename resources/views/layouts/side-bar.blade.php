<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            
            <span class="app-brand-text demo menu-text fw-bolder pr-2 text-capitalize fs-3">{{ env('APP_NAME', 'Donation-System') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @can('manage users')
           
        <!-- Manage Users -->
        <li class="menu-item {{ request()->routeIs('users.index') || request()->routeIs('roles.index') || request()->routeIs('permissions.index') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Layouts">Manage Users</div>
            </a>
            <ul class="menu-sub">
              @can('view user')
                  <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Users</div>
                    </a>
                </li>
              @endcan
              @can('view role') 
                <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">Roles</div>
                    </a>
                </li>
                @endcan
              @can('view permission')
                <li class="menu-item {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                    <a href="{{ route('permissions.index') }}" class="menu-link">
                        <div data-i18n="Container">Permissions</div>
                    </a>
                </li>
              @endcan
            </ul>
        </li>
    @endcan
    <!-- Manage Donators -->
        @can('manage donators')
        <li class="menu-item {{ request()->routeIs('donations.index') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-donate-heart"></i>
                <div data-i18n="Layouts">Donators</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('donations.index') ? 'active' : '' }}">
                    <a href="{{ route('donations.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Donators</div>
                    </a>
                </li>
                <!-- Additional submenu items if needed -->
            </ul>
        </li>
        @endcan

        @can('manage issuers')
        <!-- Manage Issuers -->
        <li class="menu-item {{ request()->routeIs('good-issues.index ') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-transfer-alt"></i>
                <div data-i18n="Account Settings">Issuers</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('good-issues.index') ? 'active' : '' }}">
                    <a href="{{ route('good-issues.index') }}" class="menu-link">
                        <div data-i18n="Account">Issuers</div>
                    </a>
                </li>
                
            </ul>
        </li>
        @endcan

        @can('manage products')
        <!-- Manage Products -->
        <li class="menu-item {{ request()->routeIs('products.index') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Authentications">Manage Products</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" class="menu-link">
                        <div data-i18n="Basic">Products</div>
                    </a>
                </li>
                
            </ul>
        </li>
        @endcan

        @can('manage inventory')
        <!-- Manage Inventory -->
        <li class="menu-item {{ request()->routeIs('inventories.index') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Misc">Manage Inventory</div>
            </a>
            <ul class="menu-sub">
                
                <li class="menu-item {{ request()->routeIs('inventories.index') ? 'active' : '' }}">
                    <a href="{{ route('inventories.index') }}" class="menu-link">
                        <div data-i18n="Under Maintenance">Inventory</div>
                    </a>
                </li>
            </ul>
        </li>
@endcan
        

        <!-- Misc -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
        <li class="menu-item">
            <a href="javascript:void(0);" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Support</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
            </a>
        </li>
    </ul>
</aside>
