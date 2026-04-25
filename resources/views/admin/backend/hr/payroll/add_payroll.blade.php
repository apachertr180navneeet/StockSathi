@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Create Payroll Record</h4>

                        <form action="{{ route('store.payroll') }}" method="POST" id="payrollForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="employee_id" class="col-sm-2 col-form-label">Employee</label>
                                <div class="col-sm-10">
                                    <select name="employee_id" id="employee_id" class="form-select" required>
                                        <option value="" selected disabled>Select Employee</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}" data-salary="{{ $emp->base_salary }}">
                                                {{ $emp->first_name }} {{ $emp->last_name }} (Base: {{ $emp->base_salary }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="month" class="col-sm-2 col-form-label">Month / Year</label>
                                <div class="col-sm-5">
                                    <select name="month" class="form-select" required>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <select name="year" class="form-select" required>
                                        @for($y = date('Y'); $y >= 2024; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="basic_salary" class="col-sm-2 col-form-label">Basic Salary</label>
                                <div class="col-sm-10">
                                    <input name="basic_salary" class="form-control" type="number" step="0.01" id="basic_salary" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="allowances" class="col-sm-2 col-form-label">Allowances</label>
                                <div class="col-sm-10">
                                    <input name="allowances" class="form-control" type="number" step="0.01" id="allowances" value="0">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="deductions" class="col-sm-2 col-form-label">Deductions</label>
                                <div class="col-sm-10">
                                    <input name="deductions" class="form-control" type="number" step="0.01" id="deductions" value="0">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="payment_status" class="col-sm-2 col-form-label">Payment Status</label>
                                <div class="col-sm-10">
                                    <select name="payment_status" class="form-select">
                                        <option value="Pending">Pending</option>
                                        <option value="Paid">Paid</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="payment_date" class="col-sm-2 col-form-label">Payment Date</label>
                                <div class="col-sm-10">
                                    <input name="payment_date" class="form-control" type="date">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="payment_method" class="col-sm-2 col-form-label">Payment Method</label>
                                <div class="col-sm-10">
                                    <input name="payment_method" class="form-control" type="text" placeholder="Cash, Bank Transfer, etc.">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info" value="Save Payroll">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#employee_id').change(function() {
            let salary = $(this).find(':selected').data('salary');
            $('#basic_salary').val(salary);
        });
    });
</script>
@endsection
