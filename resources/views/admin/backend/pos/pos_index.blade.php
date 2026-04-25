@extends('admin.admin_master')
@section('admin')
<style>
    .pos-layout { display: flex; height: calc(100vh - 100px); overflow: hidden; }
    .pos-left { flex: 7; display: flex; flex-direction: column; padding-right: 15px; border-right: 1px solid #dee2e6; overflow: hidden; }
    .pos-right { flex: 3; display: flex; flex-direction: column; padding-left: 15px; overflow: hidden; background: #fff; }
    .product-grid-container { flex-grow: 1; overflow-y: auto; padding-right: 5px; margin-top: 15px; }
    .cart-container { flex-grow: 1; overflow-y: auto; }
    .cart-table th, .cart-table td { padding: 8px 5px; vertical-align: middle; }
    .cart-totals { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: auto; }
    .product-card:hover { transform: translateY(-3px) !important; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; border-color: #0d6efd !important; }
    
    /* Responsive tweaks */
    @media (max-width: 991.98px) {
        .pos-layout { flex-direction: column; height: auto; overflow: visible; }
        .pos-left, .pos-right { flex: none; width: 100%; border-right: none; padding: 0; }
        .pos-left { margin-bottom: 20px; }
        .product-grid-container { height: 500px; }
    }
</style>

<div class="content">
    <div class="container-fluid py-3">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 fw-bold text-uppercase"><i class="mdi mdi-monitor-dashboard me-1"></i> Point of Sale (POS)</h4>
            <div>
                <span id="clock" class="fw-bold fs-5 text-primary"></span>
            </div>
        </div>

        <div class="pos-layout">
            
            <!-- LEFT SIDE: PRODUCTS -->
            <div class="pos-left">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <select class="form-select form-control" id="pos_category">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                            <input type="text" id="pos_search" class="form-control" placeholder="Search by name or code...">
                        </div>
                    </div>
                </div>

                <div class="product-grid-container">
                    <div class="row" id="product_grid">
                        @include('admin.backend.pos.pos_product_grid')
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: CART -->
            <div class="pos-right">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <select class="form-select form-control" id="pos_customer" required>
                                <option value="">Select Customer (Required)</option>
                                @foreach($customers as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->name }} - {{ $cust->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <select class="form-select form-control" id="pos_warehouse" required>
                                <option value="">Select Warehouse (Required)</option>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="cart-container">
                    <table class="table table-sm cart-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 45%">Item</th>
                                <th style="width: 25%" class="text-center">Qty</th>
                                <th style="width: 20%" class="text-end">Total</th>
                                <th style="width: 10%" class="text-center"><i class="mdi mdi-delete text-danger"></i></th>
                            </tr>
                        </thead>
                        <tbody id="cart_body">
                            <!-- Cart items injected here -->
                        </tbody>
                    </table>
                </div>

                <div class="cart-totals shadow-sm">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Subtotal:</span>
                        <strong id="cart_subtotal">₹0.00</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1 align-items-center">
                        <span>Discount:</span>
                        <input type="number" id="cart_discount" class="form-control form-control-sm text-end" style="width: 100px;" value="0" min="0">
                    </div>
                    <div class="d-flex justify-content-between mb-1 align-items-center">
                        <span>Tax Rate (%):</span>
                        <input type="number" id="cart_tax_rate" class="form-control form-control-sm text-end" style="width: 100px;" value="0" min="0">
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fs-5 fw-bold text-primary">Grand Total:</span>
                        <span class="fs-5 fw-bold text-primary" id="cart_grand_total">₹0.00</span>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label mb-0 fs-12">Paid Amount</label>
                            <input type="number" id="cart_paid" class="form-control text-success fw-bold" value="0" min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label mb-0 fs-12">Payment Method</label>
                            <select id="cart_payment_method" class="form-select">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-danger fw-bold">Due Amount:</span>
                        <strong id="cart_due" class="text-danger">₹0.00</strong>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-danger w-100" onclick="clearCart()"><i class="mdi mdi-refresh"></i> Clear</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-success w-100" id="btn_checkout" onclick="processCheckout()"><i class="mdi mdi-cash-multiple"></i> Pay</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let cart = {};

    // Live clock
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleString('en-IN', { dateStyle: 'medium', timeStyle: 'short' });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Fetch Products dynamically
    function fetchProducts() {
        let cat_id = $('#pos_category').val();
        let search = $('#pos_search').val();

        $.ajax({
            url: "{{ route('pos.products') }}",
            type: "GET",
            data: { category_id: cat_id, search: search },
            success: function(response) {
                $('#product_grid').html(response);
            }
        });
    }

    $('#pos_category').change(fetchProducts);
    $('#pos_search').on('keyup', fetchProducts);

    // Add to Cart
    function addToCart(id, name, price, stock) {
        if (stock <= 0) {
            toastr.error('Out of stock!');
            return;
        }

        if (cart[id]) {
            if (cart[id].qty >= stock) {
                toastr.warning('Cannot exceed available stock!');
                return;
            }
            cart[id].qty++;
        } else {
            cart[id] = { name: name, price: price, qty: 1, stock: stock };
        }
        renderCart();
    }

    // Update Cart Qty
    function updateQty(id, newQty) {
        newQty = parseInt(newQty);
        if (isNaN(newQty) || newQty <= 0) {
            delete cart[id];
        } else if (newQty > cart[id].stock) {
            toastr.warning('Only ' + cart[id].stock + ' available in stock.');
            cart[id].qty = cart[id].stock;
        } else {
            cart[id].qty = newQty;
        }
        renderCart();
    }

    // Remove from Cart
    function removeFromCart(id) {
        delete cart[id];
        renderCart();
    }

    // Clear Cart
    function clearCart() {
        cart = {};
        $('#pos_customer').val('');
        $('#cart_discount').val(0);
        $('#cart_tax_rate').val(0);
        $('#cart_paid').val(0);
        renderCart();
    }

    // Render Cart UI
    function renderCart() {
        let html = '';
        let subtotal = 0;

        for (let id in cart) {
            let item = cart[id];
            let itemTotal = item.price * item.qty;
            subtotal += itemTotal;

            html += `
                <tr>
                    <td>
                        <div class="fw-bold" style="font-size: 13px; line-height: 1.2;">${item.name}</div>
                        <small class="text-muted">₹${item.price.toFixed(2)}</small>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <button class="btn btn-outline-secondary px-2" type="button" onclick="updateQty(${id}, ${item.qty - 1})">-</button>
                            <input type="text" class="form-control text-center p-0" value="${item.qty}" onchange="updateQty(${id}, this.value)">
                            <button class="btn btn-outline-secondary px-2" type="button" onclick="updateQty(${id}, ${item.qty + 1})">+</button>
                        </div>
                    </td>
                    <td class="text-end fw-bold">₹${itemTotal.toFixed(2)}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-light text-danger p-1" onclick="removeFromCart(${id})"><i class="mdi mdi-close"></i></button>
                    </td>
                </tr>
            `;
        }

        if (Object.keys(cart).length === 0) {
            html = '<tr><td colspan="4" class="text-center text-muted py-4">Cart is empty</td></tr>';
        }

        $('#cart_body').html(html);
        $('#cart_subtotal').text('₹' + subtotal.toFixed(2));
        calculateTotals(subtotal);
    }

    // Calculate Totals
    function calculateTotals(subtotal) {
        let discount = parseFloat($('#cart_discount').val()) || 0;
        let taxRate = parseFloat($('#cart_tax_rate').val()) || 0;
        
        let afterDiscount = subtotal - discount;
        let taxAmount = (afterDiscount * taxRate) / 100;
        let grandTotal = afterDiscount + taxAmount;
        
        if (grandTotal < 0) grandTotal = 0;

        $('#cart_grand_total').text('₹' + grandTotal.toFixed(2));
        
        // Auto fill paid amount to full if it was 0 or equal to old grand total
        let paid = parseFloat($('#cart_paid').val()) || 0;
        
        let due = grandTotal - paid;
        if(due < 0) due = 0;

        $('#cart_due').text('₹' + due.toFixed(2));
    }

    $('#cart_discount, #cart_tax_rate, #cart_paid').on('input', function() {
        let subtotal = 0;
        for (let id in cart) subtotal += cart[id].price * cart[id].qty;
        calculateTotals(subtotal);
    });

    // Auto-fill full amount on double click
    $('#cart_paid').dblclick(function() {
        let subtotal = 0;
        for (let id in cart) subtotal += cart[id].price * cart[id].qty;
        let discount = parseFloat($('#cart_discount').val()) || 0;
        let taxRate = parseFloat($('#cart_tax_rate').val()) || 0;
        let grandTotal = (subtotal - discount) + ((subtotal - discount) * taxRate / 100);
        $(this).val(grandTotal.toFixed(2));
        $(this).trigger('input');
    });

    // Checkout
    function processCheckout() {
        if (Object.keys(cart).length === 0) {
            toastr.error('Cart is empty!');
            return;
        }

        let customer_id = $('#pos_customer').val();
        let warehouse_id = $('#pos_warehouse').val();

        if (!customer_id) { toastr.error('Please select a customer!'); return; }
        if (!warehouse_id) { toastr.error('Please select a warehouse!'); return; }

        let btn = $('#btn_checkout');
        btn.prop('disabled', true).html('<i class="mdi mdi-spin mdi-loading"></i> Processing...');

        let subtotal = 0;
        let products = {};
        
        for (let id in cart) {
            let item = cart[id];
            let itemTotal = item.price * item.qty;
            subtotal += itemTotal;
            
            products[id] = {
                quantity: item.qty,
                net_unit_cost: item.price,
                subtotal: itemTotal
            };
        }

        let discount = parseFloat($('#cart_discount').val()) || 0;
        let taxRate = parseFloat($('#cart_tax_rate').val()) || 0;
        let afterDiscount = subtotal - discount;
        let taxAmount = (afterDiscount * taxRate) / 100;
        let grandTotal = afterDiscount + taxAmount;
        let paidAmount = parseFloat($('#cart_paid').val()) || 0;
        let dueAmount = grandTotal - paidAmount;
        if(dueAmount < 0) dueAmount = 0;
        
        let payment_method = $('#cart_payment_method').val();

        let payload = {
            _token: "{{ csrf_token() }}",
            customer_id: customer_id,
            warehouse_id: warehouse_id,
            discount: discount,
            tax_rate: taxRate,
            tax_amount: taxAmount,
            grand_total: grandTotal,
            paid_amount: paidAmount,
            due_amount: dueAmount,
            payment_method: payment_method,
            products: products
        };

        $.ajax({
            url: "{{ route('pos.store') }}",
            type: "POST",
            data: payload,
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    clearCart();
                    // Open receipt in new tab
                    window.open(res.redirect_url, '_blank');
                }
            },
            error: function(err) {
                toastr.error('Something went wrong!');
                console.error(err);
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="mdi mdi-cash-multiple"></i> Pay');
            }
        });
    }

    // Initial render
    renderCart();

</script>
@endsection
