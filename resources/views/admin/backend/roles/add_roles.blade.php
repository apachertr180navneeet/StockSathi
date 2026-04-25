@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Add Roles</h4>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form action="{{ route('store.roles') }}" method="post" id="myForm">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Roles Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Role Name">
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
