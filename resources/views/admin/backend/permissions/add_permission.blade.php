@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Add Permission</h4>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form action="{{ route('store.permission') }}" method="post" id="myForm">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Permission Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Permission Name">
                            </div>

                            <div class="mb-3">
                                <label for="group_name" class="form-label">Group Name</label>
                                <select name="group_name" class="form-select" id="group_name">
                                    <option selected disabled>Select Group</option>
                                    <option value="brand">Brand</option>
                                    <option value="warehouse">Warehouse</option>
                                    <option value="supplier">Supplier</option>
                                    <option value="customer">Customer</option>
                                    <option value="category">Category</option>
                                    <option value="product">Product</option>
                                    <option value="purchase">Purchase</option>
                                    <option value="sale">Sale</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="report">Report</option>
                                    <option value="role">Role</option>
                                </select>
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
