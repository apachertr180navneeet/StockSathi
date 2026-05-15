@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Edit Supplier</h4>
            <a href="{{ route('all.supplier') }}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                            <form id="myForm" action="{{ route('update.supplier') }}" method="POST">
                                @csrf

                                <input type="hidden" name="id" value="{{ $supplier->id }}">

                                <div class="row">

                                    <div class="col-lg-6 mb-3 form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" value="{{ old('name', $supplier->name) }}"
                                            class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-3 form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ old('email', $supplier->email) }}"
                                            class="form-control">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-3 form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}"
                                            class="form-control">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 mb-3 form-group">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control">{{ old('address', $supplier->address) }}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('all.supplier') }}" class="btn btn-light">Cancel</a>

                                    <button class="btn btn-primary">
                                        Update Supplier
                                    </button>
                                </div>

                            </form>
            </div>
        </div>

    </div>
</div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    address: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Supplier Name',
                    },
                    email: {
                        required: 'Please Enter Supplier Email',
                    },
                    phone: {
                        required: 'Please Enter Supplier Phone',
                        digits: 'Please enter only digits',
                        minlength: 'Phone must be exactly 10 digits',
                        maxlength: 'Phone must be exactly 10 digits',
                    },
                    address: {
                        required: 'Please Enter Supplier Address',
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
