@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Add Stock Adjustment</h4>
            <a href="{{ route('all.stock.adjustment') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('store.stock.adjustment') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                            <select name="warehouse_id" class="form-select" required>
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="Addition">Addition (+)</option>
                                <option value="Deduction">Deduction (-)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Reason</label>
                            <textarea name="reason" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label">Search Product</label>
                            <select id="product_selector" class="form-select select2">
                                <option value="">Search by Name or Code</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-code="{{ $product->code }}" data-qty="{{ $product->product_qty }}">
                                        {{ $product->name }} ({{ $product->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="adjustment_table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Current Stock</th>
                                    <th>Adjustment Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamic Rows -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Save Adjustment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#product_selector').on('change', function() {
            var productId = $(this).val();
            if (!productId) return;

            var productName = $(this).find(':selected').data('name');
            var productCode = $(this).find(':selected').data('code');
            var currentQty = $(this).find(':selected').data('qty');

            // Check if product already added
            if ($('#product_row_' + productId).length > 0) {
                alert('Product already added');
                $(this).val('').trigger('change');
                return;
            }

            var html = '<tr id="product_row_' + productId + '">' +
                '<td>' + productName + ' (' + productCode + ')<input type="hidden" name="product_id[]" value="' + productId + '"></td>' +
                '<td>' + currentQty + '</td>' +
                '<td><input type="number" name="qty[]" class="form-control" min="0.01" step="0.01" value="1" required></td>' +
                '<td><button type="button" class="btn btn-danger btn-sm remove_row">Remove</button></td>' +
                '</tr>';

            $('#adjustment_table tbody').append(html);
            $(this).val('').trigger('change');
        });

        $(document).on('click', '.remove_row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
@endsection
