@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Record Expense</h4>
            <a href="{{ route('all.expense') }}" class="btn btn-secondary btn-sm">
                Back
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('store.expense') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expense Date <span class="text-danger">*</span></label>
                            <input type="date" name="expense_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expense No <span class="text-danger">*</span></label>
                            <input type="text" name="expense_no" class="form-control" value="{{ $expenseNo }}" readonly required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expense Category <span class="text-danger">*</span></label>
                            <select name="account_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($expenseAccounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Method (Asset Account) <span class="text-danger">*</span></label>
                            <select name="payment_account_id" class="form-control" required>
                                <option value="">Select Account</option>
                                @foreach($paymentAccounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} ({{ $acc->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reference No</label>
                            <input type="text" name="reference_no" class="form-control" placeholder="Check no, Transaction ID, etc.">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Additional details..."></textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
