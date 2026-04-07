@extends('admin.admin_master')

@section('admin')

<style>
    /* Responsive Table */
    @media (max-width: 768px) {
        .table td, .table th {
            white-space: nowrap;
            font-size: 12px;
        }

        .btn-sm {
            padding: 4px 6px;
            font-size: 11px;
        }
    }

    @media (max-width: 576px) {
        .py-3 {
            gap: 10px;
        }

        .btn-sm {
            font-size: 12px;
            padding: 6px 10px;
        }
    }
</style>

<div class="content">

    <div class="container-xxl">

        <!-- Header -->
        <div class="py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="fs-18 fw-semibold m-0">All Supplier</h4>

            <a href="{{ route('add.supplier') }}" class="btn btn-primary btn-sm">
                + Add Supplier
            </a>
        </div>

        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header"></div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Supplier Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($supplier as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>

                                            <!-- Address with tooltip -->
                                            <td title="{{ $item->address }}">
                                                {{ \Illuminate\Support\Str::limit($item->address, 30, '...') }}
                                            </td>

                                            <td>
                                                <a href="{{ route('edit.supplier', $item->id) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <a href="{{ route('delete.supplier', $item->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete">Delete</a>
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


@push('scripts')

@endpush