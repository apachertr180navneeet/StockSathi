
<style>
    #sidebar-menu .menuitem-active > a {
        background-color: #eef2ff !important;
        color: #556ee6 !important;
        font-weight: 600;
    }

    #sidebar-menu a.active {
        color: #556ee6 !important;
        font-weight: 600;
    }
</style>
<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <div id="sidebar-menu">

            <!-- Logo -->
            <div class="logo-box">
                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm fw-bold text-white">SS</span>
                    <span class="logo-lg fw-bold text-white">StockSathi</span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm fw-bold text-dark">SS</span>
                    <span class="logo-lg fw-bold text-dark">StockSathi</span>
                </a>
            </div>

            <ul id="side-menu">

                <!-- Dashboard -->
                <li class="menu-title">Menu</li>
                <li class="{{ request()->routeIs('dashboard') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">Pages</li>

                <!-- Brand -->
                <li class="{{ request()->is('*/brand*') ? 'menuitem-active' : '' }}">
                    <a href="#brandMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/brand*') ? 'active' : 'collapsed' }}">
                        <i data-feather="users"></i>
                        <span> Brand Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/brand*') ? 'show' : '' }}" id="brandMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.brand') }}"
                                   class="{{ request()->is('*/brand*') ? 'active' : '' }}">
                                    All Brand
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Warehouse -->
                <li class="{{ request()->is('*/warehouse*') ? 'menuitem-active' : '' }}">
                    <a href="#warehouseMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/warehouse*') ? 'active' : 'collapsed' }}">
                        <i data-feather="alert-octagon"></i>
                        <span> WareHouse Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/warehouse*') ? 'show' : '' }}" id="warehouseMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.warehouse') }}"
                                   class="{{ request()->is('*/warehouse*') ? 'active' : '' }}">
                                    All WareHouse
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Supplier -->
                <li class="{{ request()->is('*/supplier*') ? 'menuitem-active' : '' }}">
                    <a href="#supplierMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/supplier*') ? 'active' : 'collapsed' }}">
                        <i data-feather="file-text"></i>
                        <span> Supplier Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/supplier*') ? 'show' : '' }}" id="supplierMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.supplier') }}"
                                   class="{{ request()->is('*/supplier*') ? 'active' : '' }}">
                                    All Supplier
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Customer -->
                <li class="{{ request()->is('*/customer*') ? 'menuitem-active' : '' }}">
                    <a href="#customerMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/customer*') ? 'active' : 'collapsed' }}">
                        <i data-feather="calendar"></i>
                        <span> Customer Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/customer*') ? 'show' : '' }}" id="customerMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.customer') }}"
                                   class="{{ request()->is('*/customer*') ? 'active' : '' }}">
                                    All Customer
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Product -->
                <li class="{{ request()->is('*/category*') || request()->is('*/product*') ? 'menuitem-active' : '' }}">
                    <a href="#productMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/category*') || request()->is('*/product*') ? 'active' : 'collapsed' }}">
                        <i data-feather="package"></i>
                        <span> Product Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/category*') || request()->is('*/product*') ? 'show' : '' }}" id="productMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.category') }}"
                                   class="{{ request()->is('*/category*') ? 'active' : '' }}">
                                    All Category
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.product') }}"
                                   class="{{ request()->is('*/product*') ? 'active' : '' }}">
                                    All Product
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Purchase -->
                <li class="{{ request()->is('*/purchase*') ? 'menuitem-active' : '' }}">
                    <a href="#purchaseMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/purchase*') ? 'active' : 'collapsed' }}">
                        <i data-feather="aperture"></i>
                        <span> Purchase Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/purchase*') ? 'show' : '' }}" id="purchaseMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.purchase') }}"
                                   class="{{ request()->is('*/purchase*') ? 'active' : '' }}">
                                    All Purchase
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.return.purchase') }}"
                                   class="{{ request()->is('*/purchase*') ? 'active' : '' }}">
                                    Purchase Return
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Sale -->
                <li class="{{ request()->is('*/sale*') ? 'menuitem-active' : '' }}">
                    <a href="#saleMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/sale*') ? 'active' : 'collapsed' }}">
                        <i data-feather="award"></i>
                        <span> Sale Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/sale*') ? 'show' : '' }}" id="saleMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.sale') }}"
                                   class="{{ request()->is('*/sale*') ? 'active' : '' }}">
                                    All Sale
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.sale.return') }}"
                                   class="{{ request()->is('*/sale*') ? 'active' : '' }}">
                                    Sale Return
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Due -->
                <li class="{{ request()->is('*/due*') ? 'menuitem-active' : '' }}">
                    <a href="#dueMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/due*') ? 'active' : 'collapsed' }}">
                        <i data-feather="briefcase"></i>
                        <span> Due Setup </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/due*') ? 'show' : '' }}" id="dueMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('due.sale') }}"
                                   class="{{ request()->is('*/due*') ? 'active' : '' }}">
                                    Sales Due
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('due.sale.return') }}"
                                   class="{{ request()->is('*/due*') ? 'active' : '' }}">
                                    Sales Return Due
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Transfers -->
                <li class="{{ request()->is('*/transfer*') ? 'menuitem-active' : '' }}">
                    <a href="#transferMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/transfer*') ? 'active' : 'collapsed' }}">
                        <i data-feather="table"></i>
                        <span> Transfers Setup </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/transfer*') ? 'show' : '' }}" id="transferMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.transfer') }}"
                                   class="{{ request()->is('*/transfer*') ? 'active' : '' }}">
                                    Transfers
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Report -->
                <li class="{{ request()->is('*/report*') ? 'menuitem-active' : '' }}">
                    <a href="#Report" data-bs-toggle="collapse">
                        <i data-feather="alert-octagon"></i>
                        <span> Report Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ request()->is('*/report*') ? 'show' : '' }}" id="Report">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.report') }}" class="{{ request()->is('*/report*') ? 'active' : '' }}">All Reports </a>
                            </li>
                            
                            
                        </ul>
                    </div>
                </li>

                <!-- General -->
                <li class="menu-title mt-2">General</li>

                <!-- Role & Permission -->
                <li class="{{ request()->is('*/role*') || request()->is('*/permission*') ? 'menuitem-active' : '' }}">
                    <a href="#roleMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/role*') || request()->is('*/permission*') ? 'active' : 'collapsed' }}">
                        <i data-feather="package"></i>
                        <span> Role & Permission </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/role*') || request()->is('*/permission*') ? 'show' : '' }}" id="roleMenu">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('all.permission') }}" class="{{ request()->is('*/permission*') ? 'active' : '' }}">All Permission</a></li>
                            <li><a href="{{ route('all.roles') }}" class="{{ request()->is('*/role*') ? 'active' : '' }}">All Roles</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Admin -->
                <li class="{{ request()->is('*/admin*') ? 'menuitem-active' : '' }}">
                    <a href="#adminMenu" data-bs-toggle="collapse"
                       class="{{ request()->is('*/admin*') ? 'active' : 'collapsed' }}">
                        <i data-feather="map"></i>
                        <span> Manage Admin </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->is('*/admin*') ? 'show' : '' }}" id="adminMenu">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.admin') }}"
                                   class="{{ request()->is('*/admin*') ? 'active' : '' }}">
                                    All Admin
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>

    </div>
</div>