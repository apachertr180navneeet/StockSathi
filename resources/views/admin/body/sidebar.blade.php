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

                <!-- POS -->
                <li>
                    <a href="{{ route('pos.index') }}"
                       class="tp-link {{ request()->routeIs('pos.index') ? 'active' : '' }}">
                        <i data-feather="monitor"></i>
                        <span> POS </span>
                    </a>
                </li>

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

                    <div class="collapse {{ request()->routeIs('all.purchase','add.purchase','edit.purchase','all.return.purchase','all.purchase.requisition','add.purchase.requisition','edit.purchase.requisition','details.purchase.requisition') ? 'show' : '' }}" id="Purchase">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.purchase.requisition') }}"
                                   class="tp-link {{ request()->routeIs('all.purchase.requisition','add.purchase.requisition','edit.purchase.requisition','details.purchase.requisition') ? 'active' : '' }}">
                                    Purchase Requisition
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.purchase.order') }}"
                                   class="tp-link {{ request()->routeIs('all.purchase.order','add.purchase.order','edit.purchase.order','details.purchase.order') ? 'active' : '' }}">
                                    Purchase Orders
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.purchase') }}"
                                   class="tp-link {{ request()->routeIs('all.purchase','add.purchase','edit.purchase') ? 'active' : '' }}">
                                    All Purchase
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.vendor.payment') }}"
                                   class="tp-link {{ request()->routeIs('all.vendor.payment') ? 'active' : '' }}">
                                    Vendor Payments
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
                       class="{{ request()->routeIs('all.sale','add.sale','edit.sale','all.sale.return','all.quotation','add.quotation','edit.quotation','details.quotation') ? '' : 'collapsed' }}">
                        <i data-feather="dollar-sign"></i>
                        <span> Sale Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.sale','add.sale','edit.sale','all.sale.return','all.quotation','add.quotation','edit.quotation','details.quotation','all.sales.order','add.sales.order','edit.sales.order','details.sales.order') ? 'show' : '' }}" id="Sale">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.sales.order') }}"
                                   class="tp-link {{ request()->routeIs('all.sales.order','add.sales.order','edit.sales.order','details.sales.order') ? 'active' : '' }}">
                                    Sales Orders
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.quotation') }}"
                                   class="tp-link {{ request()->routeIs('all.quotation','add.quotation','edit.quotation','details.quotation') ? 'active' : '' }}">
                                    Quotations
                                </a>
                            </li>
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

                <li>
                    <a href="#Delivery" data-bs-toggle="collapse">
                        <i class="mdi mdi-truck-delivery"></i>
                        <span> Delivery Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('all.delivery','add.delivery','edit.delivery') ? 'show' : '' }}" id="Delivery">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.delivery') }}"
                                   class="tp-link {{ request()->routeIs('all.delivery','add.delivery','edit.delivery') ? 'active' : '' }}">
                                    All Deliveries
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

                <!-- Accounting Manage -->
                <li>
                    <a href="#Accounting" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.account','all.tax','all.expense','report.profit.loss','report.ledger') ? '' : 'collapsed' }}">
                        <i data-feather="book"></i>
                        <span> Accounting Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.account','all.tax','all.expense','report.profit.loss','report.ledger') ? 'show' : '' }}" id="Accounting">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.account') }}"
                                   class="tp-link {{ request()->routeIs('all.account') ? 'active' : '' }}">
                                    Chart of Accounts
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.tax') }}"
                                   class="tp-link {{ request()->routeIs('all.tax') ? 'active' : '' }}">
                                    Tax Setup
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.expense') }}"
                                   class="tp-link {{ request()->routeIs('all.expense') ? 'active' : '' }}">
                                    Expenses
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('report.profit.loss') }}"
                                   class="tp-link {{ request()->routeIs('report.profit.loss') ? 'active' : '' }}">
                                    Profit & Loss
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('report.ledger') }}"
                                   class="tp-link {{ request()->routeIs('report.ledger') ? 'active' : '' }}">
                                    Ledger Report
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Role & Permission -->
                <li class="menu-title">Role & Permission</li>
                <li>
                    <a href="#RolePermission" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.permission','all.roles','add.roles.permission','all.roles.permission') ? '' : 'collapsed' }}">
                        <i data-feather="shield"></i>
                        <span> Role & Permission </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.permission','all.roles','add.roles.permission','all.roles.permission') ? 'show' : '' }}" id="RolePermission">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.permission') }}"
                                   class="tp-link {{ request()->routeIs('all.permission') ? 'active' : '' }}">
                                    All Permission
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.roles') }}"
                                   class="tp-link {{ request()->routeIs('all.roles') ? 'active' : '' }}">
                                    All Roles
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('add.roles.permission') }}"
                                   class="tp-link {{ request()->routeIs('add.roles.permission') ? 'active' : '' }}">
                                    Roles in Permission
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all.roles.permission') }}"
                                   class="tp-link {{ request()->routeIs('all.roles.permission') ? 'active' : '' }}">
                                    All Roles in Permission
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Admin User -->
                <li>
                    <a href="#AdminUser" data-bs-toggle="collapse"
                       class="{{ request()->routeIs('all.admin','add.admin') ? '' : 'collapsed' }}">
                        <i data-feather="users"></i>
                        <span> Admin Manage </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ request()->routeIs('all.admin','add.admin') ? 'show' : '' }}" id="AdminUser">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.admin') }}"
                                   class="tp-link {{ request()->routeIs('all.admin') ? 'active' : '' }}">
                                    All Admin
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('add.admin') }}"
                                   class="tp-link {{ request()->routeIs('add.admin') ? 'active' : '' }}">
                                    Add Admin
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>

    </div>
</div>