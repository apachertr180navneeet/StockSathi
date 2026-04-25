@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Edit Permission</h4>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form action="{{ route('update.permission') }}" method="post" id="myForm">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $permission->id }}">

                            <div class="mb-3">
                                <label for="name" class="form-label">Permission Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ $permission->name }}">
                            </div>

                            <div class="mb-3">
                                <label for="group_name" class="form-label">Group Name</label>
                                <select name="group_name" class="form-select" id="group_name">
                                    <option selected disabled>Select Group</option>
                                    <option value="brand" {{ $permission->group_name == 'brand' ? 'selected' : '' }}>Brand</option>
                                    <option value="warehouse" {{ $permission->group_name == 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                                    <option value="supplier" {{ $permission->group_name == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                    <option value="customer" {{ $permission->group_name == 'customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="category" {{ $permission->group_name == 'category' ? 'selected' : '' }}>Category</option>
                                    <option value="product" {{ $permission->group_name == 'product' ? 'selected' : '' }}>Product</option>
                                    <option value="purchase" {{ $permission->group_name == 'purchase' ? 'selected' : '' }}>Purchase</option>
                                    <option value="sale" {{ $permission->group_name == 'sale' ? 'selected' : '' }}>Sale</option>
                                    <option value="transfer" {{ $permission->group_name == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                    <option value="report" {{ $permission->group_name == 'report' ? 'selected' : '' }}>Report</option>
                                    <option value="role" {{ $permission->group_name == 'role' ? 'selected' : '' }}>Role</option>
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
