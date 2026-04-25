@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Product Batches</h4>
            <a href="{{ route('add.batch') }}" class="btn btn-primary btn-sm">+ Add Batch</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Product</th>
                                <th>Batch No</th>
                                <th>Expiry Date</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allData as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->product->name ?? 'N/A' }} ({{ $item->product->code ?? '' }})</td>
                                    <td>{{ $item->batch_no }}</td>
                                    <td>{{ $item->expiry_date ? date('d-m-Y', strtotime($item->expiry_date)) : 'N/A' }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>
                                        <a href="{{ route('edit.batch', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                                        <a href="{{ route('delete.batch', $item->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
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
@endsection
