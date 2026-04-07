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
    
                <!-- Left Side: Title -->
                <h4 class="fs-18 fw-semibold m-0">All Brand</h4>

                <!-- Right Side: Button -->
                <a href="{{ route('add.brand') }}" class="btn btn-primary btn-sm">
                    + Add Brand
                </a>

            </div>

            <!-- Datatables  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">

                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Brand Name</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brand as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <img src="{{ asset($item->image) }}" class="brand-img">
                                                </td>
                                                <td>
                                                    <a href="{{ route('edit.brand', $item->id) }}"
                                                        class="btn btn-success btn-sm">Edit</a>
                                                    <a href="{{ route('delete.brand', $item->id) }}"
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
