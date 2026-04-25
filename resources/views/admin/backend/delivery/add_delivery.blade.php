@extends('admin.admin_master')
@section('admin')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Create Delivery for Sale #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('store.delivery') }}" method="post">
                                @csrf
                                <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Courier Name</label>
                                        <input type="text" name="courier_name" class="form-control" placeholder="e.g. FedEx, BlueDart, Person Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tracking Number</label>
                                        <input type="text" name="tracking_no" class="form-control" placeholder="Tracking ID if available">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Delivery Date</label>
                                        <input type="date" name="delivery_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" value="{{ $sale->customer->name }}" disabled>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Shipping Address</label>
                                    <textarea name="shipping_address" class="form-control" rows="3">{{ $sale->customer->address }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Special delivery instructions..."></textarea>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Create Delivery Record</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm bg-light">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="mdi mdi-information-outline me-1"></i> Sale Summary</h5>
                            <hr>
                            <p class="mb-1"><strong>Grand Total:</strong> ₹{{ number_format($sale->grand_total, 2) }}</p>
                            <p class="mb-1"><strong>Paid Amount:</strong> ₹{{ number_format($sale->paid_amount, 2) }}</p>
                            <p class="mb-1"><strong>Due Amount:</strong> <span class="text-danger">₹{{ number_format($sale->due_amount, 2) }}</span></p>
                            <p class="mb-0"><strong>Warehouse:</strong> {{ $sale->warehouse->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
