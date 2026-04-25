@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Mark Attendance</h4>

                        <form action="{{ route('store.attendance') }}" method="POST">
                            @csrf

                            <div class="row mb-4">
                                <label for="date" class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <input name="date" class="form-control" type="date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Employee</th>
                                            <th>Status</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $emp)
                                        <tr>
                                            <td>
                                                {{ $emp->first_name }} {{ $emp->last_name }}
                                                <input type="hidden" name="attendance[{{ $emp->id }}][employee_id]" value="{{ $emp->id }}">
                                            </td>
                                            <td>
                                                <select name="attendance[{{ $emp->id }}][status]" class="form-select form-select-sm">
                                                    <option value="Present">Present</option>
                                                    <option value="Absent">Absent</option>
                                                    <option value="Late">Late</option>
                                                    <option value="Half Day">Half Day</option>
                                                    <option value="On Leave">On Leave</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="time" name="attendance[{{ $emp->id }}][check_in_time]" class="form-control form-control-sm" value="09:00">
                                            </td>
                                            <td>
                                                <input type="time" name="attendance[{{ $emp->id }}][check_out_time]" class="form-control form-control-sm" value="18:00">
                                            </td>
                                            <td>
                                                <input type="text" name="attendance[{{ $emp->id }}][note]" class="form-control form-control-sm">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <input type="submit" class="btn btn-primary" value="Save Attendance">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
