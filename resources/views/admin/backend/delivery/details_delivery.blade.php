@extends('admin.admin_master')
@section('admin')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Delivery Details: {{ $delivery->delivery_no }}</h4>
                </div>
                <div class="text-end">
                    <a href="{{ route('all.delivery') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Delivery Info Card -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="card-title mb-0 text-white"><i class="mdi mdi-truck-delivery me-1"></i> Shipping Information</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Status</span>
                                    @if ($delivery->status == 'Pending')
                                        <span class="badge bg-warning text-dark">{{ $delivery->status }}</span>
                                    @elseif($delivery->status == 'Processing')
                                        <span class="badge bg-info">{{ $delivery->status }}</span>
                                    @elseif($delivery->status == 'Shipped')
                                        <span class="badge bg-primary">{{ $delivery->status }}</span>
                                    @elseif($delivery->status == 'Delivered')
                                        <span class="badge bg-success">{{ $delivery->status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $delivery->status }}</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Courier</span>
                                    <span class="fw-bold">{{ $delivery->courier_name ?? 'Not Assigned' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Tracking ID</span>
                                    <span class="fw-bold">{{ $delivery->tracking_no ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Delivery Date</span>
                                    <span class="fw-bold">{{ $delivery->delivery_date ? date('d M Y', strtotime($delivery->delivery_date)) : 'N/A' }}</span>
                                </li>
                            </ul>
                            <div class="mt-3">
                                <h6>Shipping Address:</h6>
                                <p class="text-muted mb-0 small">{{ $delivery->shipping_address }}</p>
                            </div>
                            @if($delivery->notes)
                            <div class="mt-3 p-2 bg-light border-start border-warning border-3">
                                <h6 class="fs-12 text-uppercase text-muted">Notes:</h6>
                                <p class="mb-0 small">{{ $delivery->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-dark text-white py-3">
                            <h5 class="card-title mb-0 text-white d-flex justify-content-between">
                                <span><i class="mdi mdi-receipt me-1"></i> Linked Sale #{{ str_pad($delivery->sale->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <small>Customer: {{ $delivery->sale->customer->name }}</small>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Unit Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($delivery->sale->saleItems as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-end">₹{{ number_format($item->net_unit_cost, 2) }}</td>
                                                <td class="text-end">₹{{ number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="fw-bold">
                                            <td colspan="3" class="text-end">Grand Total</td>
                                            <td class="text-end">₹{{ number_format($delivery->sale->grand_total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
