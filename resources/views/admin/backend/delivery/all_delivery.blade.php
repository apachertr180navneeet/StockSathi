@extends('admin.admin_master')
@section('admin')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Delivery Management</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Delivery #</th>
                                            <th>Sale #</th>
                                            <th>Customer</th>
                                            <th>Courier</th>
                                            <th>Tracking #</th>
                                            <th>Status</th>
                                            <th>Delivery Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $item)
                                            <tr>
                                                <td><span class="fw-bold text-primary">{{ $item->delivery_no }}</span></td>
                                                <td>#{{ str_pad($item->sale->id, 5, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $item->sale->customer->name }}</td>
                                                <td>{{ $item->courier_name ?? 'N/A' }}</td>
                                                <td>{{ $item->tracking_no ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($item->status == 'Pending')
                                                        <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                                    @elseif($item->status == 'Processing')
                                                        <span class="badge bg-info">{{ $item->status }}</span>
                                                    @elseif($item->status == 'Shipped')
                                                        <span class="badge bg-primary">{{ $item->status }}</span>
                                                    @elseif($item->status == 'Delivered')
                                                        <span class="badge bg-success">{{ $item->status }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $item->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->delivery_date ? date('d M Y', strtotime($item->delivery_date)) : 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('edit.delivery', $item->id) }}" class="btn btn-success btn-sm" title="Update Delivery">
                                                        <i class="mdi mdi-truck-delivery mdi-18px"></i>
                                                    </a>
                                                    <a href="{{ route('delete.delivery', $item->id) }}" class="btn btn-danger btn-sm" id="delete" title="Delete">
                                                        <i class="mdi mdi-delete-circle mdi-18px"></i>
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
