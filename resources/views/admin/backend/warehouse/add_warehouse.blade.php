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

    <div class="content mt-4">
        <div class="container-fluid">

            <div class="card-ui">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div class="page-header">Add Warehouse</div>

                    <a href="{{ route('all.warehouse') }}" class="btn btn-light btn-sm">
                        ← Back
                    </a>
                </div>

                <form action="{{ route('store.warehouse') }}" method="POST">
                    @csrf

                    <div class="row">

                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label class="mb-2">Warehouse Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter warehouse name">

                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="mb-2">Warehouse Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Enter email">

                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label class="mb-2">Warehouse Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone">

                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="col-md-6 mb-3">
                            <label class="mb-2">Warehouse City</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                class="form-control @error('city') is-invalid @enderror" placeholder="Enter city">

                            @error('city')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="text-end mt-3">
                        <button class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save me-1"></i> Save Warehouse
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection
