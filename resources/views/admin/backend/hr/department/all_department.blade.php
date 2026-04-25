@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <!-- Unified Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">All Departments</h4>
            <a href="{{ route('add.department') }}" class="btn btn-primary btn-sm">
                + Add Department
            </a>
        </div>

        <!-- Unified Content Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Search -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Search departments...">
                </div>

                <!-- Data -->
                <div id="departmentTable">
                    @include('admin.backend.hr.department.partials.department_table')
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

            let delayTimer;

            function loadTable(search = '') {
                $.get("{{ route('all.department') }}", {
                    search: search
                }, function(data) {
                    $('#departmentTable').html(data);
                });
            }

            // 🔍 Search
            $('#search').keyup(function() {
                clearTimeout(delayTimer);
                let search = $(this).val();

                delayTimer = setTimeout(function() {
                    loadTable(search);
                }, 400);
            });

            // 📄 Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                let url = $(this).attr('href');
                let search = $('#search').val();

                $.get(url, {
                    search: search
                }, function(data) {
                    $('#departmentTable').html(data);
                });
            });

            // 🗑 Delete
            $(document).on('click', '.deleteBtn', function() {

                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete this department?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ url('delete/department') }}/" + id,
                            type: "GET", // Following the convention in web.php
                            success: function(res) {
                                if(res.status == 'success') {
                                    toastr.success(res.message);
                                    loadTable($('#search').val());
                                } else {
                                    toastr.error(res.message);
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
