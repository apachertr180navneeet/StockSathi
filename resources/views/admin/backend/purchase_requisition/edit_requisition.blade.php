@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Edit Purchase Requisition: {{ $editData->requisition_no }}</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.purchase.requisition') }}">Back</a></div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('update.purchase.requisition', $editData->id) }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Date: <span class="text-danger">*</span></label>
                                    <input type="date" name="date" value="{{ $editData->date }}" class="form-control">
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Warehouse:</label>
                                        <select name="warehouse_id" id="warehouse_id" class="form-control form-select">
                                            <option value="">Select Warehouse</option>
                                            @foreach ($warehouses as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $editData->warehouse_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Supplier:</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control form-select">
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $editData->supplier_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Status:</label>
                                        <select name="status" class="form-control form-select">
                                            <option value="Pending" {{ $editData->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Approved" {{ $editData->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Cancelled" {{ $editData->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Search Product:</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" id="product_search_req" class="form-control" placeholder="Search by name or code...">
                                    </div>
                                    <div id="product_list_req" class="list-group mt-2" style="position: absolute; z-index: 1000; width: 95%;"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Requisition Items:</label>
                                    <table class="table table-bordered" id="requisition_table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Estimated Cost</th>
                                                <th width="150">Quantity</th>
                                                <th>Subtotal</th>
                                                <th width="50">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="requisition_items_body">
                                            @foreach($editData->requisitionItems as $item)
                                            <tr id="row_{{ $item->product_id }}">
                                                <td>{{ $item->product->code }} - {{ $item->product->name }}</td>
                                                <td>
                                                    <input type="number" step="0.01" name="products[{{ $item->product_id }}][unit_cost]" class="form-control unit-cost" value="{{ $item->estimated_cost }}">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" name="products[{{ $item->product_id }}][quantity]" class="form-control quantity" value="{{ $item->quantity }}">
                                                </td>
                                                <td class="row-subtotal">{{ number_format($item->subtotal, 2, '.', '') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Total Amount</th>
                                                <th>
                                                    <span id="total_amount_display">{{ number_format($editData->total_amount, 2, '.', '') }}</span>
                                                    <input type="hidden" name="total_amount" id="total_amount_input" value="{{ $editData->total_amount }}">
                                                </th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="form-label">Notes:</label>
                                    <textarea name="note" class="form-control" rows="3">{{ $editData->note }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex mt-4 justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">Update Requisition</button>
                                <a href="{{ route('all.purchase.requisition') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const productSearchInput = $('#product_search_req');
        const productList = $('#product_list_req');
        const itemsBody = $('#requisition_items_body');
        const totalDisplay = $('#total_amount_display');
        const totalInput = $('#total_amount_input');

        productSearchInput.on('keyup', function() {
            let query = $(this).val();
            let warehouse_id = $('#warehouse_id').val();

            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('purchase.product.search') }}",
                    type: "GET",
                    data: { query: query, warehouse_id: warehouse_id },
                    success: function(data) {
                        productList.empty();
                        if (data.length > 0) {
                            data.forEach(product => {
                                productList.append(`
                                    <a href="#" class="list-group-item list-group-item-action product-select" 
                                       data-id="${product.id}" 
                                       data-name="${product.name}" 
                                       data-code="${product.code}" 
                                       data-price="${product.price}">
                                        ${product.code} - ${product.name} (₹${product.price})
                                    </a>
                                `);
                            });
                        } else {
                            productList.append('<div class="list-group-item">No products found</div>');
                        }
                    }
                });
            } else {
                productList.empty();
            }
        });

        $(document).on('click', '.product-select', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data('name');
            let code = $(this).data('code');
            let price = $(this).data('price');

            if ($(`#row_${id}`).length > 0) {
                alert('Product already added');
                return;
            }

            let row = `
                <tr id="row_${id}">
                    <td>${code} - ${name}</td>
                    <td>
                        <input type="number" step="0.01" name="products[${id}][unit_cost]" class="form-control unit-cost" value="${price}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="products[${id}][quantity]" class="form-control quantity" value="1">
                    </td>
                    <td class="row-subtotal">${price}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;

            itemsBody.append(row);
            productList.empty();
            productSearchInput.val('');
            calculateTotal();
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            calculateTotal();
        });

        $(document).on('input', '.unit-cost, .quantity', function() {
            let row = $(this).closest('tr');
            let cost = parseFloat(row.find('.unit-cost').val()) || 0;
            let qty = parseFloat(row.find('.quantity').val()) || 0;
            let subtotal = cost * qty;
            row.find('.row-subtotal').text(subtotal.toFixed(2));
            calculateTotal();
        });

        function calculateTotal() {
            let total = 0;
            $('.row-subtotal').each(function() {
                total += parseFloat($(this).text()) || 0;
            });
            totalDisplay.text(total.toFixed(2));
            totalInput.val(total.toFixed(2));
        }
    });
</script>
@endsection
