@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Stock Adjustment Details</h4>
            <a href="{{ route('all.stock.adjustment') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Reference No:</strong> {{ $adjustment->reference_no }}</p>
                        <p><strong>Date:</strong> {{ date('d-m-Y', strtotime($adjustment->date)) }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Warehouse:</strong> {{ $adjustment->warehouse->name ?? 'N/A' }}</p>
                        <p><strong>Type:</strong> 
                            @if($adjustment->type == 'Addition')
                                <span class="badge bg-success">{{ $adjustment->type }}</span>
                            @else
                                <span class="badge bg-danger">{{ $adjustment->type }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Reason:</strong> {{ $adjustment->reason ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="mb-3">Adjustment Items</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Quantity Adjusted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adjustment->items as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->product->code ?? 'N/A' }}</td>
                                    <td>{{ $item->qty }}</td>
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
