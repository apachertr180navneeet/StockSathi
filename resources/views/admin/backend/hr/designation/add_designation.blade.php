@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Add Designation</h4>

                        <form action="{{ route('store.designation') }}" method="POST" id="myForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="department_id" class="col-sm-2 col-form-label">Department</label>
                                <div class="col-sm-10">
                                    <select name="department_id" id="department_id" class="form-select" required>
                                        <option value="" selected disabled>Select Department</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Designation Name</label>
                                <div class="col-sm-10">
                                    <input name="name" class="form-control" type="text" id="name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Designation">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                department_id: { required : true },
                name: { required : true }, 
            },
            messages :{
                department_id: { required : 'Please Select Department' },
                name: { required : 'Please Enter Designation Name' },
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.col-sm-10').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>
@endsection
