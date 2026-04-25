@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Edit Department</h4>

                        <form action="{{ route('update.department') }}" method="POST" id="myForm">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $department->id }}">

                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Department Name</label>
                                <div class="col-sm-10">
                                    <input name="name" class="form-control" type="text" id="name" value="{{ $department->name }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" class="form-control" rows="3">{{ $department->description }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" id="status" class="form-select">
                                        <option value="1" {{ $department->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $department->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Department">
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
                name: {
                    required : true,
                }, 
            },
            messages :{
                name: {
                    required : 'Please Enter Department Name',
                },
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
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
