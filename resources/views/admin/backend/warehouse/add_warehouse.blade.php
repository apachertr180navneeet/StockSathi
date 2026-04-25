@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Add Warehouse</h4>
            <a href="{{ route('all.warehouse') }}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <form action="{{ route('store.warehouse') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-lg-6 mb-3">
                            <label>Warehouse Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label>City</label>
                            <input type="text" name="city" class="form-control">
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('all.warehouse') }}" class="btn btn-light">Cancel</a>

                        <button class="btn btn-primary">
                            Save Warehouse
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
