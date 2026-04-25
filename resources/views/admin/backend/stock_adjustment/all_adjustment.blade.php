@extends('admin.admin_master')

@section('admin')

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Stock Adjustments</h4>
            <a href="{{ route('add.stock.adjustment') }}" class="btn btn-primary btn-sm">
                + Add Adjustment
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Ref No</th>
                                <th>Date</th>
                                <th>Warehouse</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($allData as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->reference_no }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                    <td>{{ $item->warehouse->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($item->type == 'Addition')
                                            <span class="badge bg-success">{{ $item->type }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $item->type }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('details.stock.adjustment', $item->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('delete.stock.adjustment', $item->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
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
