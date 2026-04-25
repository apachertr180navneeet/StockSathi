@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Edit Employee</h4>

                        <form action="{{ route('update.employee') }}" method="POST" id="myForm">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $employee->id }}">

                            <div class="row mb-3">
                                <label for="employee_id" class="col-sm-2 col-form-label">Employee ID</label>
                                <div class="col-sm-4">
                                    <input name="employee_id" class="form-control" type="text" id="employee_id" value="{{ $employee->employee_id }}" required>
                                </div>
                                <label for="user_id" class="col-sm-2 col-form-label">Link User (Optional)</label>
                                <div class="col-sm-4">
                                    <select name="user_id" id="user_id" class="form-select">
                                        <option value="">None</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $employee->user_id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                                <div class="col-sm-4">
                                    <input name="first_name" class="form-control" type="text" id="first_name" value="{{ $employee->first_name }}" required>
                                </div>
                                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                                <div class="col-sm-4">
                                    <input name="last_name" class="form-control" type="text" id="last_name" value="{{ $employee->last_name }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-4">
                                    <input name="email" class="form-control" type="email" id="email" value="{{ $employee->email }}" required>
                                </div>
                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-4">
                                    <input name="phone" class="form-control" type="text" id="phone" value="{{ $employee->phone }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="department_id" class="col-sm-2 col-form-label">Department</label>
                                <div class="col-sm-4">
                                    <select name="department_id" id="department_id" class="form-select" required>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ $dept->id == $employee->department_id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="designation_id" class="col-sm-2 col-form-label">Designation</label>
                                <div class="col-sm-4">
                                    <select name="designation_id" id="designation_id" class="form-select" required>
                                        @foreach($designations as $desig)
                                            <option value="{{ $desig->id }}" {{ $desig->id == $employee->designation_id ? 'selected' : '' }}>{{ $desig->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="joining_date" class="col-sm-2 col-form-label">Joining Date</label>
                                <div class="col-sm-4">
                                    <input name="joining_date" class="form-control" type="date" id="joining_date" value="{{ $employee->joining_date->format('Y-m-d') }}" required>
                                </div>
                                <label for="base_salary" class="col-sm-2 col-form-label">Base Salary</label>
                                <div class="col-sm-4">
                                    <input name="base_salary" class="form-control" type="number" step="0.01" id="base_salary" value="{{ $employee->base_salary }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <textarea name="address" id="address" class="form-control" rows="3">{{ $employee->address }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" id="status" class="form-select">
                                        <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="on_leave" {{ $employee->status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                        <option value="terminated" {{ $employee->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                    </select>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Employee">
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
                employee_id: { required : true },
                first_name: { required : true },
                last_name: { required : true },
                email: { required : true, email: true },
                department_id: { required : true },
                designation_id: { required : true },
                joining_date: { required : true },
                base_salary: { required : true, number: true },
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.col-sm-4, .col-sm-10').append(error);
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
