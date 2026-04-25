@extends('admin.admin_master')
@section('admin')
<div class="content">
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Purchase Order Details: {{ $order->po_no }}</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('invoice.purchase.order', $order->id) }}" class="btn btn-primary me-2"><i class="fas fa-download"></i> PDF</a>
                <a href="{{ route('all.purchase.order') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h5 class="text-primary">Supplier Info</h5>
                                <strong>{{ $order->supplier->name }}</strong><br>
                                {{ $order->supplier->email }}<br>
                                {{ $order->supplier->mobile_no }}<br>
                                {{ $order->supplier->address }}
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-primary">Warehouse Info</h5>
                                <strong>{{ $order->warehouse->name }}</strong><br>
                                {{ $order->warehouse->address }}
                            </div>
                            <div class="col-md-4 text-md-end">
                                <h5 class="text-primary">Order Info</h5>
                                <strong>PO No:</strong> {{ $order->po_no }}<br>
                                <strong>Date:</strong> {{ $order->date }}<br>
                                <strong>Status:</strong> 
                                @if($order->status == 'Draft')
                                    <span class="badge bg-warning">Draft</span>
                                @elseif($order->status == 'Ordered')
                                    <span class="badge bg-primary">Ordered</span>
                                @elseif($order->status == 'Received')
                                    <span class="badge bg-success">Received</span>
                                @else
                                    <span class="badge bg-danger">{{ $order->status }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th class="text-end">Unit Cost</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Tax</th>
                                        <th class="text-end">Discount</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->product->name }} ({{ $item->product->product_code }})</td>
                                            <td class="text-end">₹{{ number_format($item->unit_cost, 2) }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">₹{{ number_format($item->tax_amount, 2) }} ({{ $item->tax_rate }}%)</td>
                                            <td class="text-end">₹{{ number_format($item->discount, 2) }}</td>
                                            <td class="text-end">₹{{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-end">Order Tax ({{ $order->tax_rate }}%)</th>
                                        <td class="text-end">₹{{ number_format($order->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="6" class="text-end">Order Discount</th>
                                        <td class="text-end">₹{{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="6" class="text-end">Shipping</th>
                                        <td class="text-end">₹{{ number_format($order->shipping, 2) }}</td>
                                    </tr>
                                    <tr class="fs-18 fw-bold">
                                        <th colspan="6" class="text-end text-primary">Grand Total</th>
                                        <td class="text-end text-primary">₹{{ number_format($order->grand_total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($order->note)
                            <div class="mt-4">
                                <h5 class="text-primary">Note</h5>
                                <p>{{ $order->note }}</p>
                            </div>
                        @endif

                        <div class="mt-4 text-muted small">
                            Created By: {{ $order->createdBy->name ?? 'System' }} at {{ $order->created_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
