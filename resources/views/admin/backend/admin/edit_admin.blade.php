@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Edit Admin User</h4>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form action="{{ route('update.admin', $adminuser->id) }}" method="post" id="myForm">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ $adminuser->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ $adminuser->email }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone" value="{{ $adminuser->phone }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password (Leave blank to keep current)</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter new password">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" id="address" value="{{ $adminuser->address }}">
                            </div>

                            <div class="mb-3">
                                <label for="roles" class="form-label">Assign Role</label>
                                <select name="roles" class="form-select" id="roles">
                                    <option selected disabled>Select Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $adminuser->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Changes</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
