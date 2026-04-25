@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Edit Warehouse</h4>
            <a href="{{ route('all.warehouse') }}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <form action="{{ route('update.warehouse') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" value="{{ $warehouse->id }}">

                    <div class="row">

                        <div class="col-lg-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ $warehouse->name }}" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ $warehouse->email }}" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" value="{{ $warehouse->phone }}" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label>City</label>
                            <input type="text" name="city" value="{{ $warehouse->city }}" class="form-control">
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('all.warehouse') }}" class="btn btn-light">Cancel</a>

                        <button class="btn btn-primary">
                            Update Warehouse
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
