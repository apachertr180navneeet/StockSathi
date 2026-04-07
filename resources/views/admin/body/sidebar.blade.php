<style>
.logo-lg { font-size: 20px; letter-spacing: 1px; }
.logo-sm { font-size: 16px; }
</style>

<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <div id="sidebar-menu">

            <!-- LOGO -->
            <div class="logo-box">
                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm fw-bold text-white">SS</span>
                    <span class="logo-lg fw-bold text-white">Stocksathi</span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm fw-bold text-dark">SS</span>
                    <span class="logo-lg fw-bold text-dark">Stocksathi</span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="tp-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">Pages</li>

                <!-- Brand -->
                <li>
                    <a href="#Brand" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.brand','add.brand','edit.brand') ? '' : 'collapsed' }}">
                        <i data-feather="box"></i>
                        <span> Brand Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.brand','add.brand','edit.brand') ? 'show' : '' }}" id="Brand">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.brand') }}"
                                   class="tp-link {{ request()->routeIs('all.brand','add.brand','edit.brand') ? 'active' : '' }}">
                                    All Brand
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Warehouse -->
                <li>
                    <a href="#Warehouse" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.warehouse','add.warehouse','edit.warehouse') ? '' : 'collapsed' }}">
                        <i data-feather="archive"></i>
                        <span> Warehouse Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.warehouse','add.warehouse','edit.warehouse') ? 'show' : '' }}" id="Warehouse">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.warehouse') }}"
                                   class="tp-link {{ request()->routeIs('all.warehouse','add.warehouse','edit.warehouse') ? 'active' : '' }}">
                                    All Warehouse
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Supplier -->
                <li>
                    <a href="#Supplier" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.supplier','add.supplier','edit.supplier') ? '' : 'collapsed' }}">
                        <i data-feather="users"></i>
                        <span> Supplier Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.supplier','add.supplier','edit.supplier') ? 'show' : '' }}" id="Supplier">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.supplier') }}"
                                   class="tp-link {{ request()->routeIs('all.supplier','add.supplier','edit.supplier') ? 'active' : '' }}">
                                    All Supplier
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Customer -->
                <li>
                    <a href="#Customer" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.customer','add.customer','edit.customer') ? '' : 'collapsed' }}">
                        <i data-feather="users"></i>
                        <span> Customer Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.customer','add.customer','edit.customer') ? 'show' : '' }}" id="Customer">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.customer') }}"
                                   class="tp-link {{ request()->routeIs('all.customer','add.customer','edit.customer') ? 'active' : '' }}">
                                    All Customer
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Product -->
                <li>
                    <a href="#Product" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.category','all.product','add.product','edit.product') ? '' : 'collapsed' }}">
                        <i data-feather="shopping-bag"></i>
                        <span> Product Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.category','all.product','add.product','edit.product') ? 'show' : '' }}" id="Product">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.category') }}"
                                   class="tp-link {{ request()->routeIs('all.category') ? 'active' : '' }}">
                                    Category
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.product') }}"
                                   class="tp-link {{ request()->routeIs('all.product','add.product','edit.product') ? 'active' : '' }}">
                                    Product
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Purchase -->
                <li>
                    <a href="#Purchase" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.purchase','add.purchase','edit.purchase','all.return.purchase') ? '' : 'collapsed' }}">
                        <i data-feather="shopping-cart"></i>
                        <span> Purchase Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.purchase','add.purchase','edit.purchase','all.return.purchase') ? 'show' : '' }}" id="Purchase">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.purchase') }}"
                                   class="tp-link {{ request()->routeIs('all.purchase','add.purchase','edit.purchase') ? 'active' : '' }}">
                                    All Purchase
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.return.purchase') }}"
                                   class="tp-link {{ request()->routeIs('all.return.purchase') ? 'active' : '' }}">
                                    Purchase Return
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Sale -->
                <li>
                    <a href="#Sale" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.sale','add.sale','edit.sale','all.sale.return') ? '' : 'collapsed' }}">
                        <i data-feather="dollar-sign"></i>
                        <span> Sale Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.sale','add.sale','edit.sale','all.sale.return') ? 'show' : '' }}" id="Sale">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.sale') }}"
                                   class="tp-link {{ request()->routeIs('all.sale','add.sale','edit.sale') ? 'active' : '' }}">
                                    All Sale
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.sale.return') }}"
                                   class="tp-link {{ request()->routeIs('all.sale.return') ? 'active' : '' }}">
                                    Sale Return
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Due -->
                <li>
                    <a href="#Due" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('due.sale','due.sale.return') ? '' : 'collapsed' }}">
                        <i data-feather="alert-octagon"></i>
                        <span> Due Setup </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('due.sale','due.sale.return') ? 'show' : '' }}" id="Due">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('due.sale') }}"
                                   class="tp-link {{ request()->routeIs('due.sale') ? 'active' : '' }}">
                                    Sales Due
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('due.sale.return') }}"
                                   class="tp-link {{ request()->routeIs('due.sale.return') ? 'active' : '' }}">
                                    Sales Return Due
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Transfers -->
                <li>
                    <a href="#Transfers" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.transfer','add.transfer','edit.transfer') ? '' : 'collapsed' }}">
                        <i data-feather="repeat"></i>
                        <span> Transfers Setup </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.transfer','add.transfer','edit.transfer') ? 'show' : '' }}" id="Transfers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.transfer') }}"
                                   class="tp-link {{ request()->routeIs('all.transfer','add.transfer','edit.transfer') ? 'active' : '' }}">
                                    Transfers
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Report -->
                <li>
                    <a href="#Report" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.report') ? '' : 'collapsed' }}">
                        <i data-feather="bar-chart"></i>
                        <span> Report Setup </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.report') ? 'show' : '' }}" id="Report">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.report') }}"
                                   class="tp-link {{ request()->routeIs('all.report') ? 'active' : '' }}">
                                    All Reports
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>

    </div>
</div>