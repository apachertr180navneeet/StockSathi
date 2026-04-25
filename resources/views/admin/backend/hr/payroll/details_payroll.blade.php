@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Payroll Details - {{ date('F', mktime(0, 0, 0, $payroll->month, 1)) }} {{ $payroll->year }}</h5>
                        <button class="btn btn-light btn-sm" onclick="window.print()"><i class="ri-printer-line"></i> Print</button>
                    </div>
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h3 class="fw-bold">Stocksathi Inventory System</h3>
                            <p class="text-muted">Salary Slip</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <p class="mb-1"><strong>Employee Name:</strong> {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</p>
                                <p class="mb-1"><strong>Employee ID:</strong> {{ $payroll->employee->employee_id }}</p>
                                <p class="mb-1"><strong>Designation:</strong> {{ $payroll->employee->designation->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-1"><strong>Department:</strong> {{ $payroll->employee->department->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Date Generated:</strong> {{ $payroll->created_at->format('d M, Y') }}</p>
                                <p class="mb-1"><strong>Payment Status:</strong> {{ $payroll->payment_status }}</p>
                            </div>
                        </div>

                        <table class="table table-bordered mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td class="text-end">{{ number_format($payroll->basic_salary, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Allowances (+)</td>
                                    <td class="text-end text-success">{{ number_format($payroll->allowances, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Deductions (-)</td>
                                    <td class="text-end text-danger">{{ number_format($payroll->deductions, 2) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-dark">
                                    <th class="fs-18">Net Salary</th>
                                    <th class="text-end fs-18">{{ number_format($payroll->net_salary, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="row mt-5">
                            <div class="col-6">
                                <p class="mb-0 border-top pt-2 text-center" style="width: 150px">Employee Signature</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-0 border-top pt-2 text-center d-inline-block" style="width: 150px">Manager Signature</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
@media print {
    .btn, .app-header, .app-sidebar-menu, .footer {
        display: none !important;
    }
    .content {
        margin: 0 !important;
        padding: 0 !important;
    }
}
</style>
@endsection
