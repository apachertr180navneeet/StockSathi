@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Record Vendor Payment</h3>
                    <div class="text-end my-2 mt-md-0">
                        <a class="btn btn-outline-primary" href="{{ route('all.vendor.payment') }}">Back</a>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <form action="{{ route('store.vendor.payment') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Purchase Invoice: (Optional)</label>
                                    <select name="purchase_id" id="purchase_id" class="form-control form-select">
                                        <option value="">General Payment (Not linked to invoice)</option>
                                        @foreach ($purchases as $item)
                                            <option value="{{ $item->id }}" 
                                                data-supplier="{{ $item->supplier_id }}"
                                                data-due="{{ $item->due_amount }}"
                                                {{ (isset($selected_purchase) && $selected_purchase->id == $item->id) ? 'selected' : '' }}>
                                                Invoice #{{ $item->id }} - Due: ₹{{ number_format($item->due_amount, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Supplier: <span class="text-danger">*</span></label>
                                    <select name="supplier_id" id="supplier_id" class="form-control form-select">
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ (isset($selected_purchase) && $selected_purchase->supplier_id == $item->id) ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Amount: <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" name="amount" id="amount" 
                                            class="form-control" value="{{ old('amount', isset($selected_purchase) ? $selected_purchase->due_amount : '') }}" required>
                                    </div>
                                    @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Payment Date: <span class="text-danger">*</span></label>
                                    <input type="date" name="payment_date" class="form-control" 
                                        value="{{ date('Y-m-d') }}" required>
                                    @error('payment_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Payment Method: <span class="text-danger">*</span></label>
                                    <select name="payment_method" class="form-control form-select" required>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="UPI">UPI</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Reference No: (Cheque #, Trans ID, etc.)</label>
                                    <input type="text" name="reference_no" class="form-control" 
                                        placeholder="Enter reference number">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Note:</label>
                                    <textarea name="note" class="form-control" rows="1" placeholder="Optional notes"></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary me-2">Save Payment</button>
                                <a href="{{ route('all.vendor.payment') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#purchase_id').change(function() {
                var selected = $(this).find('option:selected');
                var supplier_id = selected.data('supplier');
                var due_amount = selected.data('due');

                if (supplier_id) {
                    $('#supplier_id').val(supplier_id);
                    $('#amount').val(due_amount);
                } else {
                    $('#supplier_id').val('');
                    $('#amount').val('');
                }
            });
        });
    </script>
@endsection
