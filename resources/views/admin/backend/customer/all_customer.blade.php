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

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Customer</h4>
            <a href="{{ route('add.customer') }}" class="btn btn-primary btn-sm">
                + Add Customer
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
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($customer as $key => $item)
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
                                                <a href="{{ route('edit.customer', $item->id) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <a href="{{ route('delete.customer', $item->id) }}"
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

@endsection


@push('scripts')
<script>
    
</script>
@endpush
