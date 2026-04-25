@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Profit & Loss Report</h4>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('report.profit.loss') }}" method="GET" class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3>Profit & Loss Statement</h3>
                    <p class="text-muted">From {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                </div>

                <div class="row">
                    <!-- Revenue Section -->
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2">Revenue</h5>
                        <table class="table table-sm">
                            @foreach($revenueAccounts as $acc)
                            @php
                                $balance = $revenueItems->where('account_id', $acc->id)->sum('credit') - $revenueItems->where('account_id', $acc->id)->sum('debit');
                            @endphp
                            <tr>
                                <td>{{ $acc->name }}</td>
                                <td class="text-end">{{ number_format($balance, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-light fw-bold">
                                <td>Total Revenue</td>
                                <td class="text-end border-top">{{ number_format($totalRevenue, 2) }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Expense Section -->
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2">Expenses</h5>
                        <table class="table table-sm">
                            @foreach($expenseAccounts as $acc)
                            @php
                                $balance = $expenseItems->where('account_id', $acc->id)->sum('debit') - $expenseItems->where('account_id', $acc->id)->sum('credit');
                            @endphp
                            <tr>
                                <td>{{ $acc->name }}</td>
                                <td class="text-end">{{ number_format($balance, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-light fw-bold">
                                <td>Total Expenses</td>
                                <td class="text-end border-top">{{ number_format($totalExpenses, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4 p-3 rounded {{ $netProfit >= 0 ? 'bg-success-light' : 'bg-danger-light' }} text-center">
                    <h4 class="{{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                        Net {{ $netProfit >= 0 ? 'Profit' : 'Loss' }}: {{ number_format($netProfit, 2) }}
                    </h4>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .bg-success-light { background-color: rgba(40, 199, 111, 0.12); }
    .bg-danger-light { background-color: rgba(234, 84, 85, 0.12); }
</style>
@endsection
