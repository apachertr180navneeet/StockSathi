@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content mt-3 px-2 px-md-3 px-lg-4">
        <div class="container-fluid">

            <div class="card-ui">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="page-header">Add Supplier</div>

                    <a href="{{ route('all.supplier') }}" class="btn btn-light btn-sm">
                        ← Back
                    </a>
                </div>

                <form id="myForm" action="{{ route('store.supplier') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-lg-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control"></textarea>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('all.supplier') }}" class="btn btn-light">Cancel</a>

                        <button class="btn btn-primary">
                            Save Supplier
                        </button>
                    </div>

                </form>

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
                        required: 'Please Enter Supplier Name',
                    },
                    email: {
                        required: 'Please Enter Supplier Email',
                    },
                    address: {
                        required: 'Please Enter Supplier address',
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
