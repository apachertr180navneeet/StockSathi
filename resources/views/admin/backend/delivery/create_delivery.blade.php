@extends('admin.admin_master')
@section('admin')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Select Sale for Delivery</h4>
                    <p class="text-muted mb-0">Showing sales that are ready for shipment</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sale #</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Grand Total</th>
                                            <th>Warehouse</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $item)
                                            <tr>
                                                <td><span class="fw-bold">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                                                <td>{{ $item->customer->name }}</td>
                                                <td>{{ date('d M Y', strtotime($item->date)) }}</td>
                                                <td class="fw-bold">₹{{ number_format($item->grand_total, 2) }}</td>
                                                <td>{{ $item->warehouse->name }}</td>
                                                <td>
                                                    <a href="{{ route('add.delivery', $item->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="mdi mdi-truck-delivery me-1"></i> Create Delivery
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
