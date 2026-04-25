@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Payroll Management</h4>
            <a href="{{ route('add.payroll') }}" class="btn btn-primary btn-sm">
                + Create Payroll
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select id="year_filter" class="form-select">
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="month_filter" class="form-select">
                            <option value="">All Months</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Data -->
                <div id="payrollTable">
                    @include('admin.backend.hr.payroll.partials.payroll_table')
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
                let month = $('#month_filter').val();
                let year = $('#year_filter').val();

                $.get("{{ route('all.payroll') }}", {
                    month: month,
                    year: year
                }, function(data) {
                    $('#payrollTable').html(data);
                });
            }

            $('#month_filter, #year_filter').change(function() {
                loadTable();
            });

            // 📄 Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let month = $('#month_filter').val();
                let year = $('#year_filter').val();

                $.get(url, {
                    month: month,
                    year: year
                }, function(data) {
                    $('#payrollTable').html(data);
                });
            });

            // 🗑 Delete
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Delete this payroll record?',
                    icon: 'warning',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('delete/payroll') }}/" + id,
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
