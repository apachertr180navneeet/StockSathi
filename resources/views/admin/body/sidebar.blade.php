<style>
    .logo-lg {
        font-size: 20px;
        letter-spacing: 1px;
    }

    .logo-sm {
        font-size: 16px;
    }
</style>

<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <div id="sidebar-menu">

            <div class="logo-box">

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm fw-bold text-white">SS</span>
                    <span class="logo-lg fw-bold text-white">Stocksathi</span>
                </a>

                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm fw-bold text-dark">SS</span>
                    <span class="logo-lg fw-bold text-dark">Stocksathi</span>
                </a>

            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">Pages</li>

                <!-- Brand -->
                <li>
                    <a href="#sidebarAuth" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Brand Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuth">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.brand') }}" class="tp-link">All Brand</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Warehouse -->
                <li>
                    <a href="#WareHouse" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> WareHouse Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="WareHouse">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.warehouse') }}" class="tp-link">All WareHouse</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Supplier -->
                <li>
                    <a href="#Supplier" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Supplier Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Supplier">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.supplier') }}" class="tp-link">All Supplier</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Customer -->
                <li>
                    <a href="#Customer" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Customer Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Customer">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.customer') }}" class="tp-link">All Customer</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Product -->
                <li>
                    <a href="#Product" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Product Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Product">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.category') }}" class="tp-link">All Category</a>
                            </li>
                            <li>
                                <a href="{{ route('all.product') }}" class="tp-link">All Product</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Purchase -->
                <li>
                    <a href="#Purchase" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Purchase Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Purchase">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.purchase') }}" class="tp-link">All Purchase</a>
                            </li>
                            <li>
                                <a href="{{ route('all.return.purchase') }}" class="tp-link">Purchase Return</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Sale -->
                <li>
                    <a href="#Sale" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Sale Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Sale">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.sale') }}" class="tp-link">All Sale</a>
                            </li>
                            <li>
                                <a href="{{ route('all.sale.return') }}" class="tp-link">Sale Return</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Due -->
                <li>
                    <a href="#Due" data-bs-toggle="collapse">
                        <i data-feather="alert-octagon"></i>
                        <span> Due Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Due">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('due.sale') }}" class="tp-link">Sales Due</a>
                            </li>
                            <li>
                                <a href="{{ route('due.sale.return') }}" class="tp-link">Sales Return Due</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Transfers -->
                <li>
                    <a href="#Transfers" data-bs-toggle="collapse">
                        <i data-feather="alert-octagon"></i>
                        <span> Transfers Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Transfers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.transfer') }}" class="tp-link">Transfers</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Report -->
                <li>
                    <a href="#Report" data-bs-toggle="collapse">
                        <i data-feather="alert-octagon"></i>
                        <span> Report Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Report">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.report') }}" class="tp-link">All Reports</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">General</li>

                <!-- Role Permission -->
                <li>
                    <a href="#RolePermission" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Role & Permission </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="RolePermission">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('all.permission') }}" class="tp-link">All Permission</a></li>
                            <li><a href="{{ route('all.roles') }}" class="tp-link">All Roles</a></li>
                            <li><a href="{{ route('add.roles.permission') }}" class="tp-link">Role In Permission</a></li>
                            <li><a href="{{ route('all.roles.permission') }}" class="tp-link">All Role Permission</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Admin -->
                <li>
                    <a href="#Admin" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Manage Admin </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Admin">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.admin') }}" class="tp-link">All Admin</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>

        <div class="clearfix"></div>

    </div>
</div>