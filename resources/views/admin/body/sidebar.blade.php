<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">Pages</li>

                @can('pos.all')
                <li>
                    <a href="{{ route('pos.index') }}" class="waves-effect">
                        <i class="bx bx-cart"></i>
                        <span>POS</span>
                    </a>
                </li>
                @endcan

                @can('brand.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-box"></i>
                        <span>Brand Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.brand') }}">All Brand</a></li>
                    </ul>
                </li>
                @endcan

                @can('warehouse.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-archive"></i>
                        <span>Warehouse Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.warehouse') }}">All Warehouse</a></li>
                    </ul>
                </li>
                @endcan

                @can('supplier.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-group"></i>
                        <span>Supplier Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.supplier') }}">All Supplier</a></li>
                    </ul>
                </li>
                @endcan

                @can('customer.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user"></i>
                        <span>Customer Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.customer') }}">All Customer</a></li>
                    </ul>
                </li>
                @endcan

                @can('product.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-shopping-bag"></i>
                        <span>Product Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.category') }}">Category</a></li>
                        <li><a href="{{ route('all.product') }}">Product</a></li>
                    </ul>
                </li>
                @endcan

                @can('purchase.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cart-alt"></i>
                        <span>Purchase Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.purchase.requisition') }}">Purchase Requisition</a></li>
                        <li><a href="{{ route('all.purchase.order') }}">Purchase Orders</a></li>
                        <li><a href="{{ route('all.purchase') }}">All Purchase</a></li>
                        <li><a href="{{ route('all.vendor.payment') }}">Vendor Payments</a></li>
                        <li><a href="{{ route('all.return.purchase') }}">Purchase Return</a></li>
                    </ul>
                </li>
                @endcan

                @can('sale.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-dollar"></i>
                        <span>Sale Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.sales.order') }}">Sales Orders</a></li>
                        <li><a href="{{ route('all.quotation') }}">Quotations</a></li>
                        <li><a href="{{ route('all.sale') }}">All Sale</a></li>
                        <li><a href="{{ route('all.sale.return') }}">Sale Return</a></li>
                    </ul>
                </li>
                @endcan

                @can('sale.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-alarm-exclamation"></i>
                        <span>Due Setup</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('due.sale') }}">Sales Due</a></li>
                        <li><a href="{{ route('due.sale.return') }}">Sales Return Due</a></li>
                    </ul>
                </li>
                @endcan

                @can('transfer.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-transfer"></i>
                        <span>Transfers Setup</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.transfer') }}">Transfers</a></li>
                    </ul>
                </li>
                @endcan

                @can('financial.report.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-bar-chart"></i>
                        <span>Report Setup</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.report') }}">All Reports</a></li>
                    </ul>
                </li>
                @endcan

                <li class="menu-title">Inventory & Logistics</li>

                @can('stock.adjustment.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-slider"></i>
                        <span>Stock Adjustment</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.stock.adjustment') }}">All Adjustments</a></li>
                        <li><a href="{{ route('add.stock.adjustment') }}">Add Adjustment</a></li>
                    </ul>
                </li>
                @endcan

                @can('batch.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layer"></i>
                        <span>Batch / Lot</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.batch') }}">All Batches</a></li>
                        <li><a href="{{ route('add.batch') }}">Add Batch</a></li>
                    </ul>
                </li>
                @endcan

                @can('bin.rack.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-grid-alt"></i>
                        <span>Bin / Rack</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.rack') }}">Rack Management</a></li>
                        <li><a href="{{ route('all.bin') }}">Bin Management</a></li>
                    </ul>
                </li>
                @endcan

                @can('delivery.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-package"></i>
                        <span>Delivery Tracking</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.delivery') }}">All Deliveries</a></li>
                        <li><a href="{{ route('create.delivery') }}">Create Delivery</a></li>
                    </ul>
                </li>
                @endcan

                <li class="menu-title">HR Management</li>

                @can('hr.menu')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase"></i>
                        <span>HR Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.department') }}">Department</a></li>
                        <li><a href="{{ route('all.designation') }}">Designation</a></li>
                        <li><a href="{{ route('all.employee') }}">Employee</a></li>
                        <li><a href="{{ route('all.attendance') }}">Attendance</a></li>
                        <li><a href="{{ route('all.payroll') }}">Payroll</a></li>
                    </ul>
                </li>
                @endcan

                <li class="menu-title">Accounting</li>

                @can('account.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-book"></i>
                        <span>Accounting Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.account') }}">Chart of Accounts</a></li>
                        <li><a href="{{ route('all.tax') }}">Tax Setup</a></li>
                        <li><a href="{{ route('all.expense') }}">Expenses</a></li>
                        <li><a href="{{ route('report.profit.loss') }}">Profit & Loss</a></li>
                        <li><a href="{{ route('report.ledger') }}">Ledger Report</a></li>
                    </ul>
                </li>
                @endcan

                <li class="menu-title">Role & Permission</li>

                @can('role.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-shield"></i>
                        <span>Role & Permission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.permission') }}">All Permission</a></li>
                        <li><a href="{{ route('all.roles') }}">All Roles</a></li>
                        <li><a href="{{ route('add.roles.permission') }}">Roles in Permission</a></li>
                        <li><a href="{{ route('all.roles.permission') }}">All Roles in Permission</a></li>
                    </ul>
                </li>
                @endcan

                @can('admin.all')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user-pin"></i>
                        <span>Admin Manage</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('all.admin') }}">All Admin</a></li>
                        <li><a href="{{ route('add.admin') }}">Add Admin</a></li>
                    </ul>
                </li>
                @endcan

            </ul>
        </div>
    </div>
</div>
