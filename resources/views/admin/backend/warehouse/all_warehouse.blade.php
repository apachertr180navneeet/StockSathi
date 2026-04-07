@extends('admin.admin_master')
@section('admin')
    <style>
        .brand-img {
            width: 70px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            .table td, .table th {
                white-space: nowrap;
                font-size: 12px;
            }

            .btn-sm {
                padding: 4px 6px;
                font-size: 11px;
            }

            .brand-img {
                width: 50px;
                height: 30px;
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

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex justify-content-between align-items-center flex-wrap">

                <!-- Left -->
                <h4 class="fs-18 fw-semibold m-0">All WareHouse</h4>

                <!-- Right -->
                <a href="{{ route('add.warehouse') }}" class="btn btn-primary btn-sm">
                    + Add WareHouse
                </a>

            </div>

            <!-- Datatables  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <!-- Optional: you can add title here if needed -->
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>WareHouse Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($warehouse as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->city }}</td>
                                                <td>
                                                    <a href="{{ route('edit.warehouse', $item->id) }}"
                                                        class="btn btn-success btn-sm">Edit</a>
                                                    <a href="{{ route('delete.warehouse', $item->id) }}"
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
        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection
