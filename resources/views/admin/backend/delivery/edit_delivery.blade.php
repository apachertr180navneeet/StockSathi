@extends('admin.admin_master')
@section('admin')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Update Delivery: {{ $delivery->delivery_no }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('update.delivery') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $delivery->id }}">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Courier Name</label>
                                        <input type="text" name="courier_name" class="form-control" value="{{ $delivery->courier_name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tracking Number</label>
                                        <input type="text" name="tracking_no" class="form-control" value="{{ $delivery->tracking_no }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Delivery Date</label>
                                        <input type="date" name="delivery_date" class="form-control" value="{{ $delivery->delivery_date }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Delivery Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="Pending" {{ $delivery->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Processing" {{ $delivery->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="Shipped" {{ $delivery->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="Delivered" {{ $delivery->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="Cancelled" {{ $delivery->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Shipping Address</label>
                                    <textarea name="shipping_address" class="form-control" rows="3">{{ $delivery->shipping_address }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="2">{{ $delivery->notes }}</textarea>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Update Delivery Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-start border-primary border-3">
                        <div class="card-body">
                            <h5 class="card-title">Sale #{{ str_pad($delivery->sale->id, 5, '0', STR_PAD_LEFT) }}</h5>
                            <hr>
                            <p class="mb-1"><strong>Customer:</strong> {{ $delivery->sale->customer->name }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $delivery->sale->customer->phone }}</p>
                            <p class="mb-1"><strong>Amount:</strong> ₹{{ number_format($delivery->sale->grand_total, 2) }}</p>
                            <p class="mb-0"><strong>Payment:</strong> {{ $delivery->sale->payment_method }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
