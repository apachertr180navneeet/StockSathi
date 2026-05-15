@extends('admin.admin_master')

@section('title', 'Dashboard | StockSathi')

@section('admin')

<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">Dashboard</h6>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Welcome to Inventory Dashboard</li>
            </ol>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <span class="badge bg-primary">{{ now()->format('l, d M Y') }}</span>
            </div>
        </div>
    </div>
</div>

@php
$hour = now()->format('H');
$greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
@endphp

<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary bg-soft">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">{{ $greeting }}, <strong>{{ auth()->user()->name ?? 'User' }}</strong></h4>
                        <p class="mb-0 text-muted">Here's what's happening in your business today</p>
                    </div>
                    <span class="badge bg-primary font-size-12">{{ now()->format('l, d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary rounded-circle">
                                <i class="bx bx-package font-size-22"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-muted mb-1">Total Products</p>
                        <h5 class="mb-0">{{ number_format($totalProducts) }}</h5>
                        <small class="text-muted">All inventory items</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success rounded-circle">
                                <i class="bx bx-check-circle font-size-22"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-muted mb-1">Available Stock</p>
                        <h5 class="mb-0">{{ number_format($availableStock) }}</h5>
                        <small class="text-muted">Units in warehouse</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning rounded-circle">
                                <i class="bx bx-error-circle font-size-22"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-muted mb-1">Low Stock</p>
                        <h5 class="mb-0">{{ $lowStock }}</h5>
                        <small class="text-muted">Need restock</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-danger rounded-circle">
                                <i class="bx bx-x-circle font-size-22"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-muted mb-1">Out of Stock</p>
                        <h5 class="mb-0">{{ $outOfStock }}</h5>
                        <small class="text-muted">Unavailable items</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-info rounded-circle">
                                <i class="bx bx-cart font-size-22"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-muted mb-1">Total Orders</p>
                        <h5 class="mb-0">{{ number_format($totalOrders) }}</h5>
                        <small class="text-muted">All orders</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success rounded-circle">
                                <i class="bx bx-dollar font-size-22"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-muted mb-1">Today's Sales</p>
                        <h5 class="mb-0">&#8377; {{ number_format($todaySales, 2) }}</h5>
                        <small class="text-muted">Revenue today</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary rounded-circle">
                                <i class="bx bx-user font-size-22"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-muted mb-1">Customers</p>
                        <h5 class="mb-0">{{ number_format($totalCustomers) }}</h5>
                        <small class="text-muted">Active buyers</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning rounded-circle">
                                <i class="bx bx-group font-size-22"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-muted mb-1">Suppliers</p>
                        <h5 class="mb-0">{{ number_format($totalSuppliers) }}</h5>
                        <small class="text-muted">Vendors</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Sales Overview</h4>
                <div id="chart" class="apex-charts"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var chartEl = document.querySelector("#chart");
    if (!chartEl) return;
    var options = {
        chart: { type: 'area', height: 320, toolbar: { show: false } },
        series: [{ name: 'Sales', data: @json($salesData) }],
        xaxis: { categories: @json($months) },
        stroke: { curve: 'smooth', width: 2 },
        colors: ['#556ee6'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1 } },
        dataLabels: { enabled: false },
        grid: { borderColor: '#f1f1f1' }
    };
    new ApexCharts(chartEl, options).render();
});
</script>
@endsection
