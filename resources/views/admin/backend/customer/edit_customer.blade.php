@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Edit Customer</h4>
            <a href="{{ route('all.customer') }}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                            <form id="myForm" action="{{ route('update.customer') }}" method="post" class="row g-3"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $customer->id }}">

                                <div class="form-group col-md-4">
                                    <label for="validationDefault01" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $customer->name }}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="validationDefault01" class="form-label">Customer Email</label>
                                    <input type="text" class="form-control" name="email"
                                        value="{{ $customer->email }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="validationDefault01" class="form-label">Customer Phone</label>
                                    <input type="text" class="form-control" name="phone"
                                        value="{{ $customer->phone }}">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="validationDefault01" class="form-label">Customer Address</label>
                                    <textarea name="address" class="form-control">{{ $customer->address }}</textarea>
                                </div>


                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Save Change</button>
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
                    address: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Customer Name',
                    },
                    email: {
                        required: 'Please Enter Customer Email',
                    },
                    address: {
                        required: 'Please Enter Customer address',
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
