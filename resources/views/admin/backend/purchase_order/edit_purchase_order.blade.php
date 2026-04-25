@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="content">
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Purchase Order: {{ $editData->po_no }}</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('all.purchase.order') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('update.purchase.order', $editData->id) }}" method="post" id="po_form">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ $editData->date }}" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Supplier <span class="text-danger">*</span></label>
                                    <select name="supplier_id" id="supplier_id" class="form-control form-select" required>
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $sup)
                                            <option value="{{ $sup->id }}" {{ $editData->supplier_id == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                                    <select name="warehouse_id" id="warehouse_id" class="form-control form-select" required>
                                        <option value="">Select Warehouse</option>
                                        @foreach($warehouses as $wh)
                                            <option value="{{ $wh->id }}" {{ $editData->warehouse_id == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control form-select">
                                        <option value="Draft" {{ $editData->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Ordered" {{ $editData->status == 'Ordered' ? 'selected' : '' }}>Ordered</option>
                                        <option value="Received" {{ $editData->status == 'Received' ? 'selected' : '' }}>Received</option>
                                        <option value="Cancelled" {{ $editData->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Search Product</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" id="product_search" class="form-control" placeholder="Search by name or code...">
                                    </div>
                                    <div id="product_list" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
                                </div>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered" id="po_items_table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Product</th>
                                            <th width="150">Unit Cost</th>
                                            <th width="120">Quantity</th>
                                            <th width="120">Tax (%)</th>
                                            <th width="120">Discount</th>
                                            <th width="150">Subtotal</th>
                                            <th width="50">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($editData->items as $item)
                                            <tr data-id="{{ $item->product_id }}">
                                                <td>
                                                    {{ $item->product->name }} ({{ $item->product->product_code }})
                                                    <input type="hidden" name="products[{{ $item->product_id }}][product_id]" value="{{ $item->product_id }}">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" name="products[{{ $item->product_id }}][unit_cost]" class="form-control unit_cost" value="{{ $item->unit_cost }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="products[{{ $item->product_id }}][quantity]" class="form-control quantity" value="{{ $item->quantity }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" name="products[{{ $item->product_id }}][tax_rate]" class="form-control tax_rate" value="{{ $item->tax_rate }}">
                                                    <input type="hidden" name="products[{{ $item->product_id }}][tax_amount]" class="tax_amount" value="{{ $item->tax_amount }}">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" name="products[{{ $item->product_id }}][discount]" class="form-control discount" value="{{ $item->discount }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="products[{{ $item->product_id }}][subtotal]" class="form-control subtotal" value="{{ $item->subtotal }}" readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove_row"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-end">Total</th>
                                            <th id="total_display">₹{{ number_format($editData->grand_total + $editData->discount - $editData->shipping - $editData->tax_amount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Note</label>
                                        <textarea name="note" class="form-control" rows="4">{{ $editData->note }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>Order Tax (%)</th>
                                            <td><input type="number" step="0.01" name="tax_rate" id="order_tax_rate" class="form-control text-end" value="{{ $editData->tax_rate }}"></td>
                                        </tr>
                                        <tr>
                                            <th>Order Discount</th>
                                            <td><input type="number" step="0.01" name="discount" id="order_discount" class="form-control text-end" value="{{ $editData->discount }}"></td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td><input type="number" step="0.01" name="shipping" id="order_shipping" class="form-control text-end" value="{{ $editData->shipping }}"></td>
                                        </tr>
                                        <tr class="fs-18 fw-bold">
                                            <th>Grand Total</th>
                                            <td>
                                                <span id="grand_total_display">₹{{ number_format($editData->grand_total, 2) }}</span>
                                                <input type="hidden" name="grand_total" id="grand_total_input" value="{{ $editData->grand_total }}">
                                                <input type="hidden" name="tax_amount" id="order_tax_amount" value="{{ $editData->tax_amount }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">Update Purchase Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let productSearchUrl = "{{ route('purchase.product.search') }}";

    $('#product_search').on('keyup', function() {
        let query = $(this).val();
        let warehouse_id = $('#warehouse_id').val();
        
        if (!warehouse_id) {
            toastr.warning('Please select warehouse first');
            return;
        }

        if (query.length > 1) {
            $.ajax({
                url: productSearchUrl,
                type: 'GET',
                data: { query: query, warehouse_id: warehouse_id },
                success: function(data) {
                    let html = '';
                    if (data.length > 0) {
                        data.forEach(function(p) {
                            html += `<a href="javascript:void(0)" class="list-group-item list-group-item-action add_product" 
                                        data-id="${p.id}" data-name="${p.name}" data-code="${p.product_code}" data-cost="${p.purchase_price}">
                                        ${p.product_code} - ${p.name}
                                    </a>`;
                        });
                    } else {
                        html = '<div class="list-group-item">No products found</div>';
                    }
                    $('#product_list').html(html).show();
                }
            });
        } else {
            $('#product_list').hide();
        }
    });

    $(document).on('click', '.add_product', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let code = $(this).data('code');
        let cost = $(this).data('cost');

        if ($(`#po_items_table tr[data-id="${id}"]`).length > 0) {
            toastr.warning('Product already added');
            $('#product_list').hide();
            $('#product_search').val('');
            return;
        }

        let html = `
            <tr data-id="${id}">
                <td>
                    ${name} (${code})
                    <input type="hidden" name="products[${id}][product_id]" value="${id}">
                </td>
                <td>
                    <input type="number" step="0.01" name="products[${id}][unit_cost]" class="form-control unit_cost" value="${cost}" required>
                </td>
                <td>
                    <input type="number" name="products[${id}][quantity]" class="form-control quantity" value="1" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="products[${id}][tax_rate]" class="form-control tax_rate" value="0">
                    <input type="hidden" name="products[${id}][tax_amount]" class="tax_amount" value="0">
                </td>
                <td>
                    <input type="number" step="0.01" name="products[${id}][discount]" class="form-control discount" value="0">
                </td>
                <td>
                    <input type="text" name="products[${id}][subtotal]" class="form-control subtotal" value="${cost}" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove_row"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;

        $('#po_items_table tbody').append(html);
        $('#product_list').hide();
        $('#product_search').val('');
        calculateTotal();
    });

    $(document).on('click', '.remove_row', function() {
        $(this).closest('tr').remove();
        calculateTotal();
    });

    $(document).on('input', '.unit_cost, .quantity, .tax_rate, .discount, #order_tax_rate, #order_discount, #order_shipping', function() {
        calculateTotal();
    });

    function calculateTotal() {
        let total = 0;
        $('#po_items_table tbody tr').each(function() {
            let cost = parseFloat($(this).find('.unit_cost').val()) || 0;
            let qty = parseFloat($(this).find('.quantity').val()) || 0;
            let tax_rate = parseFloat($(this).find('.tax_rate').val()) || 0;
            let discount = parseFloat($(this).find('.discount').val()) || 0;

            let row_total = cost * qty;
            let row_tax = (row_total * tax_rate) / 100;
            let subtotal = row_total + row_tax - discount;

            $(this).find('.tax_amount').val(row_tax.toFixed(2));
            $(this).find('.subtotal').val(subtotal.toFixed(2));
            total += subtotal;
        });

        $('#total_display').text('₹' + total.toFixed(2));

        let order_tax_rate = parseFloat($('#order_tax_rate').val()) || 0;
        let order_discount = parseFloat($('#order_discount').val()) || 0;
        let order_shipping = parseFloat($('#order_shipping').val()) || 0;

        let order_tax_amount = (total * order_tax_rate) / 100;
        let grand_total = total + order_tax_amount + order_shipping - order_discount;

        $('#order_tax_amount').val(order_tax_amount.toFixed(2));
        $('#grand_total_display').text('₹' + grand_total.toFixed(2));
        $('#grand_total_input').val(grand_total.toFixed(2));
    }

    // Initial calculation
    calculateTotal();
});
</script>
@endsection
