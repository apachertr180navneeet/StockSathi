@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Roles</h4>
            <a href="{{ route('add.roles') }}" class="btn btn-primary btn-sm">
                + Add Roles
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sl</th>
                                <th>Roles Name</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-end">
                                    <a href="{{ route('edit.roles',$item->id) }}" class="btn btn-info btn-sm" title="Edit Data"> <i data-feather="edit"></i></a>
                                    <a href="{{ route('delete.roles',$item->id) }}" class="btn btn-danger btn-sm" id="delete" title="Delete Data"> <i data-feather="trash-2"></i></a>
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
