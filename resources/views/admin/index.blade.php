@extends('admin.admin_master')

@section('admin')

<style>

/* ===== BODY ===== */
body {
    background: #f1f5f9;
}

/* ===== CONTAINER ===== */
.container-xxl {
    padding-top: 10px;
}

/* ===== HEADER ===== */
.dashboard-header {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #fff;
    padding: 22px;
    border-radius: 18px;
    margin-bottom: 50px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    position: sticky;
    top: 10px;
    z-index: 99;
}

/* ===== CARD ===== */
.inv-card {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: 0.3s;
    border-top: 4px solid;
}

.inv-card:hover {
    transform: translateY(-5px) scale(1.02);
}

.inv-card:active {
    transform: scale(0.97);
}

/* COLORS */
.blue { border-color:#3b82f6; }
.green { border-color:#22c55e; }
.orange { border-color:#f59e0b; }
.red { border-color:#ef4444; }
.purple { border-color:#8b5cf6; }

/* TEXT */
.card-title { font-size:13px; color:#6b7280; }
.card-value { font-size:26px; font-weight:700; }
.card-sub { font-size:12px; color:#9ca3af; }

/* CHART */
#chart { min-height:320px; }

/* ===== MOBILE ===== */
@media (max-width: 768px) {

    .content {
        padding: 8px;
    }

    /* Header */
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
        padding: 18px;
    }

    .dashboard-header h2 {
        font-size: 18px;
    }

    .dashboard-header p {
        font-size: 12px;
    }

    .dashboard-header .badge {
        font-size: 10px;
        padding: 4px 10px;
    }

    /* ===== CARD SLIDER (CENTER FIX) ===== */
    .row.g-4 {
        display: flex;
        overflow-x: auto;
        gap: 14px;
        padding: 10px 15px;
        scroll-snap-type: x mandatory;
        justify-content: center;
    }

    .row.g-4::-webkit-scrollbar {
        display: none;
    }

    .col-md-6,
    .col-xl-3 {
        flex: 0 0 85%;
        max-width: 85%;
        margin: 0 auto;
        scroll-snap-align: center;
    }

    .inv-card {
        padding: 16px;
    }

    .card-value {
        font-size: 22px;
    }

    /* Chart */
    #chart {
        height: 240px !important;
    }
}

/* ANIMATION */
.inv-card {
    animation: fadeInUp 0.6s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>

<div class="content">
<div class="container-xxl">

@php
$hour = now()->format('H');
$greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
@endphp

<!-- HEADER -->
<div class="dashboard-header d-flex justify-content-between align-items-start flex-wrap">
    <div>
        <h2>📦 Inventory Dashboard</h2>
        <p class="mb-0 text-light opacity-75">
            {{ $greeting }}, <strong>{{ auth()->user()->name ?? 'User' }}</strong> 👋
            <br>
            <small>Here’s what’s happening in your business today</small>
        </p>
    </div>

    <span class="badge bg-light text-dark">
        {{ now()->format('l, d M Y') }}
    </span>
</div>

<!-- ROW 1 -->
<div class="row g-4 mt-3">

    <div class="col-md-6 col-xl-3">
        <div class="inv-card blue">
            <div class="card-title">Total Products</div>
            <div class="card-value">245</div>
            <div class="card-sub">All inventory items</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="inv-card green">
            <div class="card-title">Available Stock</div>
            <div class="card-value">5,420</div>
            <div class="card-sub">Units in warehouse</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="inv-card orange">
            <div class="card-title">Low Stock</div>
            <div class="card-value">18</div>
            <div class="card-sub">Need restock</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="inv-card red">
            <div class="card-title">Out of Stock</div>
            <div class="card-value">7</div>
            <div class="card-sub">Unavailable items</div>
        </div>
    </div>

</div>

<!-- ROW 2 -->
<div class="row g-4 mt-3">

    <div class="col-md-6 col-xl-3">
        <div class="inv-card purple">
            <div class="card-title">Total Orders</div>
            <div class="card-value">1,320</div>
            <div class="card-sub">All orders</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="inv-card green">
            <div class="card-title">Today's Sales</div>
            <div class="card-value">₹ 12,450</div>
            <div class="card-sub">Revenue today</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="inv-card blue">
            <div class="card-title">Customers</div>
            <div class="card-value">560</div>
            <div class="card-sub">Active buyers</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="inv-card orange">
            <div class="card-title">Suppliers</div>
            <div class="card-value">32</div>
            <div class="card-sub">Vendors</div>
        </div>
    </div>

</div>

<!-- CHART -->
<div class="row mt-4">
    <div class="col-12">
        <div class="inv-card">
            <h5>📊 Sales Overview</h5>
            <div id="chart"></div>
        </div>
    </div>
</div>

</div>
</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
window.onload = function () {

    var chartEl = document.querySelector("#chart");
    if (!chartEl) return;

    var options = {
        chart: {
            type: 'area',
            height: 320
        },
        series: [{
            name: 'Sales',
            data: [10, 40, 30, 60, 50, 80, 70]
        }],
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul']
        },
        stroke: {
            curve: 'smooth'
        }
    };

    new ApexCharts(chartEl, options).render();
};
</script>

@endsection