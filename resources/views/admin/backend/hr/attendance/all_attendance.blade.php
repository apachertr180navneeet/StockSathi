@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Daily Attendance</h4>
            <a href="{{ route('add.attendance') }}" class="btn btn-primary btn-sm">
                + Mark Attendance
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="date" id="date_filter" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <select id="employee_filter" class="form-select">
                            <option value="">All Employees</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Data -->
                <div id="attendanceTable">
                    @include('admin.backend.hr.attendance.partials.attendance_table')
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function loadTable() {
                let date = $('#date_filter').val();
                let employee_id = $('#employee_filter').val();

                $.get("{{ route('all.attendance') }}", {
                    date: date,
                    employee_id: employee_id
                }, function(data) {
                    $('#attendanceTable').html(data);
                });
            }

            $('#date_filter, #employee_filter').change(function() {
                loadTable();
            });

            // 📄 Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let date = $('#date_filter').val();
                let employee_id = $('#employee_filter').val();

                $.get(url, {
                    date: date,
                    employee_id: employee_id
                }, function(data) {
                    $('#attendanceTable').html(data);
                });
            });

            // 🗑 Delete
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Delete this record?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('delete/attendance') }}/" + id,
                            type: "GET",
                            success: function(res) {
                                toastr.success(res.message);
                                loadTable();
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
