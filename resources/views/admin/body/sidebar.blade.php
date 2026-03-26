<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!-- Sidebar -->
        <div id="sidebar-menu">

            <!-- Logo -->
            <div class="logo-box">
                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm fw-bold text-white">
                        SS
                    </span>
                    <span class="logo-lg fw-bold text-white" style="font-size:18px;">
                        StockSathi
                    </span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm fw-bold text-dark">
                        SS
                    </span>
                    <span class="logo-lg fw-bold text-dark" style="font-size:18px;">
                        StockSathi
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <!-- Dashboard -->
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{ route('dashboard') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <!-- Pages -->
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
                        <i data-feather="alert-octagon"></i>
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
                        <i data-feather="file-text"></i>
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
                        <i data-feather="calendar"></i>
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
                        <i data-feather="package"></i>
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
                        <i data-feather="aperture"></i>
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
                        <i data-feather="award"></i>
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
                        <i data-feather="briefcase"></i>
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
                        <i data-feather="table"></i>
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

                <!-- Reports -->
                <li>
                    <a href="#Report" data-bs-toggle="collapse">
                        <i data-feather="pie-chart"></i>
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

                <!-- General -->
                <li class="menu-title mt-2">General</li>

                <!-- Role & Permission -->
                <li>
                    <a href="#sidebarBaseui" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Role & Permission </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseui">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('all.permission') }}" class="tp-link">All Permission</a></li>
                            <li><a href="{{ route('all.roles') }}" class="tp-link">All Roles</a></li>
                            <li><a href="{{ route('add.roles.permission') }}" class="tp-link">Role In Permission</a>
                            </li>
                            <li><a href="{{ route('all.roles.permission') }}" class="tp-link">All Role Permission</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Admin -->
                <li>
                    <a href="#Admin" data-bs-toggle="collapse">
                        <i data-feather="map"></i>
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
