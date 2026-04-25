@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Admin Users</h4>
            <a href="{{ route('add.admin') }}" class="btn btn-primary btn-sm">
                + Add Admin User
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alladmin as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <img src="{{ (!empty($item->photo)) ? url('upload/admin_images/'.$item->photo) : url('upload/no_image.jpg') }}" alt="User Image" style="width: 40px; height: 40px;" class="rounded-circle">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @foreach($item->roles as $role)
                                    <span class="badge badge-soft-info">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('edit.admin',$item->id) }}" class="btn btn-info btn-sm" title="Edit Data"> <i data-feather="edit"></i></a>
                                    <a href="{{ route('delete.admin',$item->id) }}" class="btn btn-danger btn-sm" id="delete" title="Delete Data"> <i data-feather="trash-2"></i></a>
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
