@extends('admin.admin_master')

@section('admin')
    <style>
        body {
            background: #f4f6fb;
        }

        /* 💎 Card */
        .card-ui {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        /* Header */
        .page-header {
            font-size: 22px;
            font-weight: 600;
        }

        /* Input */
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        /* Button */
        .btn-primary {
            border-radius: 10px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            border: none;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .card-ui {
                padding: 18px;
            }
        }
    </style>

    <div class="content mt-3 px-2 px-md-3 px-lg-4">
        <div class="container-fluid">

            <div class="card-ui">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="page-header">Add Warehouse</div>

                    <a href="{{ route('all.warehouse') }}" class="btn btn-light btn-sm">
                        ← Back
                    </a>
                </div>

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
@endsection
